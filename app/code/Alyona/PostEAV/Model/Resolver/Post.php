<?php

namespace Alyona\PostEAV\Model\Resolver;

use Alyona\PostEAV\Api\PostRepositoryInterface;
use Alyona\PostEAV\Model\PostFactory;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Webapi\ServiceOutputProcessor;

class Post implements ResolverInterface
{
    /**
     * @var ValueFactory
     */
    private $valueFactory;
    /**
     * @var PostFactory
     */
    private $postFactory;
    /**
     * @var ServiceOutputProcessor
     */
    private $serviceOutputProcessor;
    /**
     * @var ExtensibleDataObjectConverter
     */
    private $dataObjectConverter;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    private PostRepositoryInterface $postRepository;

    /**
     *
     * @param ValueFactory $valueFactory
     * @param PostFactory $postFactory
     * @param ServiceOutputProcessor $serviceOutputProcessor
     * @param ExtensibleDataObjectConverter $dataObjectConverter
     */
    public function __construct(
        ValueFactory $valueFactory,
        PostFactory $postFactory,
        ServiceOutputProcessor $serviceOutputProcessor,
        ExtensibleDataObjectConverter $dataObjectConverter,
        PostRepositoryInterface $postRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->valueFactory = $valueFactory;
        $this->postFactory = $postFactory;
        $this->serviceOutputProcessor = $serviceOutputProcessor;
        $this->dataObjectConverter = $dataObjectConverter;
        $this->postRepository = $postRepository;
        $this->logger = $logger;
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) : Value {
        if ((!$context->getUserId()) || $context->getUserType() == UserContextInterface::USER_TYPE_GUEST) {
            throw new GraphQlAuthorizationException(
                __(
                    'Current post does not have access to the resource "%1"',
                    [\Alyona\PostEAV\Model\Post::ID]
                )
            );
        }
        try {
            $data = $this->getPostData($context->getUserId());
            $result = function () use ($data) {
                return !empty($data) ? $data : [];
            };
            return $this->valueFactory->create($result);
        } catch (NoSuchEntityException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        } catch (LocalizedException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        }
    }
    /**
     *
     * @param int $context
     * @return array
     * @throws NoSuchEntityException|LocalizedException
     */
    private function getPostData($postId) : array
    {
        try {
            $postData = [];
            $postColl = $this->postFactory->create()->getCollection()
                ->addFieldToFilter("post_id", ["eq"=>$postId]);
            foreach ($postColl as $post) {
                $postData[] = $post->getData();
            }
            return $postData[0] ?? [];
        } catch (NoSuchEntityException $e) {
            return [];
        } catch (LocalizedException $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }
    }
}
