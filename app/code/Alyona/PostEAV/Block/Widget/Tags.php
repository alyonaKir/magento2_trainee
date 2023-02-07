<?php

namespace Alyona\PostEAV\Block\Widget;

use Alyona\PostEAV\Model\TagRepository;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
class Tags extends Template implements BlockInterface
{
    protected $tagRepository;
    protected $_template = "widget/tags.phtml";

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Alyona\PostEAV\Model\TagRepository $tagRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Alyona\PostEAV\Model\TagRepository             $tagRepository,
        array                                            $data = []
    ) {
        $this->tagRepository = $tagRepository;
        parent::__construct($context, $data);
    }

    public function returnTagsAsString()
    {

        $result="";
        $tags = $this->tagRepository->get();
        foreach ($tags->getItems() as $tag){
            $result.=$tag->getName()."\t";
        }
        return trim($result);
    }
}
