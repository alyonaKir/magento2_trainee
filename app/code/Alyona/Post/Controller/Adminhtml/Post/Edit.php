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
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
//        $id = $this->getRequest()->getParam('id');
//        $resultPage = $this->resultRedirectFactory->create();
////        $this->messageManager->addErrorMessage(
////                __('NewAction with id "%value" does not exist', ["value" => $id])
////            );
//        $resultPage->setPath('*/*');
//        try {
//            $post = $this->postRepository->get($id);
//            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
//            $resultPage->setActiveMenu('Alyona_Post::module');
//            $resultPage->addBreadcrumb(__('Edit post'), __('NewAction'));
//            $resultPage->getConfig()->getTitle()->prepend(__('Edit post: %title', ['title' => $post->getTitle()]));
//        } catch (NoSuchEntityException $e){
//            $resultPage = $this->resultRedirectFactory->create();
//            $this->messageManager->addErrorMessage(
//                __('NewAction with id "%value" does not exist', ["value" => $id])
//            );
//            $resultPage->setPath('*/*/*');
//        }
        return $resultPage;
    }
}
