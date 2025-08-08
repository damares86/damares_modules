<?php

$story_id = filter_input(INPUT_GET, 'idToMod');
$story->id = $story_id;
$story->table = 'story';

$stmt1 = $story->showAllWhere('id', ['id']);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);

$url_tablePage = filter_input(INPUT_GET, 'tablePage');
$url_pageName = filter_input(INPUT_GET, 'pageName');
?>


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?=$editstory_header?></h3>
            <a href="index.php?p=<?= $url_pageName ?>&tablePage=<?= $url_tablePage ?>&pageName=<?= $url_pageName ?>" class="btn icon btn-info shadow mx-3 px-3">
                <i class="bi bi-arrow-left-circle"></i> &nbsp; <?= $common_back ?>
            </a>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav
                aria-label="breadcrumb"
                class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?=$editstory_header?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-md-10 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?=$editstory_details?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngStory.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?=$addstory_story_title?><span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Titolo del post"
                                                        id="first-name"
                                                        name="title"
                                                        data-parsley-required="true"
                                                        value="<?= $row1['title'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 my-3">
                                        <label><?=$addstory_description?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 my-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <textarea name="description" class="story tiny" cols="30" rows="15"><?= $row1['description'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label><?=$editstory_completed?></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <?php
                                                    $checked = $row1['completed'] == 1 ? ' checked' : '';
                                                    ?>
                                                    <input type="checkbox" class="form-check-input" name="completed" <?= $checked ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="url_tablePage" value="<?= $url_tablePage ?>">
                                    <input type="hidden" name="url_pageName" value="<?= $url_pageName ?>">

                                    <input type="hidden" name="operation" value="edit">
                                    <input type="hidden" name="idToMod" value="<?= $row1['id'] ?>">
                                    <input type="hidden" name="origin" value="editStory">

                                    <div class="col-12 d-flex justify-content-end">
                                        <button
                                            type="submit"
                                            class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
                                        </button>
                                        <button
                                            type="reset"
                                            class="btn btn-light-secondary me-1 mb-1 shadow">
                                            <?= $common_reset ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?=$editstory_chapters?></h4>
                    <a href="#" class="btn icon btn-success shadow" data-bs-toggle="modal" data-bs-target="#addChapter"><i class="bi bi-plus-circle"></i> <?=$editstory_add_chapters?>
                    </a>
                    <div class="modal fade text-left" id="addChapter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel120">
                                        <?=$editstory_add_chapters?>
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form class="form form-horizontal" action="core/mngStory.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Chapter number<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    name="num"
                                                                    data-parsley-required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3 border-bottom">
                                                    <label>Content <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9 mb-3 border-bottom">
                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <textarea name="content" data-parsley-required="true" class="story tiny" cols="30" rows="15"><?= $chapter_row['content'] ?></textarea>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="url_tablePage" value="<?= $url_tablePage ?>">
                                        <input type="hidden" name="url_pageName" value="<?= $url_pageName ?>">

                                        <input type="hidden" name="operation" value="addChapter">
                                        <input type="hidden" name="story_id" value="<?= $row1['id'] ?>">
                                        <input type="hidden" name="origin" value="editStory">

                                        <div class="modal-footer">
                                            <button
                                                type="submit"
                                                class="btn btn-primary me-1 mb-1 shadow">
                                                <?= $common_submit ?>
                                            </button>
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">


                            <form class="form form-horizontal" action="core/mngStory.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                                <div class="form-body">
                                    <div class="row">

                                        <?php
                                        $story->table = "story_chapters";
                                        $story->story_id = $story_id;
                                        $chapter_stmt = $story->showAllWhere('num', ['story_id']);

                                        while ($chapter_row = $chapter_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <input type="hidden" name="chapter_ids[]" value="<?= $chapter_row['id'] ?>">

                                            <div class="col-md-3">
                                                <label><?=$editstory_chapter_number?><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-check mandatory">
                                                        <div class="position-relative">
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="num_<?= $chapter_row['id'] ?>"
                                                                data-parsley-required="true"
                                                                value="<?= $chapter_row['num'] ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $chapter_row['id'] ?>"> <?=$editstory_delete_chapters?><i class="bi bi-trash"></i>
                                                </a>
                                                <!--Danger theme Modal -->
                                                <div class="modal fade text-left" id="danger<?= $chapter_row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5 class="modal-title white" id="myModalLabel120">
                                                                    <?= $common_modal_title_sure ?>
                                                                </h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?=$editstory_modal_body?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                                                                </button>
                                                                <span class="d-none d-sm-block"><a href="core/mngStory.php?idChapterToDel=<?= $chapter_row['id'] ?>&story_id=<?=$story_id?>" class="btn btn-danger ml-1">
                                                                        <?= $common_modal_confirm ?>
                                                                    </a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3 border-bottom">
                                                <label><?=$editstory_content?> <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-9 mb-3 border-bottom">
                                                <div class="form-group">
                                                    <div class="form-check mandatory">
                                                        <div class="position-relative">
                                                            <textarea name="content_<?= $chapter_row['id'] ?>" data-parsley-required="true" class="story tiny" cols="30" rows="15"><?= $chapter_row['content'] ?></textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php

                                        }
                                        ?>
                                        <input type="hidden" name="url_tablePage" value="<?= $url_tablePage ?>">
                                        <input type="hidden" name="url_pageName" value="<?= $url_pageName ?>">

                                        <input type="hidden" name="operation" value="editChapter">
                                        <input type="hidden" name="story_id" value="<?= $story_id ?>">
                                        <input type="hidden" name="origin" value="editStory">

                                        <div class="col-12 d-flex justify-content-end">
                                            <button
                                                type="submit"
                                                class="btn btn-primary me-1 mb-1 shadow">
                                                <?= $common_submit ?>
                                            </button>
                                            <button
                                                type="reset"
                                                class="btn btn-light-secondary me-1 mb-1 shadow">
                                                <?= $common_reset ?>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-2 col-12">
            <div class="card shadow">
                <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
                <div class="card-content px-5 pb-4">
                    <ul>
                        <li><a href="https://www.dmweblab.com/portal/manual.php?prod=3&page=3" target="_blank"><?= $common_see_guide ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>