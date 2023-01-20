<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Post;

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
        $FromModel = $this->_objectManager->create('Alyona\PostEAV\Model\Post');
        $FormId = $this->getRequest()->getParam('id');
        if ($FormId) {
            $FromModel->load($FormId);
        }

        $this->_coreRegistry->register('alyona_posteav', $FromModel);
        $this->_view->loadLayout();
        $this->_setActiveMenu('Alyona_PostEAV::module');

        if ($FromModel) {
            $breadcrumbTitle = __('Edit Form');
            $breadcrumbLabel = __('Edit Form');
        } else {
            $breadcrumbTitle = __('New Form');
            $breadcrumbLabel = __('New Form');
        }
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Post'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend($FromModel->getId() ? __('Edit Form') : __('New Form'));
//        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Edit Form'));
        $this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);

        // restore data
        $values = $this->_getSession()->getData('alyona_posteav', true);
        if ($values) {
            $FromModel->addData($values);
        }

        $this->_session->start();
        $_SESSION['id']= $FormId;
        $this->_view->renderLayout();
    }
}
