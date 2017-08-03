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



try{
    $analyze = new AnalyzePage($pageId,$accessToken,$postIds);
    echo "<pre>".
        print_r($analyze->analyzePage(),true).
    "</pre>";
}
catch (\Exception $e){
    echo $e->getMessage();
}
