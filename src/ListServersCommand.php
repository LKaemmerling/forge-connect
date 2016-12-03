<?php

namespace LKDevelopment\ForgeConnect;

use Mpociot\Blacksmith\Blacksmith;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListServersCommand.
 */
class ListServersCommand extends Command
{
    use InteractsWithForgeAll;

    protected function configure()
    {
        $this->setName('servers:list')
            ->addOption('recache')
            ->setDescription('Returns the List of your Servers from Forge');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->hasForgeCache('servers') && $input->getOption('recache') == false) {
            $servers = $this->getForgeCache('servers');
            $output->writeln('<info>Using Cache</info>');
        } else {
            $this->askForPassphrase($input, $output);
            $credentials = $this->getCredentials();
            $api = new Blacksmith($credentials['email'], $credentials['password']);
            $rawServers = $api->getActiveServers();
            $servers = $rawServers->map(function ($s) {
                return $s->toArray();
            });
            $this->putForgeCach($servers->toArray(), 3600, 'servers');
        }
        $table = new Table($output);
        $table->setHeaders(['Name', 'IP', 'Provider', 'Installed', 'Status']);
        foreach ($servers as $server) {
            $table->addRow([$server['name'], $server['ip_address'], $server['provider'], $server['is_ready'], $server['displayable_provision']]);
        }
        $table->render();
    }
}
