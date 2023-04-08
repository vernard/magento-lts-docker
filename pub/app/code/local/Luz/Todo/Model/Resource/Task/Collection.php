<?php

class Luz_Todo_Model_Resource_Task_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('luz_todo/task');
    }
}