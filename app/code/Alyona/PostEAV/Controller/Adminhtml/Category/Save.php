<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Category;

use Alyona\PostEAV\Model\Category;
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
        Category $moduleFactory,
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
        $urlKey = $data['category_fieldset']['name'];
        //$urlKey = $this->urlBuilder->getRouteUrl('posteav/post/edit', [ 'key'=>$this->urlBuilder->getSecretKey('posteav', 'post', 'edit')]);
        //$urlKey = $this->_objectManager->create('Magento\Catalog\Model\Product\Url')->formatUrlKey($data['url_key']);
        try {
            $id = $_SESSION['category_id'];
            //$id = (int)$this->getRequest()->getParam('id');
            $date = $this->date->gmtDate();
            $objectManager = $this->_objectManager->create('Alyona\PostEAV\Model\Category');
            if ($id) {
                $postdata = [
                    'name' => $data['category_fieldset']['name'],
                    'url_key' => $urlKey,
                    'status' => $data['category_fieldset']['status'],
                    'updated_at' => $date
                ];
                $objectManager->setData($postdata)->setId($id);
                $objectManager->save();
            } else {
                $postdata = [
                    'name' => $data['category_fieldset']['name'],
                    'url_key' => $urlKey,
                    'status' => $data['category_fieldset']['status'],
                    'created_at' => $date,
                    'updated_at' => $date
                ];
                $objectManager->setData($postdata);
                $objectManager->save();
                $this->messageManager->addSuccessMessage(__('The Category has been saved.'));
            }
            $_SESSION['category_id'] = null;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Category has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['category_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
