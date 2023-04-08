<?php

class Luz_Todo_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction() {
        if (! $this->getRequest()->isPost()) {
            return; // Must redirect to home page.
        }

        $task_name = $this->getRequest()->getParam('task_name');
        echo "You've entered: {$task_name}";
    }
}