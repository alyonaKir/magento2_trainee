<?php

namespace Alyona\Post\Ui\Component\Control\Post;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{

    public function getButtonData()
    {
        if($this->getPost()){
            return [
                'id' => 'delete',
                'label' => __('Delete'),
                'on_click' => "deleteConfirm('" .__('Are you sure you want to delete this product type?') ."', '"
                    . $this->getUrl('*/*/delete', ['id' => $this->getPost()]) . "', {data: {}})",
                'class' => 'delete',
                'sort-order' => 20,
            ];
        }
        return [];
    }
}
