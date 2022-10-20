<?php 
require_once('../views/AboutDoc.php');
require_once('../models/PageModel.php');
$model = new PageModel();
$test = new AboutDoc($model);
$test->show();
?>