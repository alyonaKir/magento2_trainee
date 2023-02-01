<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Tag;

use Alyona\PostEAV\Model\Tag;
use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;
    protected $resultRedirectFactory;
    protected $jsonHelper;
    protected $date;
    protected $urlBuider;
    protected $_publicActions;

    public function __construct(
        Context $context,
        Tag $moduleFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Backend\Model\UrlInterface $urlBuilder
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->date = $date;
        $this->_moduleFactory = $moduleFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context);
    }

    public function execute()
    {
        $_publicActions = ['save'];
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $id ="";
        try {
            if (isset($_SESSION['tag_id']) && $_SESSION['tag_id']!=null) {
                $id = $_SESSION['tag_id'];
            }
            $date = $this->date->gmtDate();
            $objectManager = $this->_objectManager->create('Alyona\PostEAV\Model\Tag');
            if ($id) {
                $postdata = [
                    'name' => $data['tag_fieldset']['name'],
                ];
                $objectManager->setData($postdata)->setId($id);
                $objectManager->save();
            } else {
                $postdata = [
                    'name' => $data['tag_fieldset']['name'],
                ];
                $objectManager->setData($postdata);
                $objectManager->save();
                $this->messageManager->addSuccessMessage(__('The Tag has been saved.'));
            }
            $_SESSION['tag_id'] = null;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Tag has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['tag_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
