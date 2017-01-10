<?php

namespace LKDevelopment\ForgeConnect\Commands;

use Mpociot\Blacksmith\Blacksmith;
use Mpociot\Blacksmith\Models\Server;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LKDevelopment\ForgeConnect\Traits\InteractsWithForgeAll;

/**
 * Class ConnectToServerCommand.
 */
class ConnectToServerCommand extends Command
{
    use InteractsWithForgeAll;

    protected function configure()
    {
        $this->setName('servers:connect')
            ->setAliases(['connect', 'c'])
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
            $servers = $rawServers->map(function (Server $s) {
                return $s->toArray();
            });
            $this->putForgeCache($servers->toArray(), 3600, 'servers');
        }
        foreach ($servers as $server) {
            if ($server['name'] == $input->getArgument('name')) {
                $command_with_placeholder = $this->getConsoleTool();
                $command_without_placeholder = str_replace(['{user}', '{ip_address}'], ['forge', $server['ip_address']], $command_with_placeholder);
                $process = new Process($command_without_placeholder);
                $process->setTty(true);
                $process->run();
                if ($process->getExitCodeText() == Process::$exitCodes[0]) {
                    $output->writeln('<info>Starting Connection in new Window.</info>');
                } else {
                    $output->writeln('<error>Error on Startup:'.$process->getErrorOutput().'.</error>');
                    $output->writeln('<info>Please try it manually:'.$command_without_placeholder.'</info>');
                }

                return true;
            }
        }
        $output->writeln('<error>Can not find any Server with this name</error>');
    }
}
