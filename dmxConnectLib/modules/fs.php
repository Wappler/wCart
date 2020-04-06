<?php

namespace modules;

use \lib\core\Module;
use \lib\core\FileSystem;
use \lib\core\Path;

class fs extends Module
{
    public function download($options) {
        option_require($options, 'path');

        $options = $this->app->parseObject($options);

        $path = Path::toSystemPath($options->path);

        if (FileSystem::isfile($path)) {
            set_time_limit(0);
            
            ignore_user_abort(false);
            
            ini_set('output_buffering', 0);
            ini_set('zlib.output_compression', 0);

            $filename = basename($path);

            if (isset($options->filename)) {
                $filename = $options->filename;
            }

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($path));
            
            readfile($path);
        }

        exit();
    }

    public function exists($options) {
		option_require($options, 'path');

        $options->path = $this->app->parseObject($options->path);

        $path = Path::toSystemPath($options->path);

        if (FileSystem::isfile($path)) {
            if (isset($options->then)) {
                $this->app->exec($options->then, TRUE);
            }
            return TRUE;
        } else {
            if (isset($options->else)) {
                $this->app->exec($options->else, TRUE);
            }
            return FALSE;
        }
    }

    public function direxists($options) {
        option_require($options, 'path');

        $options->path = $this->app->parseObject($options->path);

        $path = Path::toSystemPath($options->path);

        if (FileSystem::isdir($path)) {
            if (isset($options->then)) {
                $this->app->exec($options->then, TRUE);
            }
            return TRUE;
        } else {
            if (isset($options->else)) {
                $this->app->exec($options->else, TRUE);
            }
            return FALSE;
        }
    }

    public function createdir($options) {
        option_require($options, 'path');

        $options = $this->app->parseObject($options);

        $path = Path::toSystemPath($options->path);

        if (!FileSystem::isdir($path) && !FileSystem::mkdir($path, 0777, TRUE)) {
            throw new \Exception("Error creating folders. ($path)");
        }

        return $options->path;
    }

    public function removedir($options) {
        option_require($options, 'path');

        $options = $this->app->parseObject($options);

        $path = $options->path;

        if (!isset($options->intern)) {
            $path = Path::toSystemPath($path);
        }

        if (Path::isAppRoot($path)) {
            throw new \Exception("Not allowed to remove root dir.");
        }

        if (!FileSystem::isdir($path)) {
            throw new \Exception("Folder does not exist. ($path)");
        }

        $this->emptydir((object)array('path' => $path, 'intern' => true));

        if (!FileSystem::rmdir($path)) {
            throw new \Exception("Error removing folder $path");
        }

        return TRUE;
    }

    public function emptydir($options) {
        option_require($options, 'path');

        $options = $this->app->parseObject($options);

        $path = $options->path;

        if (!isset($options->intern)) {
            $path = Path::toSystemPath($path);
        }

        if (!FileSystem::isdir($path)) {
            throw new \Exception("Folder does not exist. ($path)");
        }

        $files = FileSystem::readdir($path);

        foreach ($files as $file) {
            $entry = $path . DIRECTORY_SEPARATOR . $file;

            if (FileSystem::isdir($entry)) {
                $this->removedir((object)array('path' => $entry, 'intern' => true));
            } elseif (FileSystem::isfile($entry)) {
                if (!FileSystem::unlink($entry)) {
                    throw new \Exception("Error removing file $entry");
                }
            }
        }

        return TRUE;
    }

    public function move($options) {
		option_require($options, 'from');
		option_require($options, 'to');
		option_default($options, 'overwrite', FALSE);
        option_default($options, 'createdir', TRUE);

        $options = $this->app->parseObject($options);

        $from = Path::toSystemPath($options->from);
        $to   = Path::toSystemPath($options->to);

        if (!FileSystem::isfile($from)) {
            throw new \Exception("File doesn't exist. ($from)");
        }

        if ($options->createdir) {
            if (!FileSystem::isdir($to) && !FileSystem::mkdir($to, 0777, TRUE)) {
                throw new \Exception("Error creating folders. ($to)");
            }
        }

        if (!FileSystem::isdir($to)) {
            throw new \Exception("Folder doesn't exist. ($to)");
        }

        $to .= DIRECTORY_SEPARATOR . basename($from);

        if (!$options->overwrite) {
            $to = Path::getUniqFile($to);
        }

        if (!FileSystem::rename($from, $to, TRUE)) {
            throw new \Exception("Error writing file. ($to)");
        }

        return Path::toAppPath($to);
    }

    public function rename($options) {
        option_require($options, 'path');
        option_require($options, 'template');
        option_default($options, 'overwrite', FALSE);

        $options = $this->app->parseObject($options);

        $path = Path::toSystemPath($options->path);

        if (!FileSystem::isfile($path)) {
            throw new \Exception("File doesn't exist. ($path)");
        }

        $to = Path::parseTemplate($path, $options->template);

        if (!$options->overwrite && FileSystem::isfile($to)) {
            throw new \Exception("File already exists. ($to)");
        }

        if (!FileSystem::rename($path, $to, $options->overwrite)) {
            throw new \Exception("Error writing file. ($to)");
        }

        return Path::toAppPath($to);
    }

    public function copy($options) {
		option_require($options, 'from');
		option_require($options, 'to');
		option_default($options, 'overwrite', FALSE);
        option_default($options, 'createdir', TRUE);

        $options = $this->app->parseObject($options);

        $from = Path::toSystemPath($options->from);
        $to   = Path::toSystemPath($options->to);

        if (!FileSystem::isfile($from)) {
            throw new \Exception("File doesn't exist. ($from)");
        }

        if ($options->createdir) {
            if (!FileSystem::isdir($to) && !FileSystem::mkdir($to, 0777, TRUE)) {
                throw new \Exception("Error creating folders. ($to)");
            }
        }

        if (!FileSystem::isdir($to)) {
            throw new \Exception("Folder doesn't exist. ($to)");
        }

        $to .= DIRECTORY_SEPARATOR . basename($from);

        if (!$options->overwrite) {
            $to = Path::getUniqFile($to);
        }

        if (!FileSystem::copy($from, $to, TRUE)) {
            throw new \Exception("Error writing file. ($to)");
        }

        return Path::toAppPath($to);
    }

    public function remove($options) {
		option_require($options, 'path');

        $options = $this->app->parseObject($options);

        $path = Path::toSystemPath($options->path);

        if (!FileSystem::isfile($path)) {
            throw new \Exception("File doesn't exist. ($path)");
        }

        if (!FileSystem::unlink($path)) {
            throw new \Exception("Error removing file. ($path)");
        }

        return TRUE;
    }

    public function dir($options) {
		option_require($options, 'path');
        option_default($options, 'allowedExtensions', '');
        option_default($options, 'showHidden', FALSE);
        option_default($options, 'includeFolders', FALSE);

        $options = $this->app->parseObject($options);

        $path = Path::toSystemPath($options->path);

        if (!FileSystem::isdir($path)) {
            throw new \Exception("Folder doesn't exist. ($path)");
        }

        $allowedExtensions = array();

        if (trim($options->allowedExtensions) != '') {
            $allowedExtensions = preg_split('/\s*,\s*/', $options->allowedExtensions);
        }

		$entries = FileSystem::readdir($path);
        $dir = array();

		foreach ($entries as $entry) {
			$isDir = FileSystem::isdir($path . DIRECTORY_SEPARATOR . $entry);

            if (!$options->includeFolders && $isDir) {
                // skip folders
                continue;
            }

            if (!$options->showHidden && $entry[0] == '.') {
                // skip hidden
                continue;
            }

            if ($isDir || count($allowedExtensions) === 0 || in_array(substr($entry, strrpos($entry, '.')), $allowedExtensions)) {
			    //$entry = FileSystem::stat($path . DIRECTORY_SEPARATOR . $entry);
                 $dir[] = $this->stat((object)array('path' => Path::toAppPath($path . DIRECTORY_SEPARATOR . $entry)));
            }
		}

		return $dir;
    }

    public function stat($options) {
		option_require($options, 'path');
        option_default($options, 'folderSize', 'none'); // ['none', 'files', 'recursive']

        $options = $this->app->parseObject($options);

        $path = Path::toSystemPath($options->path);

        $stat = FileSystem::stat($path);

        $stat['folder'] = substr($stat['path'], 0, strrpos($stat['path'], '/'));
        $stat['basename'] = $stat['name'];
        $stat['extension'] = '';

        if ($stat['type'] === 'file') {
            $stat['extension'] = '.' . pathinfo($stat['name'], PATHINFO_EXTENSION);
            $stat['basename'] = basename($stat['name'], $stat['extension']);
        } elseif ($stat['type'] === 'dir') {
            $stat['size'] = 0;

            if ($options->folderSize === 'files') {
                $stat['size'] = $this->folderSize($path);
            } elseif ($options->folderSize === 'recursive') {
                $stat['size'] = $this->folderSize($path, TRUE);
            }
        }

        return $stat;
    }

    private function folderSize($dir, $recursive = FALSE) {
        $size = 0;
        $handle = opendir(FileSystem::encode($dir));

        while (($file = readdir($handle)) !== FALSE) {
            if ($file == '.' || $file == '..') continue;

            $path = $dir . DIRECTORY_SEPARATOR . $file;

            if (FileSystem::isfile($path)) {
                $size += filesize(FileSystem::encode($path));
            } elseif ($recursive && FileSystem::isdir($path)) {
                $size += $this->folderSize($path, $recursive);
            }
        }

        return $size;
    }
}
