<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Category;

use _PHPStan_503e82092\Nette\Neon\Exception;
use Alyona\PostEAV\Model\Category;
use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;
    protected $resultRedirectFactory;
    protected $categoryRepository;
    protected $categoryFactory;
    protected $jsonHelper;
    protected $date;
    protected $urlBuider;
    protected $_publicActions;

    public function __construct(
        Context $context,
        Category $moduleFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Backend\Model\UrlInterface $urlBuilder,
        \Alyona\PostEAV\Model\CategoryRepository $categoryRepository,
        \Alyona\PostEAV\Model\CategoryFactory $categoryFactory
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->date = $date;
        $this->categoryRepository = $categoryRepository;
        $this->_moduleFactory = $moduleFactory;
        $this->urlBuilder = $urlBuilder;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $_publicActions = ['save'];
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $id="";
        try {
            if (isset($_SESSION['category_id']) && $_SESSION['category_id']!=null) {
                $id = $_SESSION['category_id'];
            }
            $date = $this->date->gmtDate();
            $comment = $this->categoryFactory->create();
            if ($id) {
                $postdata = [
                    'name' => $data['category_fieldset']['name'],
                    'url_key' => $this->getUrlKey($data['category_fieldset']['name']),
                    'status' => $data['category_fieldset']['status'],
                    'updated_at' => $date
                ];
                $comment->setData($postdata);
                $this->categoryRepository->save($comment);
            } else {
                $postdata = [
                    'name' => $data['category_fieldset']['name'],
                    'url_key' => $this->getUrlKey($data['category_fieldset']['name']),
                    'status' => $data['category_fieldset']['status'],
                    'created_at' => $date,
                    'updated_at' => $date
                ];
                $comment->setData($postdata);
                $this->categoryRepository->save($comment);
                $this->messageManager->addSuccessMessage(__('The Category has been saved.'));
            }
            $_SESSION['category_id'] = null;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Category has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['category_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }

    private function getUrlKey($name):string
    {
        $categories = $this->categoryRepository->get();
        $count = 0;
        foreach ($categories->getItems() as $category) {
            if (strtolower($category->getName()) == strtolower($name)) {
                $count++;
            }
        }

        if ($count==0) {
            $urlKey = str_replace(" ", "-", strtolower($name));
        } else {
            throw new \Exception("This category already exist.");
        }
        return $urlKey;
    }
}
