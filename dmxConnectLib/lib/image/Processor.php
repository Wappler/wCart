<?php

// read/write IPTC and EXIF data
// http://php.net/manual/en/function.iptcembed.php#113877

namespace lib\image;

class Processor extends \lib\core\NamedSingleton
{
    public $width = 0;
    public $height = 0;

    private $image;

    public static function getImageSize($filename) {
        $size = getimagesize($filename);

        return (object)array(
            'width' => $size[0],
            'height' => $size[1]
        );
    }

	public function __destruct() {
		imagedestroy($this->image);
	}

    public function load($filename, $autoOrient = FALSE) {
        $this->image = imagecreatefromstring(file_get_contents($filename));

		if (!imageistruecolor($this->image)) {
			$this->imagepalettetotruecolor($this->image);
		}

		if ($autoOrient) {
			$this->autoOrient($filename);
		}

        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    public function save($filename, $options = NULL) {
        if (!isset($options)) {
            $options = (object)array();
        }

		if (!isset($options->format)) {
			$options->format = 'auto';
		}

        if (!preg_match('/^(jpe?g|png|gif)$/i', $options->format)) {
            $options->format = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        }

        switch (strtolower($options->format)) {
            case 'jpg':
			case 'jpeg':
                $this->saveJPEG($filename, $options->quality);
                break;
            case 'png':
                $this->savePNG($filename);
                break;
            case 'gif':
                $this->saveGIF($filename);
                break;
            default:
                // ERROR
        }
    }

    public function saveJPEG($filename, $quality = 75) {
        return imagejpeg($this->image, $filename, $quality);
    }

    public function savePNG($filename) {
        imagealphablending($this->image, FALSE);
		imagesavealpha($this->image, TRUE);
        return imagepng($this->image, $filename);
    }

    public function saveGIF($filename, $maxColors = 256) {
		imagecolortransparent($this->image, $this->transparent());
        imagetruecolortopalette($this->image, TRUE, $maxColors);
        return imagegif($this->image, $filename);
    }

    public function resize($width, $height) {
        $width = $this->cw($width);
		$height = $this->ch($height);

        $image = imagecreatetruecolor($width, $height);
		imagefill($image, 0, 0, $this->transparent());

        if (imagecopyresampled($image, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height)) {
            imagedestroy($this->image);
            $this->image = $image;
            $this->width = $width;
            $this->height = $height;
            return TRUE;
        }

        imagedestroy($image);

        return FALSE;
    }

    public function crop($x, $y, $width, $height) {
		$width = $this->cw($width);
		$height = $this->ch($height);
		$x = $this->cx($x, $width, FALSE);
		$y = $this->cy($y, $height, FALSE);

        $image = imagecreatetruecolor($width, $height);
		imagefill($image, 0, 0, $this->transparent());

        if (imagecopy($image, $this->image, 0, 0, $x, $y, $width, $height)) {
            imagedestroy($this->image);
            $this->image = $image;
            $this->width = $width;
            $this->height = $height;
            return TRUE;
        }

        imagedestroy($image);

        return FALSE;
    }

	public function watermark($x, $y, $filename) {
		$watermark = imagecreatefromstring(file_get_contents($filename));
		$width = imagesx($watermark);
		$height = imagesy($watermark);

		$x = $this->cx($x, $width, FALSE);
		$y = $this->cy($y, $height, FALSE);

		imagealphablending($this->image, TRUE);
		imagealphablending($watermark, TRUE);

		$success = imagecopy($this->image, $watermark, $x, $y, 0, 0, $width, $height);

		imagedestroy($watermark);

		return $success;
	}

	public function text($x, $y, $text, $font, $size = 24, $color = 0xFFFFFF) {
		$bbox = imagettfbbox($size, 0, $font, $text);

		$maxX = max($bbox[0], $bbox[2], $bbox[4], $bbox[6]);
		$minX = min($bbox[0], $bbox[2], $bbox[4], $bbox[6]);
		$maxY = max($bbox[1], $bbox[3], $bbox[5], $bbox[7]);
		$minY = min($bbox[1], $bbox[3], $bbox[5], $bbox[7]);

		$width = $maxX - $minX;
		$height = $maxY - $minY;

		$x = $this->cx($x, $width, FALSE);
		$y = $this->cy($y, $height, FALSE);

		imagealphablending($this->image, TRUE);

		return imagettftext($this->image, $size, 0, $x - $minX, $y + $height - $maxY, $color, $font, $text);
	}

	public function tiled($filename, $padding = 0) {
		$image = imagecreatefromstring(file_get_contents($filename));
		$width = imagesx($image);
		$height = imagesy($image);

		$tile = imagecreatetruecolor($width + $padding, $height + $padding);
		imagefill($tile, 0, 0, $this->transparent());
		imagecopy($tile, $image, $padding, $padding, 0, 0, $width, $height);

		imagesettile($this->image, $tile);
		imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, IMG_COLOR_TILED);

		imagedestroy($image);
		imagedestroy($tile);
	}

