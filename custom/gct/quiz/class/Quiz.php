<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Quiz extends Common
{
    public string $table = 'quiz';
    public ?string $quiz_name = null;
    public int|string|null $quiz_id = null;
    public int|string|null $relation_id = null;
    public int|string|null $active = 0;
    public int|string|null $winner_id = null;
    public int|string|null $counter = null;
    public ?string $answer = null;
    public int|string|null $user_id = null;
    public ?string $scores = null;

    /**
     * Compute quiz winner and aggregate score statistics.
     *
     * @return int|string|null
     */
    public function checkScore(): int|string|null
    {
        $quizId = $this->quiz_id;
        if (!$quizId) {
            return null;
        }

        $this->table = 'quiz';
        $this->id = $quizId;
        $stmt1 = $this->showAllWhere('id', ['id']);
        $row1 = $stmt1 ? $stmt1->fetch(PDO::FETCH_ASSOC) : null;
        $counter = (int) ($row1['counter'] ?? 0);

        $this->table = 'quiz_' . (int) $quizId;
        $stmt = $this->showAll('id');

        $ansArr = [];
        $corrArr = [];
        for ($j = 1; $j <= $counter; $j++) {
            $ansArr[$j] = [];
            $corrArr[$j] = [];
        }

        $qnaPath = "../../quiz/q_{$quizId}/qna.php";
        $quiz = [];
        if (is_file($qnaPath)) {
            require $qnaPath;
        }

        $questionAnsCount = [];
        $quizCount = count($quiz);
        for ($i = 0; $i < $quizCount; $i++) {
            $realI = $i + 1;
            $optCount = count($quiz[$i]['o'] ?? []);
            for ($idx = 0; $idx < $optCount; $idx++) {
                $questionAnsCount[$realI][$idx] = 0;
            }
        }

        if ($stmt instanceof PDOStatement) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $answerCounter = 0;
                $answerData = !empty($row['scores']) ? json_decode((string) $row['scores'], true) : [];
                $userId = $row['user_id'] ?? 0;

                if (is_array($answerData)) {
                    foreach ($answerData as $json) {
                        for ($i = 1; $i <= $counter; $i++) {
                            if (!isset($json[$i])) {
                                continue;
                            }
                            $ans = is_array($json[$i]) ? $json[$i] : json_decode((string) $json[$i], true);
                            if (!is_array($ans)) {
                                continue;
                            }

                            $qId = (int) ($ans['id'] ?? $i);
                            $endTime = (int) ($ans['end_time'] ?? 0);
                            $beginTime = (int) ($ans['begin_time'] ?? 0);
                            $pick = (int) ($ans['pick'] ?? 0);

                            if ($endTime !== 0) {
                                $answerCounter++;
                                $time = $endTime - $beginTime;
                                $ansArr[$qId][] = [$userId => $time];
                            }
                            $questionAnsCount[$qId][$pick] = ($questionAnsCount[$qId][$pick] ?? 0) + 1;
                        }
                    }
                }
                if ($answerCounter > 0) {
                    $corrArr[$answerCounter][] = $userId;
                }
            }
        }

        $results = [];
        for ($i = 0; $i < $quizCount; $i++) {
            $realI = $i + 1;
            $rowResults = [];
            $optCount = count($quiz[$i]['o'] ?? []);
            for ($idx = 0; $idx < $optCount; $idx++) {
                $rowResults[] = $questionAnsCount[$realI][$idx] ?? 0;
            }
            $results[] = $rowResults;
        }

        $bestTime = PHP_INT_MAX;
        $winner = null;

        for ($j = $counter; $j > 0; $j--) {
            if (!empty($corrArr[$j])) {
                if (count($corrArr[$j]) > 1) {
                    foreach ($corrArr[$j] as $uId) {
                        $totalTime = 0;
                        for ($idx = 1; $idx <= $counter; $idx++) {
                            foreach ($ansArr[$idx] as $item) {
                                if (array_key_exists($uId, $item)) {
                                    $totalTime += $item[$uId];
                                }
                            }
                        }

                        if ($totalTime < $bestTime) {
                            $bestTime = $totalTime;
                            $winner = $uId;
                        }
                    }
                } else {
                    $winner = $corrArr[$j][0];
                }

                $this->table = 'quiz_scores';
                $this->quiz_id = $quizId;
                $this->winner_id = $winner;
                $this->answer = serialize($results);

                if (!$this->insert(['quiz_id', 'winner_id', 'answer'])) {
                    header("Location: ../index.php?p=editQuiz&idToMod={$quizId}&err=scoreQuizErr");
                    exit;
                }

                return $winner;
            }
        }

        return null;
    }
}
