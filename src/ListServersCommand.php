<?php

namespace LKDevelopment\ForgeConnect;

use Mpociot\Blacksmith\Blacksmith;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListServersCommand.
 */
class ListServersCommand extends Command
{
    use InteractsWithForgeConfiguration;


    protected function configure()
    {
        $this->setName('servers:list')
            ->setDescription('Returns the List of your Servers from Forge');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $credentials = $this->readCredentials();
        $api = new Blacksmith($credentials['email'], $credentials['password']);
        $servers = $api->getActiveServers();
        $table = new Table($output);
        $table->setHeaders(['Name', 'IP', 'Provider', 'Installed', 'Status']);
        foreach ($servers as $server) {
            $table->addRow([$server->name, $server->ip_address, $server->provider, $server->is_ready, $server->displayable_provision]);
        }
        $table->render();
    }
}
