<?php 
require_once('../views/BasicDoc.php');
require_once('../models/PageModel.php');
$model = new PageModel();
$test  = new BasicDoc($model);
$test->show();
?>