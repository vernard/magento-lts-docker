<?php

class Luz_Todo_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction() {
        if (! $this->getRequest()->isPost()) {
            return $this->_redirect('*/*/index');
        }

        $task_name = $this->getRequest()->getParam('task_name');

        $taskModel = Mage::getModel('luz_todo/task');
        $taskModel->setName($task_name);
        $taskModel->save();

        $this->_redirectReferer();
    }
}