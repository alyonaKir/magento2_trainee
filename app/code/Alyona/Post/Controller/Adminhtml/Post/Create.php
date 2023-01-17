<?php

namespace Alyona\Post\Controller\Adminhtml\Post;


use Alyona\Post\Model\PostRepository;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Create extends Action
{

    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Backend::content';
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
        $resultPage->setActiveMenu('Alyona_Post::module');
        $resultPage->addBreadcrumb(__('New Post'), __('Post'));
        $resultPage->getConfig()->getTitle()->prepend(__('New Post'));
        return $resultPage;
    }
}
