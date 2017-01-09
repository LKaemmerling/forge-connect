<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 14.12.16
 * Time: 15:08
 */

namespace LKDevelopment\ForgeConnect;


use LKDevelopment\ForgeConnect\Commands\ConnectToServerCommand;
use LKDevelopment\ForgeConnect\Commands\ListServersCommand;
use LKDevelopment\ForgeConnect\Commands\RegisterCommand;
use Symfony\Component\Console\Application;

/**
 * Class ForgeConnect
 * @package LKDevelopment\ForgeConnect
 */
class ForgeConnect extends Application
{
    /**
     *
     */
    CONST VERSION = '1.2.0';

    /**
     * ForgeConnect constructor.
     */
    public function __construct()
    {
        parent::__construct('forge-connect', self::VERSION);
        $this->add(new RegisterCommand());
        $this->add(new ListServersCommand());
        $this->add(new ConnectToServerCommand());
    }
}
