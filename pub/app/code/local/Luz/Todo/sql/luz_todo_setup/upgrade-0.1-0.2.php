<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `luz_todo_task`;
CREATE TABLE `luz_todo_task` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `is_done` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
);
");

