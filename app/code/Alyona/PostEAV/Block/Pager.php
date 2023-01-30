<?php

namespace Alyona\PostEAV\Block;
use Magento\Framework\View\Element\Template;

class Pager extends Template
{
    protected $customFactory;
    protected $customdataCollection;

    public function __construct(
        Template\Context $context,
        \Alyona\PostEAV\Model\PostFactory $customFactory, // Add your custom Model
        \Alyona\PostEAV\Model\ResourceModel\Post\Grid\CollectionFactory $customdataCollection, // Add your custom Model
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customFactory = $customFactory;
        $this->customdataCollection = $customdataCollection;
    }
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('My Custom Pagination'));
        parent::_prepareLayout();
        $page_size = $this->getPagerCount();
        $page_data = $this->getCustomData();
        if ($this->getCustomData()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'custom.pager.name'
            )
                ->setAvailableLimit($page_size)
                ->setShowPerPage(true)
                ->setCollection($page_data);
            $this->setChild('pager', $pager);
            $this->getCustomData()->load();
        }
        return $this;
    }
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getCustomData()
    {
        // get param values
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5; // set minimum records
        // get custom collection
        $collection = $this->customFactory->create()->getData();
//        $collection->setPageSize($pageSize);
//        $collection->setCurPage($page);
        return $collection;
    }

    public function getPagerCount()
    {
        // get collection
        $minimum_show = 5; // set minimum records
        $page_array = [];
        $list_data = $this->customdataCollection->create();
        $list_count = ceil(count($list_data->getData()));
        $show_count = $minimum_show + 1;
        if (count($list_data->getData()) >= $show_count) {
            $list_count = $list_count / $minimum_show;
            $page_nu = $total = $minimum_show;
            $page_array[$minimum_show] = $minimum_show;
            for ($x = 0; $x <= $list_count; $x++) {
                $total = $total + $page_nu;
                $page_array[$total] = $total;
            }
        } else {
            $page_array[$minimum_show] = $minimum_show;
            $minimum_show = $minimum_show + $minimum_show;
            $page_array[$minimum_show] = $minimum_show;
        }
        return $page_array;
    }
}
