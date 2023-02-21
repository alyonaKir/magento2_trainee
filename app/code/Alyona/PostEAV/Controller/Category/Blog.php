<?php

namespace Alyona\PostEAV\Controller\Category;

use Alyona\PostEAV\Model\CommentFactory;
use Alyona\PostEAV\Model\CommentRepository;
use Alyona\PostEAV\Model\PostRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Blog extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $commentRepository;
    protected $commentFactory;
    protected $postRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context           $context,
        PageFactory       $resultPageFactory,
        RequestInterface  $request,
        CommentRepository $commentRepository,
        CommentFactory    $commentFactory,
        PostRepository    $postRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->commentRepository = $commentRepository;
        $this->commentFactory = $commentFactory;
        $this->postRepository = $postRepository;
    }

    public function execute()
    {
        if (isset($_POST['Comment']) && isset($_POST['Name']) && $this->checkComment($_POST['Comment'])) {
            try {
                if ($_POST['Comment']=="") {
                    throw new NoSuchEntityException();
                }
                $postdata = [
                    'name' => $_POST['Name']=="" ? "Secret Guest" : $_POST['Name'],
                    'text' => $_POST['Comment'],
                    'post' => $this->postRepository->getByTitle($_SESSION['curr_post'])
                ];
                $comment = $this->commentFactory->create();
                $comment->setData($postdata);
                $this->commentRepository->save($comment);
                $this->messageManager->addSuccessMessage("Thanks for you comment");
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage("Can not add you comment. Please try again");
            }
            unset($_POST);
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Blog'));
        return $resultPage;
    }

    private function checkComment($text)
    {
        $comments = $this->commentRepository->get();
        foreach ($comments->getItems() as $comment) {
            if ($comment['text'] == $text) {
                return false;
            }
        }
        return true;
    }
}
