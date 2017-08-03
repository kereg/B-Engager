<?php
require_once 'WatsonApi.php';
$wApi = new WatsonApi();
echo $wApi->getTextAnalysis('I love you. I have nothing :(');
