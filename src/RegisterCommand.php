<?php
namespace LKDevelopment\ForgeConnect;

use Silly\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RegisterCommand
 * @package LKDevelopment\ForgeConnect
 */
class RegisterCommand extends Command
{
    use InteractsWithForgeConfiguration;

    /**
     *
     */
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

        if (!$this->configExists()) {
            mkdir($this->homePath() . '/.forgeConnect');
        }
        $this->storeCredentials($input->getArgument('email'), $input->getArgument('password'));
        $output->writeln('<info>Saved!</info>');
    }
}