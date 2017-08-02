<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017-08-02
 * Time: 9:16 PM
 */

class ScoreHandler {
  private $scoreGen;

  /**
   * ScoreHandler constructor.
   * @param $scoreGen
   */
  public function __construct($dataArr) {
    $this->scoreGen = new ScoreGenerator();
  }


}