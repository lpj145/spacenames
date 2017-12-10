<?php
namespace Spacenames;

class Core
{
    /**
     * @param string $currently
     * @param string $new
     * @param bool $debugMode
     */
    public static function changeNamespace(string $currently, string $new, bool $debugMode = false)
    {

        define('DEBUG_MODE', $debugMode);
        define('DS', DIRECTORY_SEPARATOR);

        $rootDir = ComposerFile::getRootDir();
        $composerJson = ComposerFile::getComposerJson($rootDir);
        $dirNamespace = ComposerFile::getNamespaceDir($rootDir, $currently, $composerJson);

        Logger::message('Now opening file by file!');

        self::confirmOperation('You like change all namespace on: ',$dirNamespace);

        Files::changeFileByFile(
            $dirNamespace,
            $currently,
            $new
        );

        Logger::message('All files changed with success!');

        self::confirmOperation('Change json file :', '');

        ComposerFile::setComposerJson(
            $composerJson,
            $rootDir,
            $currently,
            $new
        );
    }

    private static function confirmOperation($message, $dirNamespace)
    {
        Logger::message($message.' '.realpath($dirNamespace));

        while (true) {
            $confirm = readline('(y) yes (n) no: ');

            if ($confirm === 'y') {
                break;
            }

            if ($confirm === 'n') {
                die('...');
            }
        }
    }
}
