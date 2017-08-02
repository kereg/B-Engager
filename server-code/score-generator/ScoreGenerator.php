<?php
require_once '../text-analyze/WatsonApi.php';

class ScoreGenerator {
  private $maxComments;
  private $maxReactions;
  private $maxShares;
  private $weightShares;
  private $weightReactions;
  private $weightComments;


  //Score Data
  /**
   * @var Score
   */
  private $finalScoreObj;

  /**
   * ScoreGenerator constructor.
   * @param $maxComments
   * @param $maxReactions
   * @param $maxShares
   * @param $weightShares
   * @param $weightReactions
   * @param $weightComments
   * @internal param $likesAmount
   */
  public function __construct($maxComments, $maxReactions, $maxShares, $weightShares, $weightReactions, $weightComments) {
    $this->maxComments = $maxComments;
    $this->maxReactions = $maxReactions;
    $this->maxShares = $maxShares;
    $this->weightShares = $weightShares;
    $this->weightReactions = $weightReactions;
    $this->weightComments = $weightComments;
  }

  function AnalyzeComments($txtArr) {
    $resultsArr = array();
    $watson = new WatsonApi();
    foreach ($txtArr as $txt) {
//      $response = $watson->getTextAnalysis($txt);
//      array_push($resultsArr, $this->getScoreFromWatsonReply($response));
    }
//    return $resultsArr;
    return 0;
  }

  function GenerateScoreObj($shareAmount, $commentsArr, $timeAlive, $negFeedbackAmount,
                            $sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount, $likeAmount, $reactionsAmount) {
    $scoreArr = array();
    $scoreArr['Shares'] = $this->getSharesScore($shareAmount);
    $scoreArr['Reactions'] = $this->getReactionsScore($sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount,
      $likeAmount, $reactionsAmount);
    $scoreArr['Comments'] = $this->getCommentsScore($commentsArr);
    $scoreArr['TimeAlive'] = $timeAlive;
    $scoreArr['NegFeedbackAmount'] = $negFeedbackAmount;
    $scoreArr['Total'] = $this->finalScoreObj->Shares + $this->finalScoreObj->Reactions + $this->finalScoreObj->Comments;
    return $scoreArr;
  }

  private function getSharesScore($amount) {
    return $amount/$this->maxShares*100;
  }

  private function getReactionsScore($sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount,
                                     $likeAmount, $amount) {
    return $amount/$this->maxReactions*100;
  }

  private function getCommentsScore($commentsArr) {
    $commentsAmountScore = count($commentsArr)/$this->maxComments;
    $commentsWatsonScore = AnalyzeComments($commentsArr);
    return $commentsWatsonScore;
  }

  private function getScoreFromWatsonReply() {
  }
}