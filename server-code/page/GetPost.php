<?php

/**
 * Created by PhpStorm.
 * User: gal
 * Date: 02/08/2017
 * Time: 11:49
 */
class GetPost
{
    private $pageId;
    private $accessToken;

    /**
     * GetPost constructor.
     * @param $pageId
     * @param $accessToken
     */
    public function __construct($pageId, $accessToken)
    {
        $this->pageId = $pageId;
        $this->accessToken = $accessToken;
    }

    public function getPosts($postId = null){

        $this->getPostsFromFb($postId);
    }


}