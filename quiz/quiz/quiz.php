<?php

require '../admin/vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
  'collect' => true,
  'output' => true,
));

  session_start();
  require "../admin/core/prefix.php";
  require "../admin/inc/damares_version.php";

  spl_autoload_register('autoloader');

  function autoloader($class){
      include("../admin/class/$class.php");
  }

  $database = new Database();
  $db = $database->getConnection(); 

  include "../admin/inc/class_initialize.php";

  $quiz_id = filter_input(INPUT_GET,'quiz_id') ;
  setcookie("damares-current-quiz", $quiz_id, time()+(60 * 60 *24 * 365 *10 ),"/");
  $rel_id = filter_input(INPUT_GET,'rel_id') ;
  setcookie("damares-orig-rel", $rel_id, time()+(60 * 60 *24 * 365 *10 ),"/");
  $page_origin = filter_input(INPUT_GET,'p') ;
  
  $quiz->table = "quiz" ;
  $quiz->id = $quiz_id ;
  $stmt = $quiz->showAllWhere('id',['id']) ;
  $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
  extract($row) ;
  
  $q_name = str_replace("_", " ", $row['quiz_name']) ;
  $q_name = ucfirst($q_name);

  ?>

<!DOCTYPE html>
<html>
  <head>
    <title><?=$q_name?></title>
    <meta charset="utf-8">
      <!-- Style CSS -->
      <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="quiz.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="quiz.js"></script>
  </head>
  <body>
   

    <div id="quizWrap">
      <?php
      
      $data=[];
      if(isset($_COOKIE['damares-quiz-ans'])){
        $data = json_decode($_COOKIE['damares-quiz-ans'],true);
      }
        if(isset($data)&&in_array($quiz_id,$data)){
    ?>
      <div class="p-5">
        <h3 class="text-center">Hai già risposto al quiz</h3>
        <a href="../relation-details.php?id=<?=$rel_id?>&p=<?=$page_origin?>&quiz=ok"> <- Torna indietro</a>
      </div>
    <?php
      }else{
    ?>
      <div id="quizQn"></div>
      <div id="quizAns"></div>
    <?php
      }
    ?>
    </div>
  </body>
</html>