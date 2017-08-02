<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017-08-02
 * Time: 12:16 PM
 */
require_once ("page/Page.php");

use page\Page;
$accessToken = "EAAB6opDWvN4BACyLBMY2P1MosVZAZBWg1JtjXWyh4q7QX7ZBcrlQUfCdmhlH0cbKfRj099fF3Q1LTFAiy2exFQFcv7EFidw5BYoh35TUup74CCfJrrC7ntgTJiL3GhP3e6hDwzDrZAnpkI64zB2paUIkc3u2o2JlL9pUu5cq3AZDZD";
$pageId = "1385846988131069";

try{
    $pagePosts = new Page($pageId,$accessToken);
    echo $pagePosts->getPosts();
}
catch (\Exception $e){
    echo $e->getMessage();
}
