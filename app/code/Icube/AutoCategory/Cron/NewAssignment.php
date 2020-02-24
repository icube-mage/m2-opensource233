<?php

namespace Icube\AutoCategory\Cron;

class NewAssignment {
    protected $helperData;    
    protected $customLogger;

    public function __construct(
        \Icube\AutoCategory\Helper\Data $helperData,
        \Icube\AutoCategory\Logger\Logger $customLogger
    ) {
        $this->helperData = $helperData;
        $this->customLogger = $customLogger;
        parent::__construct();
    }

   /**
    * Write to system.log
    *
    * @return void
    */
    public function execute() {
        $newProducts = $this->helperData->getNewAssignment();
        if ($newProducts->getSize()) {            
            $this->customLogger->info('Success assign products to New Arrival!');
        }
        elseif ($newProducts == true) {
            $this->customLogger->info('No product can be assigned!');
        }
        else {
            $this->customLogger->info('Failed. Please enable first on admin config!');
        }
    }
}