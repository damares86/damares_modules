<?php

require "inc/header.php";

// require "inc/sidebar.php";

?>

<div class="page-content-wrapper">

  <?php
  require "inc/visual.php";
  ?>

  <div class="pt-3"></div>

  <div class="container">

    <?php

    require "inc/alert.php";

    $q_id = filter_input(INPUT_GET, 'id');
    $quiz->table = 'quiz';
    $quiz->id = $q_id;
    $stmt1 = $quiz->showAllWhere('id', ['id']);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    extract($row1);
    $name = ucfirst($row1['quiz_name']);
    $name = str_replace("_", " ", $name);
    ?>


    <div class="card bg-lightt mb-3">
      <div class="card-body">
        <div class="text-left">
          <?php
          $quiz->quiz_id = $q_id;
          $quiz->table = "quiz";

          $stmt4 = $quiz->showAllWhere('id', ['id']);
          $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
          extract($row4);
          ?>
          <!-- <h4><?= $row4['quiz_name'] ?></h4> -->
          <div class="service-text text-info">
            <h3 class="text-info"><?= $name ?></h3>
            <?php

            $quiz->quiz_id = $q_id;
            $quiz->table = "quiz_scores";
            $stmt2 = $quiz->showAllWhere('id', ['quiz_id']);
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            extract($row2);
            $score = unserialize($row2['answer']);

            $account->id = $row2['winner_id'];
            $stmt3 = $account->showAllWhere('id', ['id']);
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            extract($row3);
            $details = unserialize($row3['details']);

            ?>
            <!-- ##### winner quiz #####-->
            <h6 class="my-5 p-4 winner"><?= $quiz_fe_winner ?>: <span class="font-weight-bold text-decoration-underline"><?= $details[0]['nome'] ?> <?= $details[1]['cognome'] ?></h6>

            <div>
              <?php

              require "quiz/q_$q_id/qna.php";
              for ($i = 0; $i < count($quiz); $i++) {
                $question = $quiz[$i]['q'];
                $ans = $quiz[$i]['o'];

              ?>

                <h4><?= $question ?></h4>
                <?php

                $i_ans = 0;
                $vote_tot = 0;
                // progress bar to take out? 
                foreach ($score[$i] as $votes) {
                  $vote_tot += $votes;
                }

                for ($j = 0; $j < count($ans); $j++) {

                  $value = ceil((100 * $score[$i][$j]) / $vote_tot);

                ?>
                  <div class="card bg-light text-info bg-gradient mb-3 p-3">
                    <div class="skill-progress-bar d-flex align-items-center">
                      <!-- Skill Data -->
                      <div class="skill-data">
                        <!-- Skill Name-->
                        <div class="skill-name d-flex align-items-center justify-content-between">
                          <p class="mb-1"></p>
                          <small class="mb-1"><span><?= $value ?></span>%</small>
                        </div>
                        <!-- Progress -->
                        <div class="progress" style="height: 4px;">
                          <div class="progress-bar" style="width: <?= $value ?>%;" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                    <p class="text-info mt-2"><span class="answer"><?= $quiz[$i]['o'][$j] ?></span></p>
                  </div>
              <?php
                }
              }


              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>

<div class="pb-3"></div>
</div>


<?php
require "inc/footer.php";
?>