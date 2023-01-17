<?php

namespace Alyona\Post\Controller\Adminhtml\Post;

use Alyona\Post\Api\Data\PostInterface;
use Alyona\Post\Api\PostRepositoryInterface;
use Alyona\Post\Model\PostFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action;
use Magento\Setup\Exception;


class Save extends Action implements HttpPostActionInterface
{
    private PostRepositoryInterface $postRepository;
    private PostFactory $postFactory;

    public function __construct(
        Action\Context          $context,
        PostRepositoryInterface $postRepository,
        PostFactory             $postFactory
    )
    {
        parent::__construct($context);
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $request = $this->getRequest();
        $requestData = $request->getPost()->toArray();

        if (!$request->isPost() || empty($requestData['general'])) {
            $this->messageManager->addErrorMessage(__('Wrong request. '));
            $resultRedirect->setPath('*/*/create');
            return $resultRedirect;
        }
        try {
            $id = $requestData['general'][PostInterface::ID];
            $post = $this->postRepository->get($id);
        } catch (Exception $e) {
            $post = $this->postFactory->create();
        }
        $post = $this->postFactory->create();
        $post->setId(1);
        $post->setTitle($requestData['general'][PostInterface::TITLE]);
        $post->setContent($requestData['general'][PostInterface::CONTENT]);
        $post->setUpdatedAt('09-10-2022');
        $post->setCreatedAt('09-10-2022');
        try {
            $post = $this->postRepository->save($post);
            $this->messageManager->addSuccessMessage(__('Post saved'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e));
            $resultRedirect->setPath('*/*/create');
        }

        $resultRedirect->setPath('*/*');
        return $resultRedirect;
    }

}
