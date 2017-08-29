<?php

namespace AppBundle\EventListener;

use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\Core\MVC\Symfony\View\CachableView;
use eZ\Publish\Core\MVC\Symfony\View\LocationValueView;
use eZ\Publish\Core\MVC\Symfony\View\View;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CustomCacheHeadersResponseListener implements EventSubscriberInterface
{
    /**
     * True if view cache is enabled, false if it is not.
     *
     * @var bool
     */
    private $enableViewCache;

    /** @var ContentTypeService */
    private $contentTypeService;

    public function __construct($enableViewCache, $contentTypeService)
    {
        $this->enableViewCache = $enableViewCache;
        $this->contentTypeService = $contentTypeService;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::RESPONSE => 'addContentTypeHeaders'];
    }

    public function addContentTypeHeaders(FilterResponseEvent $event)
    {
        if (!($view = $event->getRequest()->attributes->get('view')) instanceof CachableView) {
            return;
        }

        if (!$this->enableViewCache || !$view->isCacheEnabled()) {
            return;
        }

        $response = $event->getResponse();

        if ($view instanceof LocationValueView && ($location = $view->getLocation()) instanceof Location) {
            $response->headers->set('X-ContentType-Id', $location->contentInfo->contentTypeId, false);
            $response->headers->set('X-ContentType-Identifier', $this->contentTypeService->loadContentType($location->contentInfo->contentTypeId)->identifier);
        }
    }
}