    public function autoOrient($filename) {
        try {
            if (function_exists('exif_imagetype') && exif_imagetype($filename) == IMAGETYPE_JPEG) {
                $exif = @exif_read_data($filename);
                if (isset($exif) && !empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 2:
                            $this->flipHorizontal();
                            break;
                        case 3:
                            $this->rotate(180);
                            break;
                        case 4:
                            $this->flipVertical();
                            break;
                        case 5:
                            $this->rotate(270);
                            $this->flipHorizontal();
                            break;
                        case 6:
                            $this->rotate(270);
                            break;
                        case 7:
                            $this->rotate(90);
                            $this->flipHorizontal();
                            break;
                        case 8:
                            $this->rotate(90);
                            break;
                    }
                }
            }
        } catch (Exception $e) {
            // some error, ignore it and do nothing
        }
    }

    public function flip($mode) {
		return imageflip($this->image, $mode);
	}

    public function flipHorizontal() {
        return imageflip($this->image, IMG_FLIP_HORIZONTAL);
    }

    public function flipVertical() {
        return imageflip($this->image, IMG_FLIP_VERTICAL);
    }

    public function flipBoth() {
        return imageflip($this->image, IMG_FLIP_BOTH);
    }

    public function rotate($degrees) {
        $this->image = imagerotate($this->image, $degrees, $this->transparent());
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    public function rotateLeft() {
        $this->rotate(90);
    }

    public function rotateRight() {
        $this->rotate(270);
    }

    public function smooth() {
        return $this->conv(array(
            array( 1, 1, 1 ),
            array( 1, 1, 1 ),
            array( 1, 1, 1 )
        ));
    }

    public function blur() {
        return $this->conv(array(
            array( 1, 2, 1 ),
            array( 2, 4, 2 ),
            array( 1, 2, 1 )
        ));
    }

    public function sharpen() {
        return $this->conv(array(
            array(  0, -2,  0 ),
            array( -2, 15, -2 ),
            array(  0, -2,  0 )
        ));
    }

    public function meanRemoval() {
        return $this->conv(array(
            array( -1, -1, -1 ),
            array( -1,  9, -1 ),
            array( -1, -1, -1 )
        ));
    }

    public function emboss() {
        return $this->conv(array(
            array( -1,  0, -1 ),
            array(  0,  4,  0 ),
            array( -1,  0, -1 )
        ), 127);
    }

    public function edgeDetect() {
        return $this->conv(array(
            array( -1, -1, -1 ),
            array(  0,  0,  0 ),
            array(  1,  1,  1 )
        ), 127);
    }

    public function grayscale() {
        return imagefilter($this->image, IMG_FILTER_GRAYSCALE);
    }

    public function sepia() {
        return imagefilter($this->image, IMG_FILTER_GRAYSCALE)
            && imagefilter($this->image, IMG_FILTER_COLORIZE, 112, 66, 20);
    }

    public function invert() {
        return imagefilter($this->image, IMG_FILTER_NEGATE);
    }

    protected function conv($matrix, $offset = 0) {
        $div = array_sum(array_map('array_sum', $matrix));
        return imageconvolution($this->image, $matrix, $div, $offset);
    }

	public function transparent() {
		return imagecolorallocatealpha($this->image, 0, 0, 0, 127);
	}

	public function cw($width) {
		if (is_string($width)) {
			if (preg_match('/%$/', $width)) {
				$width = $this->width * ((int)$width / 100);
			}
		}

		if ($width < 0) {
			$width = $this->width - abs($width);
		}

		$width = (int)$width;

		return $width;
	}

	public function ch($height) {
		if (is_string($height)) {
			if (preg_match('/%$/', $height)) {
				$height = $this->height * ((int)$height / 100);
			}
		}

		if ($height < 0) {
			$height = $this->height - abs($height);
		}

		$height = (int)$height;

		return $height;
	}

	public function cx($x, $width = 0, $checkRange = TRUE) {
		if (is_string($x)) {
			switch ($x) {
				case 'left':
					$x = 0;
					break;
				case 'center':
					$x = ($this->width - $width) / 2;
					break;
				case 'right';
					$x = $this->width - $width;
					break;
				default:
					if (preg_match('/%$/', $x)) {
						$x = ($this->width - $width) * ((int)$x / 100);
					}
			}
		} elseif ($x < 0) {
			$x = $this->width - $width - abs($x);
		}

		$x = (int)$x;

		if ($checkRange && ($x < 0 || $x > $this->width - $width)) {
			throw new \Exception('value is out of range.');
		}

		return $x;
	}

	public function cy($y, $height = 0, $checkRange = TRUE) {
		if (is_string($y)) {
			switch ($y) {
				case 'top':
					$y = 0;
					break;
				case 'middle':
					$y = ($this->height - $height) / 2;
					break;
				case 'bottom';
					$y = $this->height - $height;
					break;
				default:
					if (preg_match('/%$/', $y)) {
						$y = ($this->height - $height) * ((int)$y / 100);
					}
			}
		} elseif ($y < 0) {
			$y = $this->height - $height - abs($y);
		}

		$y = (int)$y;

		if ($checkRange && ($y < 0 || $y > $this->height - $height)) {
			throw new \Exception('value is out of range.');
		}

		return $y;
	}

    public function imagepalettetotruecolor(&$image) {
		if(imageistruecolor($image)) {
			return TRUE;
		}

		$width = imagesx($image);
		$height = imagesy($image);
		$transparent = imagecolortransparent($image);

		$im = imagecreatetruecolor($width, $height);

		imagealphablending($im, FALSE);

		for ($x = 0; $x < $width; $x++) {
			for ($y = 0; $y < $height; $y++) {
				$color = imagecolorat($image, $x, $y);
				$rgba = imagecolorsforindex($image, $color);

				if ($color == $transparent) {
					imagesetpixel($im, $x, $y, imagecolorallocatealpha($im, 0, 0, 0, 127));
				} else {
					imagesetpixel($im, $x, $y, imagecolorallocate($im, $rgba['red'], $rgba['green'], $rgba['blue']));
				}
			}
		}

		imagedestroy($image);
		$image = $im;
	}
}

