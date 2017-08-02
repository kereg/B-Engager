<?php

/**
 * Created by PhpStorm.
 * User: gal
 * Date: 02/08/2017
 * Time: 13:50
 */
class CurlService
{
    public static function getCurlRespone($url,$method="GET"){
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($info["http_code"] !== 200)
            throw new Exception("Error when calling $url");

        return $response;
    }
}