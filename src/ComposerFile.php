<?php
namespace Spacenames;

class ComposerFile
{
    /**
     * @return mixed
     */
    public static function getRootDir()
    {
        $dir = str_replace('/vendor', '', dirname(self::getVendorDirByCmd()));
        Logger::message('Root Dir: '.$dir);
        return $dir;
    }

    /**
     * @return string
     */
    private static function getVendorDirByCmd()
    {
        return shell_exec('composer config --absolute vendor-dir');
    }

    private static function composerDumpCmd()
    {
        shell_exec('composer dumpautoload');
    }

    /**
     * @param string $basePath
     * @return bool|string
     * @throws \ErrorException
     */
    public static function getComposerJson(string $basePath)
    {
        $json = file_get_contents($basePath.DS.'composer.json');
        if ($json) {
            Logger::message('Json founded!');
            return $json;
        }

        throw new \ErrorException('Json not found on '.$basePath);
    }

    /**
     * @param string $basePath
     * @param string $namespace
     * @param string $json
     * @return string
     * @throws \Exception
     */
    public static function getNamespaceDir(string $basePath, string $namespace, string $json)
    {
        $autoloads = json_decode($json, true)['autoload']['psr-4'];

        if (!isset($autoloads[$namespace])) {
            Logger::message('Namespace:'.$namespace.' cannot be found');
            Logger::message('See all namespaces founded!');
            Logger::message(print_r($autoloads, true));
            throw new \Exception('Namespace not found!');
        }

        $pathNamespace = str_replace('/', '', $autoloads[$namespace]);
        return realpath($basePath.DS.$pathNamespace.DS);
    }

    /**
     * @param string $json
     * @param string $basePath
     * @param string $currentNamespace
     * @param string $newNamespace
     * @throws \ErrorException
     */
    public static function setComposerJson(string $json, string $basePath, string $currentNamespace,string $newNamespace)
    {

        $newJson = str_replace($currentNamespace, $newNamespace, $json);
        Logger::message('Is a new json: '.PHP_EOL.$newJson);

        $result = file_put_contents($basePath.'/composer.json', $newJson);

        if ($result) {
            Logger::message('Json changed with success!');
            self::composerDumpCmd();
            return;
        }

        throw new \ErrorException('Json cannot changed!');
    }
}
