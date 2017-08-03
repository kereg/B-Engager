<?php

namespace page;

require_once  $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/page/Page.php";
require_once  $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/score-generator/ScoreHandler.php";
use ScoreHandler;

/**
 * Created by PhpStorm.
 * User: gal
 * Date: 02/08/2017
 * Time: 22:22
 */
class AnalyzePage
{
    /**
     * GetPost constructor.
     * @param $pageId
     * @param $accessToken
     * @param string|null $postIds CSV of post IDs
     */
    public function __construct($pageId, $accessToken, $postIds=null)
    {
        $this->pageId = $pageId;
        $this->accessToken = $accessToken;
        $this->postIds = $postIds ? explode(',',$postIds) : null;
    }

    public function analyzePage(){
        $page = new Page($this->pageId,$this->accessToken,$this->postIds);
        $postsRawData = $page->getPosts();

        $postsData = $this->preparePostsData($postsRawData);

        $scoreHandler = new ScoreHandler($postsData);
        $scores = $scoreHandler->getScores($postsData);

        return $this->finalizeData($postsData,$scores);
    }

    private function preparePostsData($postsRawData){

        $data = array();
        foreach ($postsRawData as $postData){
            $idData = explode("_",$postData['id']);

            $data[] = array(
                'page_id'=>$idData[0],
                'post_id'=>$idData[1],
                'picture'=>$postData['full_picture'],
                'created_time'=>$postData['created_time'],
                'type'=>$postData['type'],
                'comments'=>isset($postData['comments']) ? $this->getComments($postData['comments']['data']) : array(),
                'totals'=>$this->getPostTotalEngagements($postData['insights']['data'])
            );
        }

        return $data;
    }

    private function getComments($commentsRawData){
        $comments = array();
        foreach ($commentsRawData as $commentData){
            $comments[] = $commentData['message'];
        }
        return $comments;
    }

    private function getPostTotalEngagements($postInsightsData){

        $totals = array();
        foreach ($postInsightsData as $data){
            $name = $data['name'];
            $value = $data['values'][0]['value'];
            switch ($name){
                case 'post_reactions_by_type_total':
                    $totals = $totals + $value;
                    break;
                case 'post_stories_by_action_type':

                    $totals = $totals + array(
                                                'comments'=>isset($value['comment']) ? intval($value['comment']) : 0,
                                                'shares'=>isset($value['share']) ? intval($value['share']): 0,
                                                'reactions'=>isset($value['like']) ? intval($value['like']): 0
                                            );
                    break;
                default:
                    $totals[$name] = $value;
                    break;
            }
        }
        return $totals;
    }

    private function finalizeData($postsData,$scores){

        foreach ($postsData as $index => &$post){
            $post['score'] = $scores[$index];
        }

        return $postsData;

    }
}