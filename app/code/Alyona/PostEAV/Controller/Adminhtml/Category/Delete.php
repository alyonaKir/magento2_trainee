<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Category;

class Delete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $_publicActions = ['delete'];
        if (isset($_SESSION['category_id'])) {
            $id = $_SESSION['category_id'];
        } else {
            $id = $this->getRequest()->getParam('id');
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                $model = $this->_objectManager->create('Alyona\PostEAV\Model\Category');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The category has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['category_id' => $id]);
            }
        }
    }
}
