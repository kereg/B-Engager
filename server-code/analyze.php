<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017-08-02
 * Time: 12:16 PM
 */

require_once $_SERVER['DOCUMENT_ROOT']."/B-Engager/server-code/page/AnalyzePage.php";
use page\AnalyzePage;


$accessToken = "EAAB6opDWvN4BACyLBMY2P1MosVZAZBWg1JtjXWyh4q7QX7ZBcrlQUfCdmhlH0cbKfRj099fF3Q1LTFAiy2exFQFcv7EFidw5BYoh35TUup74CCfJrrC7ntgTJiL3GhP3e6hDwzDrZAnpkI64zB2paUIkc3u2o2JlL9pUu5cq3AZDZD";
$pageId = "1385846988131069";

try{
    $analyze = new AnalyzePage($pageId,$accessToken);
    echo $analyze->analyzePage();
}
catch (\Exception $e){
    echo $e->getMessage();
}
