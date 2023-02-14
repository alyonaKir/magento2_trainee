<?php

namespace Alyona\PostEAV\Controller\Index;

use Alyona\PostEAV\Model\CommentRepository;
use Alyona\PostEAV\Model\CommentFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $commentRepository;
    protected $commentFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context          $context,
        PageFactory      $resultPageFactory,
        RequestInterface $request,
        CommentRepository $commentRepository,
        CommentFactory $commentFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->commentRepository = $commentRepository;
        $this->commentFactory = $commentFactory;
    }

    public function execute()
    {
        if (isset($_POST)) {
            $postdata = [
                'name' => $_POST['Name'],
                'text' => $_POST['Comment'],
            ];
            $comment = $this->commentFactory->create();
            $comment->setData($postdata);
            $this->commentRepository->save($comment);
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Blog'));
        return $resultPage;
    }
}
