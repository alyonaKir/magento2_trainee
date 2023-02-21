<?php
declare(strict_types=1);

namespace Alyona\PostEAV\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;

class CustomRouter implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private $actionFactory;
    /**
     * @var ResponseInterface
     */
    private $response;
    /**
     * Router constructor.
     *
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
    }
    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $identifier = trim($request->getPathInfo(), '/');
        if (strpos($identifier, 'blog') !== false) {
            $request->setModuleName('blog');
            $request->setControllerName('category');
            $request->setActionName('blog');
//            $request->setParams([
//                'post' => 'post_value',
//                'post_title' => 'url_key'
//            ]);
            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }
        return null;
    }
}
