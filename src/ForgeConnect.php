<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 14.12.16
 * Time: 15:08.
 */

namespace LKDevelopment\ForgeConnect;

use Symfony\Component\Console\Application;
use LKDevelopment\ForgeConnect\Commands\RegisterCommand;
use LKDevelopment\ForgeConnect\Commands\ListServersCommand;
use LKDevelopment\ForgeConnect\Commands\ConnectToServerCommand;

/**
 * Class ForgeConnect.
 */
class ForgeConnect extends Application
{
    const VERSION = '1.2.0';

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
