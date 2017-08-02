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
     * @param $pageAccessToken
     */
    public function __construct($pageId, $pageAccessToken)
    {
        $this->pageId = $pageId;
        //$this->userAccessToken = $userAccessToken;
        $this->pageAccessToken = $pageAccessToken;
    }

    private function getPageAccessToken(){

        $url = self::FACEBOOK_GRAPH_API_URL."/{$this->pageId}?fields=access_token&access_token={$this->userAccessToken}";
        $response = CurlService::getCurlResponse($url);
        $pageAccessToken = $response['access_token'];
        return $pageAccessToken;
    }

    public function getPosts($postId = null){

        //Get the posts
        $postsFbData = $this->getPostsFromFb($postId);

        foreach ($postsFbData as &$postData){

            //Get all comments
            if (isset($postData['comments']['paging']['next'])){
                $postData['comments']['data'] = array_merge($postData['comments']['data'],CurlService::makeFbGetApiCall($postData['comments']['paging']['next']));
            }

            //Get all insights
            /*if (isset($postData['insights']['paging']['next'])){
                $postData['insights']['data'] = array_merge($postData['insights']['data'],CurlService::makeFbGetApiCall($postData['insights']['paging']['next']));
            }*/
        }
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
        $url = self::FACEBOOK_GRAPH_API_URL."/{$this->pageId}/promotable_posts?fields=created_time,is_published,message,updated_time,link,description,caption,name,object_id,full_picture,child_attachments,attachments,picture,source,scheduled_publish_time,type,comments.limit(10),insights.metric(post_negative_feedback,post_fan_reach,post_impressions_unique,post_reactions_like_total,post_reactions_love_total,post_reactions_wow_total,post_reactions_haha_total,post_reactions_sorry_total,post_reactions_anger_total,post_reactions_by_type_total,post_stories_by_action_type)&access_token={$this->pageAccessToken}";
        
        $response = CurlService::makeFbGetApiCall($url);

        return $response;

    }


}