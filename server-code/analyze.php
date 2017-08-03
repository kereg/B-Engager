<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017-08-02
 * Time: 12:16 PM
 */

require_once $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/page/AnalyzePage.php";
use page\AnalyzePage;

//$link = mysqli_connect("10.0.0.66","root","13131313","prosper");

try{
    $analyze = new AnalyzePage($pageId,$accessToken,$postIds);
    $data = $analyze->analyzePage();
    $jsonData = json_encode(array("data" => $data));
    //mysqli_query($link,"INSERT INTO bengager_responses ")
    echo $jsonData;
}
catch (\Exception $e){
    echo $e->getMessage();
}
