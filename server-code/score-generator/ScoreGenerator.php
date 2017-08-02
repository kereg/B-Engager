<?php
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

  function AnalyzeComments() {

  }

  function GenerateScoreObj($shareAmount, $commentsArr, $timeAlive, $negFeedbackAmount,
                            $sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount, $likeAmount) {
    $this->finalScoreObj->Shares = $this->getSharesScore($shareAmount);
    $this->finalScoreObj->Reactions = $this->getReactionsScore($sadAmount, $hahaAmount, $angerAmount, $wowAmount, $loveAmount, $likeAmount);
    $this->finalScoreObj->Comments = $this->getCommentsScore($commentsArr);
    $this->finalScoreObj->Total = $this->finalScoreObj->Shares + $this->finalScoreObj->Reactions + $this->finalScoreObj->Comments;
  }

  private function getSharesScore($amount, $max) {
    return $amount/$max*100;
  }

  private function getReactionsScore($reactions) {
  }

  private function getCommentsScore($commentArr) {

  }
}