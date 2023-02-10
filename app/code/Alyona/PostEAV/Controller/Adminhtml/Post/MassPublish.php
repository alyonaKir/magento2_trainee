<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Post;

use Alyona\PostEAV\Model\PostFactory;
use Alyona\PostEAV\Model\ResourceModel\Post\Grid\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassPublish extends Action
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var PostFactory
     */
    private $postFactory;


    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context              $context,
        Filter               $filter,
        CollectionFactory    $collectionFactory,
        PostFactory $postFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Execute action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     *
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());

            $myModelFactory = $this->postFactory->create();
            $done = 0;
            foreach ($collection as $myModel) {
                $myModelFactory->load($myModel->getId());
                $myModelFactory->setStatus(1);
                $myModelFactory->save();
                ++$done;
            }

            if ($done) {
                $this->messageManager->addSuccess(__('A total of %1 record(s) were modified.', $done));
            }
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alyona_PostEAV::mass_masspublish');
    }
}

