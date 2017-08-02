<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017-08-02
 * Time: 10:54 AM
 */

class WatsonApi {
  const USERNAME = '3294d764-0a96-4119-9cc7-7d933d0901c7';
  const PASSWORD = 'x2iacP7OLb6x';
  const URL = 'https://gateway.watsonplatform.net/tone-analyzer/api/v3/tone?version=2016-05-19';

  function getTextAnalysis($text) {
     $data = json_encode(array('text' => $text));

     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,self::URL);
     curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
     curl_setopt($ch, CURLOPT_USERPWD, self::USERNAME . ':' . self::PASSWORD);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

     $result=curl_exec ($ch);
     curl_close ($ch);

     return $result;
  }


}