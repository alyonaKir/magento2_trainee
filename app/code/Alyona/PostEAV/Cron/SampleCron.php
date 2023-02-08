<?php

namespace Alyona\PostEAV\Cron;
use Magento\Cron\Model\Schedule;
use Magento\Framework\Serialize\SerializerInterface;
class SampleCron
{
    protected SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    public function execute(Schedule $schedule)
    {
        $arguments = [];
        if ($schedule->getArguments()) {
            $arguments = $this->serializer->unserialize($schedule->getArguments());
        }

        // your custom logic here
    }
}
