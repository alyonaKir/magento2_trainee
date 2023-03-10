<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Post;

use Alyona\PostEAV\Block\Content;

class Index extends \Magento\Backend\App\Action
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
        $resultPage->getConfig()->getTitle()->prepend((__('Posts')));
        if(isset($_SESSION['id'])) $_SESSION['id'] = null;
        return $resultPage;
    }
}
