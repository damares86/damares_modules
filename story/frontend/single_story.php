<?php

require "admin/template/inc/header.php";

$story->table = 'story';
$story_id = filter_input(INPUT_GET, 'id');
$story->id = $story_id;
$story_stmt = $story->showAllWhere('id', ['id']);
$story_row = $story_stmt->fetch(PDO::FETCH_ASSOC);
extract($story_row);

$story->table = "story_chapters";
$chapter_num = filter_input(INPUT_GET, 'chapter') ? filter_input(INPUT_GET, 'chapter') : 1;
$story->num = $chapter_num;
$story->story_id = $story_id;
$chapter_stmt = $story->showAllWhere('id', ['story_id', 'num']);
$chapter_row = $chapter_stmt->fetch(PDO::FETCH_ASSOC);
extract($chapter_row);


?>
<link rel="stylesheet" href="admin/assets/css/story.css" />
<div class="bottomContainer">
    <section class="single_story py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-12 col-lg-8">
                    <?php

                    if (isset($_SESSION['loggedin'])) {

                    ?>
                        <!-- <div class="text-right">

                        <a href="admin/index.php?p=editPost&idToMod=<?= $post_title_row['id'] ?>" class="btn btn-primary btn-sm"><b><?= $post_edit ?></b></a>
                    </div> -->
                    <?php
                    }


                    ?>

                    <h1 class="mb-5 text-center"><?= $story_row['title'] ?></h1>

                    <div class="single_story_content">

                        <p class="text-center mb-3"><u><?= $singlestory_chapter ?> <?= $chapter_row['num'] ?></u></p>
                        <p><?= $chapter_row['content'] ?></p>
                        <?php
                        $story->table = 'story_chapters';
                        $story->story_id = $story_id;

                        $list_stmt = $story->showAllWhere('num', ['story_id']);
                        $chapter_list = [];
                        while ($list_row = $list_stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($list_row);
                            $chapter_list[] = $list_row['num'];
                        }
                        ?>
                        <div class="arrows">
                            <?php
                            if ($chapter_num > 1) {
                                $previous = $chapter_num - 1;
                            ?>
                                <a href="single_story.php?id=<?= $story_id ?>&chapter=<?= $previous ?>"><?= $singlestory_previous ?></a> &nbsp; &nbsp; &nbsp;
                            <?php
                            }
                            $next = $chapter_num + 1;
                            if (in_array($next, $chapter_list)) {
                            ?>
                                <a href="single_story.php?id=<?= $story_id ?>&chapter=<?= $next ?>"><?= $singlestory_next ?></a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>

                <?php

                require "story_sidebar.php";

                ?>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
</div>
<?php
require "admin/template/inc/footer.php";

?>