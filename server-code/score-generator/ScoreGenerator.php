<?php
require_once '../text-analyze/WatsonApi.php';

class ScoreGenerator {
  private $maxComments;
  private $maxReactions;
  private $maxShares;
  private $weightShares;
  private $weightReactions;
  private $weightComments;

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

  function analyzeComments($txtArr) {
    $watson = new WatsonApi();
    $response = json_decode($watson->getTextAnalysis(implode('. ', $txtArr)));
    $emotionsArr =  $response["document_tone"]["tone_categories"][0]["tones"];
    $anger = $emotionsArr[0]["score"];
    $disgust = $emotionsArr[1]["score"];
    $fear = $emotionsArr[2]["score"];
    $joy = $emotionsArr[3]["score"];
    $sadness = $emotionsArr[4]["score"];

    $this->getGeneralWatsonScore($anger, $disgust, $fear, $joy, $sadness);

    return 0;
  }

  function generateScoreObj($shareAmount, $commentsArr, $timeAlive, $negFeedbackAmount,
                            $sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount, $likeAmount, $reactionsAmount) {
    $scoreArr = array();
    $scoreArr['Shares'] = $this->getSharesScore($shareAmount);
    $scoreArr['Reactions'] = $this->getReactionsScore($sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount,
      $likeAmount, $reactionsAmount);
    $scoreArr['Comments'] = $this->getCommentsScore($commentsArr);
    $scoreArr['TimeAlive'] = $timeAlive;
    $scoreArr['NegFeedbackAmount'] = $negFeedbackAmount;
    $scoreArr['Total'] = $scoreArr['Shares'] + $scoreArr['Reactions'] + $scoreArr['Comments'];
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
    $commentsWatsonScore = $this->analyzeComments($commentsArr);
    return $commentsWatsonScore;
  }

  /**
   * Emotion
  < .5 = not likely present
  > .5 = likely present
  > .75 = very likely present
   *
   * Language Style
  < .5 = not likely present
  > .5 = likely present
  > .75 = very likely present
   *
   * Social Tendencies
  < .5 = not likely present
  > .5 = likely present
  > .75 = very likely present
   */
  private function getScoreFromWatsonReply() {
    //0.75 is probable
  }

  private function getGeneralWatsonScore($anger, $disgust, $fear, $joy, $sadness) {
    //if only 1 >0.75 take it
    //

  }
}

