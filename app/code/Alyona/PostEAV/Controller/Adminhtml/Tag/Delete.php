<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Tag;

class Delete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $_publicActions = ['delete'];
        if (isset($_SESSION['tag_id'])) {
            $id = $_SESSION['tag_id'];
        } else {
            $id = $this->getRequest()->getParam('id');
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                $model = $this->_objectManager->create('Alyona\PostEAV\Model\Tag');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The tag has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['tag_id' => $id]);
            }
        }
    }
}
