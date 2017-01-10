<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 01.12.16
 * Time: 22:39.
 */

namespace LKDevelopment\ForgeConnect\Traits;

use Illuminate\Encryption\Encrypter;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InteractsWithForgeConfiguration.
 */
trait InteractsWithForgeConfiguration
{
    /**
     * @var
     */
    protected $passphrase;

    /**
     * Get the Forge Credentials from the configuration file.
     *
     * @return string
     * @throws \Exception
     */
    protected function readConfig()
    {
        if (! $this->configExists()) {
            throw new \Exception('Forge Connect configuration file not found. Please register a Credentials.');
        }

        return json_decode(
            file_get_contents($this->configPath()), true
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function askForPassphrase(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please enter your passphrase:');
        $question->setHidden(true);
        $this->passphrase = hash('md5', $helper->ask($input, $output, $question));
    }

    /**
     * @return mixed
     */
    public function getCredentials()
    {
        $encryption = new Encrypter($this->passphrase, 'AES-256-CBC');
        $pass = $encryption->decrypt($this->readConfig()['credentials']['password']);

        return [
            'email' => $this->readConfig()['credentials']['email'],
            'password' => $pass,
        ];
    }

    /**
     * Write the Forge Credentials to the configuration.
     *
     * @param  string $token
     * @return void
     */
    protected function storeCredentials($email, $password)
    {
        $encryption = new Encrypter($this->passphrase, 'AES-256-CBC');
        $config = ($this->configExists()) ? $this->readConfig() : [];
        $config['credentials'] = [
            'email' => $email,
            'password' => $encryption->encrypt($password),
        ];
        $this->storeConfig($config);
    }

    /**
     * @param $config
     */
    protected function storeConfig($config)
    {
        file_put_contents($this->configPath(), json_encode($config, JSON_PRETTY_PRINT).PHP_EOL);
    }

    /**
     * Get the Forge Connect configuration file path.
     *
     * @return string
     */
    protected function configPath()
    {
        return $this->getPath().'/config.json';
    }

    /**
     * Determine if the Forge Connect configuration file exists.
     *
     * @return bool
     */
    protected function configExists()
    {
        return file_exists($this->configPath());
    }

    /**
     * Get the CMD line.
     *
     * @return string
     */
    protected function getConsoleTool()
    {
        if (! isset($this->readConfig()['console'])) {
            return $this->getOSSpecificDefaultCommand();
        } else {
            return $this->readConfig()['console'];
        }
    }

    /**
     * Return the Default CMD Line for the specific OS.
     *
     * @return string
     */
    protected function getOSSpecificDefaultCommand()
    {
        if (stristr(PHP_OS, 'LINUX')) {
            return 'ssh {ip_address} -l {user}';
        } else {
            return 'open ssh://{user}@{ip_address}';
        }
    }
}
