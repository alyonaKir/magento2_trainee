<?php

namespace Alyona\PostEAV\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

class Router implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;

    protected $_response;

    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
    }

    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $id = '';
        if (strpos($identifier, 'post') !== false) {
            $finalKey = explode('/', $identifier);
            $urlKey = end($finalKey);

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $postModel = $objectManager->get('Alyona\PostEAV\Model\Post')->load($urlKey, 'url_key');
            if ($postModel->getId()) {
                $id = $postModel->getId();
            }

            if ($id) {
                $request->setModuleName('blog')-> //module name
                setControllerName('post')-> //controller name
                setActionName('index')-> //action name
                setParam('id', $id); //custom parameters
            }
        } else {
            return false;
        }

        return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );
    }
}
