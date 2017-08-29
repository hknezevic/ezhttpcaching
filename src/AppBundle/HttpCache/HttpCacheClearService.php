<?php

namespace AppBundle\HttpCache;

use FOS\HttpCacheBundle\CacheManager;
use FOS\HttpCache\Exception\ExceptionCollection;

class HttpCacheClearService
{
    /**
     * @var \FOS\HttpCacheBundle\CacheManager
     */
    protected $cacheManager;

    /**
     * Constructor.
     *
     * @param \FOS\HttpCacheBundle\CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function invalidateCacheForContentType($contentTypeId)
    {
        if (empty($contentTypeId)) {
            return;
        }
    }

    /**
     * Commits the cache clear operations to the backend.
     *
     * @return bool
     */
    public function commit()
    {
        return true;
    }
}