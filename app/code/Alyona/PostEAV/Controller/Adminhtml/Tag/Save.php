<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Tag;

use Alyona\PostEAV\Model\Tag;
use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;
    protected $resultRedirectFactory;
    protected $jsonHelper;
    protected $date;
    protected $urlBuider;
    protected $_publicActions;
    protected $tagFactory;
    protected $tagRepository;
    public function __construct(
        Context $context,
        Tag $moduleFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Backend\Model\UrlInterface $urlBuilder,
        \Alyona\PostEAV\Model\TagFactory $tagFactory,
        \Alyona\PostEAV\Model\TagRepository $tagRepository
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->date = $date;
        $this->_moduleFactory = $moduleFactory;
        $this->urlBuilder = $urlBuilder;
        $this->tagFactory = $tagFactory;
        $this->tagRepository = $tagRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $_publicActions = ['save'];
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $id ="";
        try {
            if (isset($_SESSION['tag_id']) && $_SESSION['tag_id']!=null) {
                $id = $_SESSION['tag_id'];
            }
            $date = $this->date->gmtDate();
            $tag = $this->tagFactory->create();

            if ($id) {
                $postdata = [
                    'name' => $data['tag_fieldset']['name'],
                ];
                $tag->setData($postdata)->setId($id);
                if ($this->checkTag($tag->getName())) {
                    $this->tagRepository->save($tag);
                } else {
                    throw new \Exception();
                }
            } else {
                $postdata = [
                    'name' => $data['tag_fieldset']['name'],
                ];
                $tag->setData($postdata);
                if ($this->checkTag($tag->getName())) {
                    $this->tagRepository->save($tag);
                } else {
                    throw new \Exception();
                }
                $this->messageManager->addSuccessMessage(__('The Tag has been saved.'));
            }
            $_SESSION['tag_id'] = null;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Try again.'));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Tag has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['tag_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }

    private function checkTag($name)
    {
        $tags = $this->tagRepository->get();
        foreach ($tags->getItems() as $tag) {
            if ($tag->getName() == $name) {
                return false;
            }
        }
        return true;
    }
}
