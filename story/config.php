<?php

// plugin information

$pluginname = "story";
$description = "Publish short stories with multiple chapters";
$link_parent = "story";

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS " . $prefix . "story
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255),
      description TEXT DEFAULT NULL,
      completed INT(1) DEFAULT 0) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
      CREATE TABLE IF NOT EXISTS story_chapters
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
       num INT(5) DEFAULT 1,
       content longtext NOT NULL,
       story_id INT(5) NOT NULL)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
      'link' => 'story',
      'label' => 'Story',
      'icon' => 'book',
      'child' => [
            [
                  'link' => 'addStory',
                  'label' => 'Create a new story',
                  'icon' => 'journal-plus',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'allStories',
                  'label' => 'All Stories',
                  'icon' => 'journal-bookmark',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'editStory',
                  'label' => 'Edit story',
                  'icon' => 'icon',
                  'show_menu' => '0'
            ]
      ]
]];

$query_drop_table = "DROP TABLE  " . $prefix . "story, " . $prefix . "story_chapters";
