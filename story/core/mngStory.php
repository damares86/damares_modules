<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . "/coreConfig.php";


if (filter_input(INPUT_GET, "idStoryToDel")) {

    $story_id = filter_input(INPUT_GET, "idStoryToDel");
    $story->table = 'story';
    $story->id = $story_id;
    
    if ($story->delete('id')) {
        
        $story->table = "story_chapters";
        $story->story_id = $story_id ;

        $stmt = $story->showAllWhere('id',['story_id']);
        $error = 0 ;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $story->table = 'story_chapters';
            $story->id = $row['id'];
            if(!$story->delete('id')){
                $error++;
            }
        }
        
        $err_chapter = $error >0 ? '&err=chapterDelFail' : '' ;

        header("Location: ../index.php?p=allStories&msg=storyDel$err_chapter");
        exit;
    } else {
        header("Location: ../index.php?p=allStories&err=storyNoDel");
        exit;
    }
} else if (filter_input(INPUT_GET, "idChapterToDel")) {
    $story->table = 'story_chapters';
    $story->id = filter_input(INPUT_GET, "idChapterToDel");;
    $story_id = filter_input(INPUT_GET, "story_id");

    if ($story->delete('id')) {
        header("Location: ../index.php?p=editStory&idToMod=$story_id&msg=chapterDelSucc");
        exit;
    } else {
        header("Location: ../index.php?p=editStory&idToMod=$story_id&err=chapterDelFail");
        exit;
    }
}

$operation = filter_input(INPUT_POST, "operation");

// check if there's a customer to edit or add

if ($operation == "edit") {

    $idToMod = filter_input(INPUT_POST, "idToMod");

    $url_tablePage = filter_input(INPUT_POST, 'url_tablePage');
    $url_pageName = filter_input(INPUT_POST, 'url_pageName');

    $url_data = "&tablePage=$url_tablePage&pageName=$url_pageName";

    $story->table = 'story';
    $story->id = $idToMod;
    $story->title = filter_input(INPUT_POST, 'title');
    $story->description = filter_input(INPUT_POST, 'description');
    $story->completed = filter_input(INPUT_POST, 'completed') ? 1 : 0;

    if ($story->update(['title', 'description', 'completed'], 'id')) {

        //success
        header("Location: ../index.php?p=editStory$url_data&idToMod=$idToMod&msg=storyEditSucc");
        exit;
    } else {

        // fail
        header("Location: ../index.php?p=editStory$url_data&idToMod=$idToMod&err=storyEditFail");
        exit;
    }
} else if ($operation == "add") {

    $story->table = "story" ;
    $story->title = filter_input(INPUT_POST,'title');
    $story->description = filter_input(INPUT_POST,'description');

    if($story->insert(['title','description'])){
        header("Location: ../index.php?p=allStories&msg=storyAddSucc");
        exit;
    } else {
        header("Location: ../index.php?p=allStories&err=storyAddFail");
        exit;
    }

} else if ($operation == "addChapter") {

    $url_tablePage = filter_input(INPUT_POST, 'url_tablePage');
    $url_pageName = filter_input(INPUT_POST, 'url_pageName');

    $url_data = "&tablePage=$url_tablePage&pageName=$url_pageName";

    $story_id = filter_input(INPUT_POST, 'story_id');
    $story->table = "story_chapters";
    $story->num = filter_input(INPUT_POST, 'num');
    $story->content = filter_input(INPUT_POST, 'content');
    $story->story_id = $story_id;

    if ($story->insert(['num', 'content', 'story_id'])) {
        //success
        header("Location: ../index.php?p=editStory$url_data&idToMod=$story_id&msg=addChapterSucc");
        exit;
    } else {
        // fail
        header("Location: ../index.php?p=editStory$url_data&idToMod=$story_id&err=addChapterFail");
        exit;
    }
} else if ($operation == "editChapter") {

    $url_tablePage = filter_input(INPUT_POST, 'url_tablePage');
    $url_pageName = filter_input(INPUT_POST, 'url_pageName');

    $url_data = "&tablePage=$url_tablePage&pageName=$url_pageName";

    $story_id = filter_input(INPUT_POST, 'story_id');

    $error = 0;
    $chapter_ids = $_POST['chapter_ids'];

    foreach ($chapter_ids as $chapter_id) {

        $story->table = "story_chapters";
        $story->num = filter_input(INPUT_POST, "num_$chapter_id");
        $story->content = filter_input(INPUT_POST, "content_$chapter_id");
        $story->id = $chapter_id;

        if (!$story->update(['num', 'content'], 'id')) {
            $error++;
        }
    }
    if ($error == 0) {
        // success
        header("Location: ../index.php?p=editStory$url_data&idToMod=$story_id&msg=editChapterSucc");
        exit;
    } else {
        // fail
        header("Location: ../index.php?p=editStory$url_data&idToMod=$story_id&err=editChapterFail");
        exit;
    }
} else {
    header("Location: ../index.php?p=allStories&err=noPost");
    exit;
}
