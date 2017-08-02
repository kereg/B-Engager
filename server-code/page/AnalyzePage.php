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
     */
    public function __construct($pageId, $accessToken)
    {
        $this->pageId = $pageId;
        $this->accessToken = $accessToken;
    }

    public function analyzePage(){
        $page = new Page($this->pageId,$this->accessToken);
        $postsRawData = $page->getPosts();

        $postsData = $this->preparePostsData($postsRawData);

        $scores = new ScoreHandler($postsData);
        $data = $scores->getScores($postsData);

        return $data;
    }

    private function preparePostsData($postsRawData){

        $data = array();
        foreach ($postsRawData as $postData){
            $data[] = array(
                'created_time'=>$postData['created_time'],
                'type'=>$postData['type'],
                'comments'=>$this->getComments($postData['comments']['data']),
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
                case 'post_stories_by_action_type':
                    $totals = $totals + $value;
                    break;
                default:
                    $totals[$name] = $value;
                    break;
            }
        }
        return $totals;
    }
}