<?php
namespace Spacenames;

class Files
{
    /**
     * @param string $basePath
     * @param string $currentNamespace
     * @param string $newNamespace
     */
    public static function changeFileByFile(string $basePath, string $currentNamespace, string $newNamespace)
    {
        $filesAndFolders = scandir($basePath);
        foreach ($filesAndFolders as $dir)
        {
            if (self::isAftersPaths($dir)) {
                continue;
            }

            self::dispatchChangeTo(realpath($basePath.DS.$dir), $currentNamespace, $newNamespace);
        }
    }

    /**
     * If is dir, return to changeFileByFile
     * or not, go File class
     * @param $fileOrFolder
     * @param string $currentNamespace
     * @param string $newNamespace
     */
    private static function dispatchChangeTo($fileOrFolder, string $currentNamespace, string $newNamespace)
    {
        if (is_dir($fileOrFolder)) {
            Logger::message('Changing on folder: '.realpath($fileOrFolder));
            self::changeFileByFile($fileOrFolder, $currentNamespace, $newNamespace);
            return;
        }

        Logger::message('Changing on file: '.realpath($fileOrFolder));
        File::changeUsedNamespace($fileOrFolder, $currentNamespace, $newNamespace);

    }

    /**
     * When after folder or up dirs is invalid...
     * @param string $path
     * @return bool
     */
    private static function isAftersPaths(string $path)
    {
        return $path === '..' || $path === '.' ? true : false;
    }
}
