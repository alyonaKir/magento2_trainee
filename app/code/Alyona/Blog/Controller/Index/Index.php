<?php

namespace Alyona\Blog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function execute()
    {
       $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
       return $page;
    }
}
