<?php

namespace Alyona\PostEAV\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function execute()
    {
        $FormId = $this->getRequest()->getParam('id');
        $_SESSION['post_id'] = $FormId;
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $page;
    }
}
