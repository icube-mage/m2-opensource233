<?php

namespace Icube\AutoCategory\Cron;

use Icube\AutoCategory\Helper\Config;
use Icube\AutoCategory\Model\AssigneeManagement;
use Icube\AutoCategory\Logger\CronLogger;

class ProductsAssignee
{
    /**
     * @var AssigneeManagement
     */
    protected $assigneeManagement;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var CronLogger
     */
    protected $logger;

    /**
     * @param \Icube\AutoCategory\Model\AssigneeManagement $assigneeManagement
     * @param \Icube\AutoCategory\Helper\Config $config
     * @param \Icube\AutoCategory\Logger\CronLogger $logger
     */
    public function __construct(
        AssigneeManagement $assigneeManagement,
        Config $config,
        CronLogger $logger
    ) {
        $this->assigneeManagement = $assigneeManagement;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Execute assigneer
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->config->isEnabled() || !$this->config->isCronEnabled()) {
            return;
        }

        $this->logger->info('=== Product Assigneer START ===');

        $assigned = $this->assigneeManagement->assignNew();
        $this->logger->info('Product Assigned as New: '. count($assigned));

        $removed = $this->assigneeManagement->cleanNew();
        $this->logger->info('Product removed from New: '. count($removed));
        
        $this->logger->info('=== Product Assigneer END ==='."\n");
    }
}
