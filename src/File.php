<?php
namespace Spacenames;

class File
{
    public static function changeUsedNamespace(string $filePath, string $currentNamespace, string $newNamespace)
    {
        $fileString = self::getFile($filePath);

        $fileString = str_replace($currentNamespace, $newNamespace, $fileString);

        self::setFile($filePath, $fileString);
    }

    private static function getFile($filePath)
    {
        return file_get_contents($filePath);
    }

    private static function setFile($filePath, $newFileData)
    {
        return file_put_contents($filePath, $newFileData);
    }
}
