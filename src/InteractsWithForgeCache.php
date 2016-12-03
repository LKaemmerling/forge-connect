<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 03.12.16
 * Time: 16:48
 */

namespace LKDevelopment\ForgeConnect;


use Doctrine\Common\Cache\FilesystemCache;

/**
 * Class InteractsWithForgeCache
 * @package LKDevelopment\ForgeConnect
 */
trait InteractsWithForgeCache
{
    /**
     * @var FilesystemCache
     */
    protected $cache;

    /**
     *
     */
    protected function bootCache()
    {
        if (!$this->cache instanceof FilesystemCache) {
            $this->cache = new FilesystemCache($this->getPath(), '.forge.cache');
        }
    }

    /**
     *
     */
    protected function hasForgeCache($sub = null)
    {
        $this->bootCache();
        return $this->cache->contains('forge' . (($sub === null) ? '' : '.' . $sub));
    }

    /**
     * @param null $sub
     * @return false|mixed
     */
    protected function getForgeCache($sub = null)
    {
        $this->bootCache();
        return $this->cache->fetch('forge' . (($sub === null) ? '' : '.' . $sub));
    }

    /**
     * @param $data
     * @param int $lifetime
     * @param null $sub
     * @return bool
     */
    protected function putForgeCach(array $data, $lifetime = 3600, $sub = null)
    {
        $this->bootCache();
        return $this->cache->save('forge' . (($sub === null) ? '' : '.' . $sub), $data,$lifetime);
    }
}