if (!function_exists('imageflip')) {
    define('IMG_FLIP_HORIZONTAL', 1);
    define('IMG_FLIP_VERTICAL', 2);
    define('IMG_FLIP_BOTH', 3);

    function imageflip(&$image, $mode) {
        switch ($mode) {
            case IMG_FLIP_HORIZONTAL:
                $sx = imagesx($image);
                $sy = imagesy($image);
                $im = imagecreatetruecolor($sx, $sy);
				imagealphablending($im, FALSE);
                if (imagecopyresampled($im, $image, 0, 0, $sx - 1, 0, $sx, $sy, -$sx, $sy)) {
					imagedestroy($image);
                    $image = $im;
                    return TRUE;
                }
                break;

            case IMG_FLIP_VERTICAL:
                $sx = imagesx($image);
                $sy = imagesy($image);
                $im = imagecreatetruecolor($sx, $sy);
				imagealphablending($im, FALSE);
                if (imagecopyresampled($im, $image, 0, 0, 0, $sy - 1, $sx, $sy, $sx, -$sy)) {
					imagedestroy($image);
                    $image = $im;
                    return TRUE;
                }
                break;

            case IMG_FLIP_BOTH:
                $image = imagerotate($image, 180, 0);
                return TRUE;
                break;
        }

        return FALSE;
    }
}
