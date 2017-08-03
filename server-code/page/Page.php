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
    private $accessToken;
    const FACEBOOK_GRAPH_API_URL = "https://graph.facebook.com/v2.10";

    /**
     * GetPost constructor.
     * @param $pageId
     * @param $accessToken
     * @param array|null $postIds
     */
    public function __construct($pageId, $accessToken,$postIds)
    {
        $this->pageId = $pageId;
        $this->accessToken = $accessToken;
        $this->postIds = $postIds;
    }

    private function getPageAccessToken(){

        $url = self::FACEBOOK_GRAPH_API_URL."/{$this->pageId}?fields=access_token&access_token={$this->accessToken}";
        $response = CurlService::getCurlResponse($url);
        $pageAccessToken = $response['access_token'];
        return $pageAccessToken;
    }

    public function getPosts(){

        //Get the posts
        $postsFbData = $this->getPostsFromFb();

        foreach ($postsFbData as &$postData){

            //Get all comments
            if (isset($postData['comments']['paging']['next'])){
                $postData['comments']['data'] = array_merge($postData['comments']['data'],CurlService::makeFbGetApiCall($postData['comments']['paging']['next'],"GET",10));
            }

            //Get all insights
            /*if (isset($postData['insights']['paging']['next'])){
                $postData['insights']['data'] = array_merge($postData['insights']['data'],CurlService::makeFbGetApiCall($postData['insights']['paging']['next']));
            }*/
        }
        return $postsFbData;
    }

    /**
     * @return array of posts with array of data
     */
    private function getPostsFromFb(){

        if (!empty($this->postIds)){
            return $this->getSpecificPosts();
        }
        return $this->getAllPagePosts();
    }


    private function getAllPagePosts(){
        $url = self::FACEBOOK_GRAPH_API_URL."/{$this->pageId}/promotable_posts?fields=created_time,is_published,message,updated_time,link,description,caption,name,object_id,full_picture,child_attachments,attachments,picture,source,scheduled_publish_time,type,comments.limit(10),insights.metric(post_negative_feedback,post_fan_reach,post_impressions_unique,post_reactions_by_type_total,post_stories_by_action_type)&limit=10&access_token={$this->accessToken}";
        
        $response = CurlService::makeFbGetApiCall($url);

        return $response;
    }

    private function getSpecificPosts(){
        $response = array();
        foreach ($this->postIds as $postId){

            $url = self::FACEBOOK_GRAPH_API_URL."/{$this->pageId}_{$postId}?fields=created_time,is_published,message,updated_time,link,description,caption,name,object_id,full_picture,child_attachments,attachments,picture,source,scheduled_publish_time,type,comments.limit(10),insights.metric(post_negative_feedback,post_fan_reach,post_impressions_unique,post_reactions_by_type_total,post_stories_by_action_type)&limit=100&access_token={$this->accessToken}";
            $response[] = CurlService::makeFbGetApiCall($url);
        }

        return $response;
    }


}