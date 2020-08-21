<?php

namespace Icube\AutoCategory\Cron;

class Testing {

 public function execute() {

  $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/autocategory_cron.log');
  $logger = new \Zend\Log\Logger();
  $logger->addWriter($writer);
  $logger->info(__METHOD__);

  return $this;
 }

}
