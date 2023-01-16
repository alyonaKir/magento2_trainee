<?php

namespace Alyona\Post\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

    const ADMIN_RESOURCE = "Magento_Backend::content";
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Alyona_Post::module');
        $resultPage->addBreadcrumb(__('Post'), __('List'));
        $resultPage->getConfig()->getTitle()->prepend(__('Post'));
        return $resultPage;
    }
}
