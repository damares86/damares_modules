<?php

require "admin/template/inc/header.php";

$story->table = 'story';
$story_stmt = $story->showAll('id');

?>
<link rel="stylesheet" href="admin/assets/css/story.css" />
<div class="bottomContainer">
	<section class="stories py-5">
		<div class="container">
			<div class="row gx-5">
				<div class="col-12 text-center mb-5">
					<h1><?= $stories_title ?></h1>
				</div>
				<?php
				while ($story_row = $story_stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($story_row);
					$chapters = 0;
				?>
					<div class="col-sm-4 story_title">
						<h1><?= $story_row['title'] ?></h1>
						<?php
						$story->table = 'story_chapters';
						$story->story_id = $story_row['id'];
						$chapters = $story->countItem('story_id');
						?>
						<p><b><?= $stories_chapters ?>:</b> <?= $chapters ?><br>
							<?php
							$completed = $story_row['completed'] == 0 ? $stories_no : $stories_yes;
							?>
							<b><?= $stories_completed ?>:</b> <?= $completed ?>
						</p>
					</div>
					<div class="col-sm-8 story_description">
						<b><?= $stories_description ?>:</b><br>
						<?= $story_row['description'] ?><br>
						<a href="single_story.php?id=<?= $story_row['id'] ?>"><?= $storied_read ?></a>
					</div>

				<?php
				}
				?>
			</div>

		</div>
	</section>
</div>

<div class="clearfix"></div>
<?php
require "admin/template/inc/footer.php";

?>