<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Quiz extends Common
{

    public $quiz_name;
    public $quiz_id;
    public $relation_id;
    public $active;
    public $winner_id;
    public $counter;
    public $answer;
    public $user_id;
    public $scores;

    public function checkScore()
    {

        $quiz_id = $this->quiz_id;

        $this->table = 'quiz';
        $this->id = $quiz_id;
        $stmt1 = $this->showAllWhere('id', ['id']);
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        extract($row1);
        $counter = $row1['counter'];

        $this->table = 'quiz_' . $quiz_id;
        $stmt = $this->showAll('id');

        // in base al numero di domande creo gli array per storare:
        // - id e tempi di risposta per le singole domande 
        //       in caso di risposta positiva ($ans_1, ecc)
        // - utenti divisi in base al numero di risposte corrette
        //       (es. su 5 domande, un elemento conterrà chi ha dato 5 risposte corrette, ecc)

        for ($j = 1; $j <= $counter; $j++) {

            $label_ans = 'ans_' . $j;
            $$label_ans = [];
            $label_correct = 'corr_' . $j;
            $$label_correct = [];
        }

        // prendo le domande del quiz
        require "../../quiz/q_$quiz_id/qna.php";

        // ciclo tutte le domande
        for ($i = 0; $i < count($quiz); $i++) {

            $real_i = $i + 1;

            // ciclo le risposte e creo le variabili da incrementare per tenere traccia del numero di risposte
            for ($idx = 0; $idx < count($quiz[$i]['o']); $idx++) {
                $label = 'question_' . $real_i . '_ans_' . $idx;
                $$label = 0;
            }
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $answer_counter = 0;

            // ciclo gli utenti che hanno risposto al quiz con i relativi voti
            $answer = json_decode($row['scores'], true);

            // ciclo le risposte dell'utente
            foreach ($answer as $json) {

                // singola risposta
                // struttura:
                // Array ( [id] => id_domanda, [begin_time] => 1721053670962 [end_time] => 1721053670963 ) 
                for ($i = 1; $i <= $counter; $i++) {

                    $ans = json_decode($json[$i], true);

                    if ($ans['end_time'] != 0) {

                        // incremento il numero di risposte corrette
                        $answer_counter++;

                        // calcolo il tempo di risposta
                        $time = $ans['end_time'] - $ans['begin_time'];

                        $label_ans = 'ans_' . $ans['id'];
                        // inserisco la risposta con i tempi nell'array della domanda
                        $$label_ans[] = array($row['user_id'] => $time);

                        $label_count = 'question_' . $ans['id'] . '_ans_' . $ans['pick'];
                        $$label_count++;
                    } else {
                        $label_count = 'question_' . $ans['id'] . '_ans_' . $ans['pick'];
                        $$label_count++;
                    }
                    $label_corr = 'corr_' . $answer_counter;
                    $$label_corr[] = $row['user_id'];
                }
            }
        }


        $results = [];

        // ciclo tutte le variabili che ho creato per le risposte e creo l'array con tutte le risposte date
        for ($i = 0; $i < count($quiz); $i++) {

            $real_i = $i + 1;

            $label_question = 'question_' . $i;
            $$label_question = [];

            for ($idx = 0; $idx < count($quiz[$i]['o']); $idx++) {
                // $real_idx = $idx+1 ;
                $label = 'question_' . $real_i . '_ans_' . $idx;
                $$label_question[] = $$label;
            }

            $result[] = $$label_question;
        }

        // inizio il calcolo del vincitore
        $best_time = PHP_INT_MAX;
        $winner = 0;

        for ($j = $counter; $j > 0; $j--) {
            // controllo se l'array col numero più alto (es in caso di 5 domande è $corr_5) ha elementi, altrimenti scendo
            $label = 'corr_' . $j;

            if (!empty($$label)) {

                if (count($$label) > 1) {
                    // c'è più di un elemento

                    foreach ($$label as $users) {
                        // ciclo gli id dell'array delle risposte corrette
                        $total_time = 0;

                        echo $users . '<br>';

                        for ($idx = 1; $idx <= $counter; $idx++) {
                            // ciclo gli array delle domande e sommo i tempi del singolo utente

                            $arr = 'ans_' . $idx;

                            echo $arr . '<br>';
                            foreach ($$arr as $item) {

                                print_r($item);
                                echo '<br>';
                                // se e quando trovo l'id dell'utente nell'array delle domande
                                // prendo il tempo e lo sommo al total_time
                                if (array_key_exists($users, $item)) {
                                    $total_time += $item[$users];
                                    echo 'user time -> ' . $total_time . '<br>';
                                }
                            }
                        }

                        // confronto il tempo, se minore diventa il nuovo best_time e il winner diventa l'id corrente
                        if ($total_time < $best_time) {
                            $best_time = $total_time;
                            echo 'best time -> ' . $best_time . '<br>';
                            $winner = $users;
                            echo 'winner -> ' . $winner . '<br>';
                        }
                    }
                } else {
                    // l'unico id è il vincitore
                    $winner = $$label[0];
                }

                // inserisco vincitore e risposte nel db
                $this->table = 'quiz_scores';
                $this->quiz_id = $quiz_id;
                $this->winner_id = $winner;
                $this->answer = serialize($result);

                if (!$this->insert(['quiz_id', 'winner_id', 'answer'])) {
                    header("Location: ../index.php?p=editQuiz&idToMod=$id&err=scoreQuizErr");
                    exit;
                } else {
                    return $winner;
                }
            }
        }
        exit;
    }
}
