<?php

namespace Rofflexor\Hw\Helpers;

class FileHelper
{
    /**
     * Check if a file exists in a path or url.
     *
     * @since 1.1.3
     *
     * @param string $file → path or file url
     *
     * @return bool
     */
    public static function exists($file)
    {
        if (filter_var($file, FILTER_VALIDATE_URL)) {
            $stream = stream_context_create(['http' => ['method' => 'HEAD']]);
            if ($content = @fopen($file, 'r', null, $stream)) {
                $headers = stream_get_meta_data($content);
                fclose($content);
                $status = substr($headers['wrapper_data'][0], 9, 3);

                return $status >= 200 && $status < 400;
            }

            return false;
        }

        return file_exists($file) && is_file($file);
    }

    /**
     * Delete file.
     *
     * @since 1.1.3
     *
     * @param string $file → file path
     *
     * @return bool
     */
    public static function delete($file)
    {
        return self::exists($file) && @unlink($file);
    }

    /**
     * Create directory.
     *
     * @since 1.1.3
     *
     * @param string $path → path where to create directory
     *
     * @return bool
     */
    public static function createDir($path): bool
    {
        return !is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path);
    }

    /**
     * Copy directory recursively.
     *
     * @param string $from
     * @param string $to
     * @return bool
     * @since 1.1.4
     *
     */
    public static function copyDirRecursively(string $from, string $to): bool
    {
        if (! $path = self::getFilesFromDir($from)) {
            return false;
        }

        self::createDir($to = rtrim($to, '/') . '/');

        foreach ($path as $file) {
            if ($file->isFile()) {
                if (! copy($file->getRealPath(), $to . $file->getFilename())) {
                    return false;
                }
            } elseif (! $file->isDot() && $file->isDir()) {
                self::copyDirRecursively($file->getRealPath(), $to . $path);
            }
        }

        return true;
    }

    /**
     * Delete empty directory.
     *
     * @param string $path → path to delete
          *
     * @return bool
     *@since 1.1.3
     *
     */
    public static function deleteEmptyDir(string $path): bool
    {
        return is_dir($path) && @rmdir($path);
    }

    /**
     * Delete directory recursively.
     *
     * @since 1.1.3
     *
     * @param string $path → path to delete
     *
     * @return bool
     */
    public static function deleteDirRecursively($path): bool
    {
        if (! $paths = self::getFilesFromDir($path)) {
            return false;
        }

        foreach ($paths as $file) {
            if ($file->isFile()) {
                if (! self::delete($file->getRealPath())) {
                    return false;
                }
            } elseif (! $file->isDot() && $file->isDir()) {
                self::deleteDirRecursively($file->getRealPath());
                self::deleteEmptyDir($file->getRealPath());
            }
        }

        return self::deleteEmptyDir($path);
    }

    /**
     * Get files from directory.
     *
     * @param string $path → path where get files
     *
     * @return object|false →
     *@since 1.1.3
     *
     */
    public static function getFilesFromDir(string $path): false|\DirectoryIterator
    {
        if (! is_dir($path)) {
            return false;
        }

        return new \DirectoryIterator(rtrim($path, '/') . '/');
    }

    public static function getDirContents($dir, &$results = array()) {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value !== "." && $value !== "..") {
                self::getDirContents($path, $results);
                $results[] = $path;
            }
        }
        return $results;
    }
}