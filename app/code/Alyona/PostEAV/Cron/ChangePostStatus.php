<?php

namespace Alyona\PostEAV\Cron;

use Alyona\PostEAV\Model\PostRepository;
use Alyona\PostEAV\Model\PostFactory;
use Psr\Log\LoggerInterface;

class ChangePostStatus
{

    /**
     * @var PostRepository
     */
    private $postRepository;
    protected $logger;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(
        PostRepository $postRepository,
        LoggerInterface $logger
    )
    {
        $this->logger = $logger;
        $this->postRepository = $postRepository;
    }

    public function execute()
    {
        $posts = $this->postRepository->get();
        $date = date("Y-m-d", time());

        foreach ($posts->getItems() as $post){
            if($post->getStatus()==2 && $post->getPublishDate()==$date){
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $objectManager = $objectManager->create('Alyona\PostEAV\Model\Post');
                $objectManager->load($post->getId());
                $objectManager->setStatus(1);
                $objectManager->save();
            }

        }

    }
}
