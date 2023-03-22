<?php

// plugin information

$pluginname = "user_register" ;
$description = "Allow user to register with a simple form" ;
$link_parent = "settings" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS  ".$prefix."register_account_temp (
   email VARCHAR(250) NOT NULL PRIMARY KEY,
   token VARCHAR(250) NOT NULL,
   expDate DATETIME NOT NULL);";

$child_table=[['link'=>'regSetting',
                'label'=>'User register',
                'icon'=>'person-badge']];

$query_drop_table = "DROP TABLE  ".$prefix."register_account_temp;";

?>