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
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("test"); 

    }
}