<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 01.12.16
 * Time: 22:39.
 */
namespace LKDevelopment\ForgeConnect;

trait InteractsWithForgeConfiguration
{
    /**
     * Get the Forge Credentials from the configuration file.
     *
     * @return string
     * @throws \Exception
     */
    protected function readCredentials()
    {
        if (! $this->configExists()) {
            throw new \Exception('Forge Connect configuration file not found. Please register a Credentials.');
        }

        return json_decode(base64_decode(
            file_get_contents($this->configPath())), true
        );
    }

    /**
     * Write the Forge Credentials to the configuration.
     *
     * @param  string $token
     * @return void
     */
    protected function storeCredentials($email, $password)
    {
        file_put_contents($this->configPath(), base64_encode(json_encode([
                'email' => $email,
                'password' => $password,
            ], JSON_PRETTY_PRINT)).PHP_EOL);
    }

    /**
     * Determine if the Spark configuration file exists.
     *
     * @return bool
     */
    protected function configExists()
    {
        return file_exists($this->configPath());
    }

    /**
     * Get the Spark configuration file path.
     *
     * @return string
     */
    protected function configPath()
    {
        return $this->homePath().'/.forgeConnect/config.json';
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
