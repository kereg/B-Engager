<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017-08-02
 * Time: 10:54 AM
 */

require_once $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/CurlService.php";

class WatsonApi {
  const USERNAME = '3294d764-0a96-4119-9cc7-7d933d0901c7';
  const PASSWORD = 'x2iacP7OLb6x';
  const URL = 'https://gateway.watsonplatform.net/tone-analyzer/api/v3/tone?version=2016-05-19';

  function getTextAnalysis($text) {
      
      if (!trim($text)){
          return null;
      }
      $data = json_encode(array('text' => $text));
      $curlOptions = array(
          CURLOPT_USERPWD => self::USERNAME . ':' . self::PASSWORD,
          CURLOPT_HTTPHEADER => array('Content-Type: application/json')
      );
      $response = CurlService::getCurlResponse(self::URL,"POST",$data,$curlOptions);
      return $response;
  }
}