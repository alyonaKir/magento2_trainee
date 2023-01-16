<?php

namespace Alyona\Post\Controller\Adminhtml\Post;

use Alyona\Post\Model\PostRepository;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Action
{
    const ADMIN_RESOURCE = "Magento_Backend::content";
    private PostRepository $postRepository;

    public function __construct(
        Action\Context $context,
        PostRepository $postRepository
    )
    {
        parent::__construct($context);
        $this->postRepository = $postRepository;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            $type = $this->postRepository->get('id');
            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $resultPage->setActiveMenu('Alyona_Post::module');
            $resultPage->addBreadcrumb(__('Edit post'), __('Post'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit post: %title', ['title' => $type->getTitle()]));
        } catch (NoSuchEntityException $e){
            $resultPage = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(
                __('Post with id "%value" does not exist', ["value" => $id])
            );
            $resultPage->setPath('*/*');
        }
        return $resultPage;
    }
}
