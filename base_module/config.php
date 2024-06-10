<?php

// plugin information

$pluginname = "base_module";
$description = "Lorem ipsum";
$link_parent = "base_module";

// query to create the tables and insert values

$query_create_table = "CREATE TABLE IF NOT EXISTS " . $prefix . "table_name
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      field VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "second_table_name
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      field VARCHAR(255) NOT NULL;";

// the data of the parent item of the menu

$parent_table = [[
      'link' => 'base_module',
      'label' => 'Base module',
      'icon' => 'icon-name'
]];

// the data of the child item of the menu
// they will automatically get the previous parent item id

$child_table = [
      [
            'link' => 'allBaseModule',
            'label' => 'All base module',
            'icon' => 'icon-name'
      ],
      [
            'link' => 'addBaseModule',
            'label' => 'Add a new base module',
            'icon' => 'people-fill'
      ]
];

$query_drop_table = "DROP TABLE  " . $prefix . "table_name, " . $prefix . "second_table_name, " . $prefix . "luna_users ";
