<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();

function pr($data){
echo "<pre>",print_r($data),"</pre>";
}

function pr1($data){
echo "<pre>",print_r($data),"</pre>";
die;
}
