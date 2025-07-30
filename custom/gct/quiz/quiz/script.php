<?php

spl_autoload_register('autoloader');

function autoloader($class)
{
  include("../admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files = glob("../admin/class/*.php", GLOB_BRACE);
rsort($files);

require "../admin/inc/class_initialize.php";

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

file_put_contents('php://stderr', print_r($_POST, true));

$sess_id = $_SESSION['account_id'];
$q_id = $_COOKIE['damares-current-quiz'];

$file = "error.log" ;

$arr_tot[] = $_POST['total'];
$json = json_encode($arr_tot);

$quiz->table = 'quiz_' . $q_id;
$quiz->user_id = $sess_id;
$quiz->scores = $json;

if (!$quiz->insert(['user_id', 'scores'])) {
    file_put_contents($file, 'error '.PHP_EOL.'', FILE_APPEND);
} else {
    file_put_contents($file, 'ok '.PHP_EOL.'', FILE_APPEND);
}

// $file = 'q_'.$q_id.'/score/'.$sess_id.'.json';
// for test
// $arr_tot[]=$_POST;
// $arr_tot[]=$_POST['total'];
// $json=json_encode($arr_tot);
// file_put_contents($file, $json, FILE_APPEND);
// chmod($file,0777);

$data = [];

if (isset($_COOKIE['damares-quiz-ans'])) {

    $data = json_decode($_COOKIE['damares-quiz-ans'], true);

    $data[] = $q_id;

    $json = $data;
} else {

    $json = [$q_id];
}

setcookie("damares-quiz-ans", json_encode($json), time() + (60 * 60 * 24 * 365 * 10), "/");
