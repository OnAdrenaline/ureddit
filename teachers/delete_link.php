<?php

require_once('../init.php');

if(!logged_in())
    send_user_to("/login.php");

$user = new user($dbpdo, $_SESSION['user_id']);
$lecture = new lecture($dbpdo, $_GET['lecture']);

$class = new course($dbpdo, $lecture->class_id);
$class->get_owner();
$class->get_teachers();
$class->get_categories();
$class->get_attributes();

if($class->owner != $user->id && !in_array($user->id, $class->teachers))
  send_user_to("/class/" . $class->id . "/" . $class->seo_string($class->value));

$lecture->get_links();
if(in_array($_GET['link'],$lecture->links))
  {
    $link = new link($lecture->dbpdo, $_GET['link']);
    $link->delete();
  }

send_user_to("/class/" . $class->id . "/lectures");

?>