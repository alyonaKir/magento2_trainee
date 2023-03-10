<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Post;

class Schedul extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Alyona_Post::module');
        $resultPage->getConfig()->getTitle()->prepend((__('Schedule')));
        $_SESSION['id']= $this->getRequest()->getParam('id');
        return $resultPage;
    }


}
