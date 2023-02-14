<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Post;

use Alyona\PostEAV\Model\Post;
use Alyona\PostEAV\Model\PostRepository;
use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
{
    protected $request;

    protected $postRepository;
    protected $_moduleFactory;
    protected $resultRedirectFactory;
    protected $jsonHelper;
    protected $date;
    protected $urlBuider;
    protected $_publicActions;

    public function __construct(
        Context                                     $context,
        Post                                        $moduleFactory,
        \Magento\Framework\Json\Helper\Data         $jsonHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Backend\Model\UrlInterface         $urlBuilder,
        PostRepository                              $postRepository
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->date = $date;
        $this->_moduleFactory = $moduleFactory;
        $this->urlBuilder = $urlBuilder;
        $this->postRepository = $postRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $_publicActions = ['save'];
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $objectManager = $this->_objectManager->create('Alyona\PostEAV\Model\Post');
        $tags_string = '0';
        $category_string = '0';
        $id = "";
        if (isset($_SESSION['id']) && $_SESSION != null) {
            $id = $_SESSION['id'];
        }
        if (isset($data['date_fieldset']['publish_date'])) {
            $objectManager->load($id);
            $objectManager->setPublishDate($data['date_fieldset']['publish_date']);
            $objectManager->setStatus(2);
            $objectManager->save();
            $this->messageManager->addSuccessMessage(__('The Post has been scheduled.'));
            return $resultRedirect->setPath('*/*/index');
        }
        if (isset($data['post_fieldset'])) {
            if (isset($data['post_fieldset']['tags']) && is_array($data['post_fieldset']['tags'])) {
                $tags_string = implode(',', $data['post_fieldset']['tags']);
            } elseif (isset($data['post_fieldset']['tags'])) {
                $category_string = $data['post_fieldset']['tags'];
            }

            if (isset($data['post_fieldset']['category_id']) && is_array($data['post_fieldset']['category_id'])) {
                $category_string = implode(',', $data['post_fieldset']['category_id']);
            } elseif (isset($data['post_fieldset']['category_id'])) {
                $category_string = $data['post_fieldset']['category_id'];
            }

            try {
                $date = $this->date->gmtDate();
                if ($id) {
                    $postdata = [
                        'title' => $data['post_fieldset']['title'],
                        'url_key' => $this->getUrlKey($data['post_fieldset']['title']),
                        'post_content' => $data['post_fieldset']['post_content'],
                        'tags' => $tags_string,
                        'category_id' => $category_string,
                        'status' => $data['post_fieldset']['status'],
                        'updated_at' => $date
                    ];
                    $objectManager->setData($postdata)->setId($id);
                    $objectManager->save();
                } else {
                    $postdata = [
                        'title' => $data['post_fieldset']['title'],
                        'url_key' => $this->getUrlKey($data['post_fieldset']['title']),
                        'post_content' => $data['post_fieldset']['post_content'],
                        'tags' => $tags_string,
                        'category_id' => $category_string,
                        'status' => $data['post_fieldset']['status'],
                        'created_at' => $date,
                        'updated_at' => $date
                    ];
                    $objectManager->setData($postdata);
                    $objectManager->save();
                    $this->messageManager->addSuccessMessage(__('The Post has been saved.'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
                $_SESSION['id'] = null;
                return $resultRedirect->setPath('*/*/edit');
            }
            if ($this->getRequest()->getParam('back')) {
                $this->messageManager->addSuccessMessage(__('The Post has been saved.'));
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id, '_current' => true]);
            }
        }
        return $resultRedirect->setPath('*/*/index');
    }

    private function getUrlKey($title): string
    {
        $posts = $this->postRepository->get();
        $count = 0;
        foreach ($posts->getItems() as $post) {
            if ($post->getTitle() == $title) {
                $count++;
            }
        }

        if ($count == 0) {
            $urlKey = str_replace(" ", "-", strtolower($title));
        } else {
            $num = "-" . $count;
            $urlKey = str_replace(" ", "-", strtolower($title)) . $num;
        }
        return $urlKey;
    }
}
