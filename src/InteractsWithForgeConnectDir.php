<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 03.12.16
 * Time: 16:48.
 */

namespace LKDevelopment\ForgeConnect;

/**
 * Class InteractsWithForgeConnectDir.
 */
trait InteractsWithForgeConnectDir
{
    /**
     * @var string
     */
    protected static $FOLDER_NAME = '.forgeConnect';

    /**
     * @return string
     */
    protected function getPath()
    {
        if (! file_exists($this->homePath().'/'.self::$FOLDER_NAME.'/')) {
            mkdir($this->homePath().'/'.self::$FOLDER_NAME.'/');
        }

        return $this->homePath().'/'.self::$FOLDER_NAME.'/';
    }

    /**
     * Get the User's home path.
     *
     * @return string
     * @throws \Exception
     */
    protected function homePath()
    {
        if (! empty($_SERVER['HOME'])) {
            return $_SERVER['HOME'];
        } elseif (! empty($_SERVER['HOMEDRIVE']) && ! empty($_SERVER['HOMEPATH'])) {
            return $_SERVER['HOMEDRIVE'].$_SERVER['HOMEPATH'];
        } else {
            throw new \Exception('Cannot determine home directory.');
        }
    }
}
