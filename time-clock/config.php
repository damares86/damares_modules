<?php

// plugin information

$pluginname = "Time clock";
$description = "Time clock";
$link_parent = "A modulo for import employees stamping from xls file";

// query to create the tables and insert values

$query_create_table = "CREATE TABLE IF NOT EXISTS $prefix`employee` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(190) NOT NULL,
  `badge` VARCHAR(50) DEFAULT NULL COMMENT 'User ID del lettore badge',
  `h_mon` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `h_tue` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `h_wed` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `h_thu` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `h_fri` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  `notes` TEXT,
  PRIMARY KEY (`id`),
  KEY `idx_employee_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `punch` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `employee_id` INT(11) NOT NULL,
  `punch_date` DATE NOT NULL,
  `punch_time` TIME NOT NULL,
  `source` VARCHAR(190) DEFAULT NULL COMMENT 'nome file importato',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_punch` (`employee_id`,`punch_date`,`punch_time`),
  KEY `idx_punch_date` (`punch_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

// the data of the parent item of the menu

$menu_link = [[
      'link' => 'time-clock',
      'label' => 'Time clock',
      'icon' => 'alarm-fill',
      'child' => [
            [
                  'link' => 'allEmployees',
                  'label' => 'All employees',
                  'icon' => 'people-fill',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'addEmployee',
                  'label' => 'Add employee',
                  'icon' => 'people-fill',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'editEmployee',
                  'label' => 'Edit employee',
                  'icon' => 'people-fill',
                  'show_menu' => '0'
            ],[
                  'link' => 'importTimbrature',
                  'label' => 'Import stamping',
                  'icon' => 'person-badge-fill',
                  'show_menu' => '1'
            ],
      ]
]];

$query_drop_table = "DROP TABLE  " . $prefix . "employee, " . $prefix . "punch";


// an xls sample is in the "misc" folder