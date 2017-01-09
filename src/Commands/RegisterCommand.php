<?php

namespace LKDevelopment\ForgeConnect\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LKDevelopment\ForgeConnect\Traits\InteractsWithForgeConnectDir;
use LKDevelopment\ForgeConnect\Traits\InteractsWithForgeConfiguration;
/**
 * Class RegisterCommand.
 */
class RegisterCommand extends Command
{
    use InteractsWithForgeConnectDir, InteractsWithForgeConfiguration;

    public function configure()
    {
        $this->setName('register')
            ->addArgument('email', InputArgument::REQUIRED, 'The E-Mail')
            ->addArgument('password', InputArgument::REQUIRED, 'The Password')
            ->setDescription('Save your Forge Credentials');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->configExists() && file_exists($this->homePath() . '/.forgeConnect')) {
            mkdir($this->homePath() . '/.forgeConnect');
        }
        $this->askForPassphrase($input, $output);
        $this->storeCredentials($input->getArgument('email'), $input->getArgument('password'));
        $output->writeln('<info>Saved!</info>');
    }
}
