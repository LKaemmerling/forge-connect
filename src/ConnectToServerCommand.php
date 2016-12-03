<?php

namespace LKDevelopment\ForgeConnect;

use Mpociot\Blacksmith\Blacksmith;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConnectToServerCommand.
 */
class ConnectToServerCommand extends Command
{
    use InteractsWithForgeAll;

    protected function configure()
    {
        $this->setName('servers:connect')
            ->setAliases(['connect'])
            ->setDescription('Try to connect to a given forge Server ')
            ->addArgument('name', InputArgument::REQUIRED, 'The Name of the Server you want to connect to.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->hasForgeCache('servers')) {
            $servers = $this->getForgeCache('servers');
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
        foreach ($servers as $server) {
            if ($server['name'] == $input->getArgument('name')) {
                $process = new Process('open ssh://forge@'.$server['ip_address']);
                $process->run();
                if ($process->getExitCodeText() == Process::$exitCodes[0]) {
                    $output->writeln('<info>Starting Connection in new Window.</info>');
                } else {
                    $output->writeln('<error>Error on Startup:'.$process->getErrorOutput().'.</error>');
                }
                exit();
            }
        }
        $output->writeln('<error>Can not find any Server with this name</error>');
    }
}
