<?php

namespace AppBundle\Controller;


use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use Symfony\Component\HttpFoundation\Response;

class PartsController extends Controller
{
    public function getLatestBlogPostsAction(){

        $repository = $this->getRepository();
        $searchService = $repository->getSearchService();
        $contentService = $repository->getContentService();
        $blogLocationId = $this->getParameter('app.home.blog_location_id');
        $blogPosts = [];

        $locationQuery = new LocationQuery();
        $locationQuery->filter = new Criterion\LogicalAnd(
            [
                new Criterion\ParentLocationId($blogLocationId),
                new Criterion\ContentTypeIdentifier('blog_post'),
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                new Criterion\Location\IsMainLocation(Criterion\Location\IsMainLocation::MAIN)
            ]
        );
        $locationQuery->offset = 0;
        $locationQuery->limit = 3;

        $locationQuery->sortClauses = [
            new SortClause\Field('blog_post', 'publication_date', LocationQuery::SORT_DESC)
        ];

        $searchResults = $searchService->findLocations($locationQuery);

        $blogPostLocationIds = [];

        foreach ($searchResults->searchHits as $searchHit){
            /** @var Location $location */
            $location = $searchHit->valueObject;
            $blogPosts[] = [
                'location' => $location,
                'content' => $contentService->loadContent($location->contentId)
            ];
            $blogPostLocationIds[] = $location->id;
        }

        return $this->render(
            'AppBundle:parts:latest_blog_posts.html.twig',
            ['blog_posts' => $blogPosts]
        );
    }
}
