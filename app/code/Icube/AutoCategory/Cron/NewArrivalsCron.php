<?php
namespace Icube\AutoCategory\Cron;
 
class NewArrivalsCron
{
    protected $_logger;
 
    public function __construct(\Psr\Log\LoggerInterface $logger) {
        $this->_logger = $logger;
    }

    public function execute()
    {
        $this->_logger->info(__METHOD__);
        return $this;
    }
}