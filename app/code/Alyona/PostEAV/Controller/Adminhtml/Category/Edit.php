<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Category;

use Magento\Backend\App\Action\Context;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;
    protected $_publicActions = ['edit'];

    public function __construct(Context $context, \Magento\Framework\Registry $coreRegistry)
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    public function execute()
    {
        $_publicActions = ['edit'];
        $FromModel = $this->_objectManager->create('Alyona\PostEAV\Model\Category');
        $FormId = $this->getRequest()->getParam('id');
        if ($FormId) {
            $FromModel->load($FormId);
        }

        $this->_coreRegistry->register('alyona_posteav_category', $FromModel);
        $this->_view->loadLayout();
        $this->_setActiveMenu('Alyona_PostEAV::module');

        if ($FromModel) {
            $breadcrumbTitle = __('Edit Category');
            $breadcrumbLabel = __('Edit Category');
        } else {
            $breadcrumbTitle = __('New Category');
            $breadcrumbLabel = __('New Category');
        }
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Category'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend($FromModel->getId() ? __('Edit Category') : __('New Category'));
//        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Edit Form'));
        $this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);

        // restore data
        $values = $this->_getSession()->getData('alyona_posteav_category', true);
        if ($values) {
            $FromModel->addData($values);
        }

        $this->_session->start();
        $_SESSION['category_id']= $FormId;
        $this->_view->renderLayout();
    }
}
