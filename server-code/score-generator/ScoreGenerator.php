<?php
class ScoreGenerator {
  //Raw Data
  private $shareAmount;
  private $reactionsObj;
  private $commentsArr;
  private $timeAlive;
  private $negFeedbackAmount;
  private $commentsAmount;

  //Score Data
  /**
   * @var Score
   */
  private $finalScoreObj;

  /**
   * ScoreGenerator constructor.
   * @param int $shareAmount
   * @param string $reactionsObj
   * @param $commentsArr
   * @param $timeAlive
   * @param $negFeedbackAmount
   * @param $maxComments
   * @param $maxReactions
   * @param $maxShares
   * @param $weightShares
   * @param $weightReactions
   * @param $weightComments
   * @internal param $likesAmount
   */
  public function __construct($shareAmount, $reactionsObj, $commentsArr, $timeAlive, $negFeedbackAmount, $maxComments,
                              $maxReactions, $maxShares, $weightShares, $weightReactions, $weightComments) {
    $this->shareAmount = $shareAmount;
    $this->reactionsObj = $reactionsObj;
    $this->commentsArr = $commentsArr;
    $this->commentsAmount = count($commentsArr);
    $this->timeAlive = $timeAlive;
    $this->negFeedbackAmount = $negFeedbackAmount;
    $this->finalScoreObj = new Score();
  }

  function AnalyzeComments() {

  }

  function GenerateScoreObj() {
    $this->finalScoreObj->Shares = $this->getSharesScore();
    $this->finalScoreObj->Reactions = $this->getReactionsScore();
    $this->finalScoreObj->Comments = $this->getCommentsScore();
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