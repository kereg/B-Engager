<?php

namespace page;

require_once $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/CurlService.php";

use CurlService;
/**
 * Created by PhpStorm.
 * User: gal
 * Date: 02/08/2017
 * Time: 11:49
 */
class Page
{
    private $pageId;
    private $pageAccessToken;
    private $userAccessToken;
    const FACEBOOK_GRAPH_API_URL = "https://graph.facebook.com/v2.10";

    /**
     * GetPost constructor.
     * @param $pageId
     * @param $accessToken
     * @param $userAccessToken
     */
    public function __construct($pageId, $userAccessToken)
    {
        $this->pageId = $pageId;
        $this->userAccessToken = $userAccessToken;
        $this->pageAccessToken = $this->getPageAccessToken();
    }

    private function getPageAccessToken(){

        $url = self::FACEBOOK_GRAPH_API_URL."/{$this->pageId}?fields=access_token{$this->userAccessToken}";
        $response = CurlService::getCurlRespone($url);
        $pageAccessToken = $response['access_token'];
        return $pageAccessToken;
    }

    public function getPosts($postId = null){

        $postsFbData = $this->getPostsFromFb($postId);

        return $postsFbData;
    }

    /**
     * @param $postId
     * @return array of posts with array of data
     */
    private function getPostsFromFb($postId){

        return $this->getAllPagePosts();
    }


    private function getAllPagePosts(){
        $url = self::FACEBOOK_GRAPH_API_URL."/{$this->pageId}/promotable_posts?fields=created_time,is_published,message,updated_time,link,description,caption,name,object_id,full_picture,child_attachments,attachments,picture,source,scheduled_publish_time,type,likes.summary(true),shares,comments.summary(true),insights.metric(post_negative_feedback,post_fan_reach,post_impressions_unique,post_reactions_like_total,post_stories_by_action_type)&access_token={$this->pageAccessToken}";

        $response = CurlService::getCurlRespone($url);

        return $response;

    }


}