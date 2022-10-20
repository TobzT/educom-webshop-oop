<?php 
require_once('../views/HomeDoc.php');
require_once('../models/PageModel.php');
$model = new PageModel();
$test = new HomeDoc($model);
$test->show();
?>