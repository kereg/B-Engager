<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017-08-02
 * Time: 9:16 PM
 */

require_once $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/score-generator/ScoreGenerator.php";

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
  public function __construct($dataArr, $weightShares=0.33, $weightReactions=0.33, $weightComments=0.33) {
    $this->updateMaxAmounts($dataArr);
    $this->scoreGen = new ScoreGenerator($this->maxComments, $this->maxReactions, $this->maxShares, $weightShares, $weightReactions, $weightComments);
  }

  private function updateMaxAmounts($dataArr) {
    $this->maxShares = 0;
    $this->maxComments = 0;
    $this->maxReactions = 0;
    foreach ($dataArr as $dataObj) {
      $this->maxShares = max($dataObj["totals"]["shares"], $this->maxShares);
      $this->maxComments = max($dataObj["totals"]["comments"], $this->maxComments);
      $this->maxReactions = max($dataObj["totals"]["reactions"], $this->maxReactions);
    }
  }

  public function getScores($dataArr) {
    $resultArr = array();
    $curTime = new DateTime();
    foreach ($dataArr as $dataObj) {
      $daysAlive = $curTime->diff(new DateTime($dataObj["created_time"]))->d;
      $arr = $dataObj["totals"];
      $scoreObj = $this->scoreGen->generateScoreObj($arr["shares"], $dataObj['comments'], $daysAlive, $arr["post_negative_feedback"],
        $arr["sorry"], $arr["haha"], $arr["anger"], $arr["wow"], $arr["love"], $arr["like"], $arr['reactions']);
      array_push($resultArr, $scoreObj);
    }
    return $resultArr;
  }
}