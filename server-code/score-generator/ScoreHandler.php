<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017-08-02
 * Time: 9:16 PM
 */

class ScoreHandler {
  private $scoreGen;
  private $maxShares;
  private $maxComments;
  private $maxReactions;

  /**
   * ScoreHandler constructor.
   * @param $dataArr
   * @param $weightShares
   * @param $weightReactions
   * @param $weightComments
   * @internal param $scoreGen
   */
  public function __construct($dataArr, $weightShares, $weightReactions, $weightComments) {
    $this->updateMaxAmounts($dataArr);
    $this->scoreGen = new ScoreGenerator($this->maxComments, $this->maxReactions, $this->maxShares, $weightShares, $weightReactions, $weightComments);
  }

  private function updateMaxAmounts($dataArr) {
    $this->maxShares = 0;
    $this->maxComments = 0;
    $this->maxReactions = 0;
    foreach ($dataArr as $dataObj) {
      $this->maxShares = max($dataObj["totals"]["share"], $this->maxShares);
      $this->maxComments = max($dataObj["totals"]["comment"], $this->maxComments);
      $this->maxReactions = max($dataObj["totals"]["reactions"], $this->maxReactions);
    }
  }

  public function getScores($dataArr) {
    foreach ($dataArr as $dataObj) {
      $totalsArr = $dataObj["totals"];
      $this->scoreGen->GenerateScoreObj($totalsArr["share"], $totalsArr["reaction"])
    }
    $this->scoreGen->GenerateScoreObj();
  }
}