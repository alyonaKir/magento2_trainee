<?php

namespace Alyona\PostEAV\Controller;

class CustomRouter implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;
    protected $_response;
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
    }
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        if(strpos($identifier, 'post') !== false) {
            $request->setModuleName('posteav')-> //module name
            setControllerName('index')-> //controller name
            setActionName('index')-> //action name
            setParam('param', 3); //custom parameters
        } else {
            return false;
        }
        return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );
    }
}
