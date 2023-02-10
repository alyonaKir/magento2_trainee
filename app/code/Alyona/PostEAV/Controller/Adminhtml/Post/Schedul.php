<?php

namespace Alyona\PostEAV\Controller\Adminhtml\Post;
use Magento\Cron\Model\Schedule;

class Schedul extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $this->cron();
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Alyona_Post::module');
        $resultPage->getConfig()->getTitle()->prepend((__('Schedule')));
        return $resultPage;
    }

    private function cron()
    {
        $cronHelper = \Magento\Framework\App\ObjectManager::getInstance()->get(\Alyona\PostEAV\Cron\Helper\Cron::class);

        // create task and schedule right now
        $cronHelper->create('custom_cronjob', null, ['key' => 'value']);

        // search tasks by parameters
        $tasks = $cronHelper->search([
            'job_code' => 'custom_cronjob',
        ]);

        foreach ($tasks as $task) {
            if ($task->getStatus() === Schedule::STATUS_SUCCESS) {
                // delete task
                $cronHelper->delete($task);
            }
        }
    }
}
