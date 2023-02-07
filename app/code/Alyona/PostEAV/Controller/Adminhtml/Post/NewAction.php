<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Action
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Alyona_PostEAV::module');
        $resultPage->addBreadcrumb(__('New Post'), __('Post'));
        $resultPage->getConfig()->getTitle()->prepend(__('New Post'));
        return $resultPage;
    }
}
