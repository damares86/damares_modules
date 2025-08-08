<div class="col-lg-4 d-none d-lg-block blog_sidebar">
	<div class="card border-0 ">
		<div class="card-body p-4">
			<div>
				<div>
					<div class="h6 fw-bolder"><?=$singlestory_sidebar_title?></div>
					<ul>
						<?php
						$story->table = 'story_chapters';
						$story->story_id = $story_id;

						$list_stmt = $story->showAllWhere('num', ['story_id']);

						while ($list_row = $list_stmt->fetch(PDO::FETCH_ASSOC)) {

							extract($list_row);

							if ($list_row['num'] == $chapter_num) {
						?>
								<li><?= $list_row['num'] ?></li>
							<?php
							} else {
							?>
								<li><a href="single_story.php?id=<?= $story_id ?>&chapter=<?= $list_row['num'] ?>"><?= $list_row['num'] ?></a></li>
						<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>