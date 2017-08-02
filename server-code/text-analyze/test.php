<?php
require_once 'WatsonApi.php';
$wApi = new WatsonApi();
echo $wApi->getTextAnalysis("im good");
