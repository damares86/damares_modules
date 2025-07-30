<?php
$quiz_dir = '../../quiz/';

if ($op == 'add') {

	if (!is_dir($quiz_dir)) {
		$oldmask = umask(0);
		mkdir($quiz_dir, 0777, true);
		umask($oldmask);
	}

	// copy quiz files
	if ($common->copyDirectory('../plugins/quiz/quiz', $quiz_dir)) {
		$common->chmod_R($quiz_dir, 0777);
	} else {
		$error++;
	}
}else if($op == 'rm'){

	$quiz->rmdir_recursive($quiz_dir) ;
	

}

require "config.php" ;
