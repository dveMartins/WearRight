<?php
require_once '../core/config.php';

$user = new Users();
if($user->logout()) {
    $user->redirect("index.php");
}



