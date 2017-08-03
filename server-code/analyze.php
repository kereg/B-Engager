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

if(isset($_REQUEST['pageId']) && !empty($_REQUEST['pageId'])){
    $pageId = $_REQUEST['pageId'];
}

/*if (isset($_REQUEST['weightComments']
$_REQUEST['weightReactions']
$_REQUEST['weightShares']
weightComments=0.33&weightReactions=0.33&weightShares=0.33*/

try{
    if (file_exists("json-presets/$pageId.json")){
        $jsonData = file_get_contents("json-presets/$pageId.json");
        //Sort by best score
        $analyze = new AnalyzePage(null,null,null);
        $analyze->sortByScore(json_decode($jsonData,true));
    }
    else{
        $accessToken = getAccessToken($pageId);

        if (!isset($postIds)){
            $postIds = null;
        }
        $analyze = new AnalyzePage($pageId,$accessToken,$postIds);
        $data = $analyze->analyzePage();
        $jsonData = json_encode(array("data" => $data));
    }

    echo $jsonData;
}
catch (\Exception $e){
    echo $e->getMessage();
}
