<?php
require_once $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/text-analyze/WatsonApi.php";

class ScoreGenerator {
  private $maxComments;
  private $maxReactions;
  private $maxShares;
  private $weightShares;
  private $weightReactions;
  private $weightComments;
  const EMOTIONS_FACTOR = array('anger' => -1, 'disgust' => -1, 'fear' => 0, 'joy'=>1, 'sadness'=>-0.5);
  const LIKELIHOOD_THRESHOLD = 0.5;

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
    $response = json_decode($watson->getTextAnalysis(implode('. ', $txtArr)),true);
    if (!$response){
        return 0;
    }
    $emotionsArr =  $response["document_tone"]["tone_categories"][0]["tones"];
      $emotionsArr = array(
        'anger' =>$emotionsArr[0]["score"],
        'disgust' => $emotionsArr[1]["score"],
        'fear' => $emotionsArr[2]["score"],
        'joy' => $emotionsArr[3]["score"],
        'sadness' => $emotionsArr[4]["score"]
    );

    return $this->getGeneralWatsonScore($emotionsArr);
  }

  function generateScoreObj($shareAmount, $commentsArr, $timeAlive, $negFeedbackAmount,
                            $sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount, $likeAmount, $reactionsAmount) {
    $scoreArr = array();
    $scoreArr['shares'] = $this->getSharesScore($shareAmount);
    $scoreArr['reactions'] = $this->getReactionsScore($sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount,
      $likeAmount, $reactionsAmount);
    $scoreArr['comments'] = $this->getCommentsScore($commentsArr);
    $scoreArr['timeAlive'] = $timeAlive;
    $scoreArr['negFeedbackAmount'] = $negFeedbackAmount;
    $scoreArr['total'] =  $this->weightShares*$scoreArr['shares'] +  $this->weightReactions*$scoreArr['reactions'] +  $this->weightComments*$scoreArr['comments'];
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

  private function getGeneralWatsonScore($emotionsArr){

      $likely = array();
      foreach ($emotionsArr as $emotion => $score){
          if ($score >= self::LIKELIHOOD_THRESHOLD){
              $likely[$emotion] = $score;
          }
      }
      if (count($likely) === 1){
          $emotion = key($likely);
          $score = current($likely);
          $finalScore = self::EMOTIONS_FACTOR[$emotion]*$score*100;
          return $finalScore;
      }
      return 0;
  }
}

