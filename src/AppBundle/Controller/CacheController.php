<?php

namespace AppBundle\Controller;

use AppBundle\HttpCache\HttpCacheClearService;
use eZ\Bundle\EzPublishCoreBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CacheController extends Controller {

    public function clearCacheForContentTypeIdAction(Request $request){
        if ($request->isXMLHttpRequest()) {
            $contentTypeId = $request->request->get('contentTypeId');

            /** @var HttpCacheClearService $cacheClearService */
            $cacheClearService = $this->container->get('websc.http_cache.http_cache_clear');
            $cacheClearService->invalidateCacheForContentType($contentTypeId);
            $cacheClearService->commit();

            return new JsonResponse(array('status' => 'success'));
        }
        return new JsonResponse(array('status' => 'failure'));
    }

}