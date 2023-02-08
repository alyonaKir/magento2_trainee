<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Post;

class Publish extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $_publicActions = ['delete'];
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
        } else {
            $id = $this->getRequest()->getParam('id');
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                $model = $this->_objectManager->create('Alyona\PostEAV\Model\Post');
                $model->load($id);
                $model->setStatus(1);
                $model->save();
                $this->messageManager->addSuccess(__('The post has been published.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            }
        }
    }
}
