<?php

namespace lib\zip;

class Processor
{
    public static function zip($options) {
        $zip = ZipProcessor::create($options->zipfile);
        $zip->addFiles($options->files);
        $zip->setArchiveComment($options->comment);
        $zip->save();

        return $options->zipfile;
    }

    public static function zipdir($options) {
        $zip = ZipProcessor::create($options->zipfile);
        $zip->addDir($options->path, '', $options->recursive);
        $zip->setArchiveComment($options->comment);
        $zip->save();

        return $options->zipfile;
    }

    public static function unzip($options) {
        $zip = ZipProcessor::read($options->zipfile);
        $zip->extractTo($options->destination);
        $zip->close();

        return TRUE;
    }

    public static function dir($options) {
        $zip = ZipProcessor::read($options->zipfile);
        $entries = $zip->entries();
        $zip->close();

        return $entries;
    }

    public static function comment($options) {
        $zip = ZipProcessor::read($options->zipfile);
        $comment = $zip->getArchiveComment();
        $zip->close();

        return $comment;
    }
}

class ZipProcessor extends \ZipArchive
{
    public static function create($zipfile) {
        $zip = new ZipProcessor();

		if ($zip->open($zipfile, self::CREATE | self::OVERWRITE) !== TRUE) {
			throw new \Exception('Error creating zipfile ' . $zipfile);
		}

        return $zip;
    }

    public static function read($zipfile) {
        $zip = new ZipProcessor();

		if ($zip->open($zipfile) !== TRUE) {
			throw new \Exception('Error opening zipfile ' . $zipfile);
		}

        return $zip;
    }

    public function addFiles($files) {
        $success = TRUE;

        foreach ($files as $file) {
            $success = $success && $this->addFile($file, basename($file));
        }

        return $success;
    }

    public function addDir($path, $localpath = '', $recursive = FALSE) {
		$success = TRUE;

		$iterator = new \DirectoryIterator($path);

		foreach ($iterator as $entry) {
			if ($entry->isDot()) {
				continue;
			}

			if ($recursive && $entry->isDir()) {
                $this->addEmptyDir($localpath . $entry->getBasename() . '/');
				$success = $success && $this->addDir($entry->getPathname(), $localpath . $entry->getBasename() . '/', TRUE);
			}

			if ($entry->isFile()) {
				$success = $success && $this->addFile($entry->getPathname(), $localpath . $entry->getFilename());
			}
		}

		return $success;
    }

    public function entries() {
        $entries = array();

        for ($i = 0; $i < $this->numFiles; $i++) {
            $stat = $this->statIndex($i);
            $entries[] = array(
                'type' => substr($stat['name'], -1) == '/' ? 'dir' : 'file',
                'path' => $stat['name'],
                'size' => $stat['size'],
                'compressedSize' => $stat['comp_size'],
                'compressionMethod' => $stat['comp_method'] == 8 ? 'Deflate' : 'None',
                'lastModified' => $stat['mtime']
            );
        }

        return $entries;
    }

    public function save() {
        return $this->close();
    }
}
