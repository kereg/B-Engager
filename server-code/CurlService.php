<?php

/**
 * Created by PhpStorm.
 * User: gal
 * Date: 02/08/2017
 * Time: 13:50
 */
class CurlService
{
    public static function getCurlResponse($url, $method="GET",$postFields="",$curlOptions=array()){
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_IGNORE_CONTENT_LENGTH, 1);

        foreach ($curlOptions as $optionName => $value){
            curl_setopt($ch, $optionName, $value);
        }
        if ($postFields){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        }

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($info["http_code"] !== 200){

            throw new Exception("Error when calling $url. Error code: ".$info["http_code"].". Data: ".$response);
        }

        return $response;
    }

    public static function makeFbGetApiCall($url, $method="GET",$limit=0){

        $counter = 0;
        $response = array();
        do {
            $ans = self::getCurlResponse($url,$method);
            $data = json_decode($ans, true);
            $realData = isset($data['data']) ? $data['data'] : $data;

            $response = array_merge($response, $realData);

            $url = isset($data['paging']['next']) ? $data['paging']['next'] : null;
            unset($data);
            unset($realData);
            $counter++;
            if ($limit && $counter>=$limit){
                break;
            }
        }while (!empty($url));

        return $response;
    }
}