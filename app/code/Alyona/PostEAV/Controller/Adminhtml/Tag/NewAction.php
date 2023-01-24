<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Tag;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Action
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Alyona_Post::module');
        $resultPage->addBreadcrumb(__('New Tag'), __('Tag'));
        $resultPage->getConfig()->getTitle()->prepend(__('New Tag'));
        return $resultPage;
    }
}
