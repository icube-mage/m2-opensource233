<?php

namespace Icube\AutoCategory\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;


class NewArrivalsCommandEnable extends command{
      /**
     *  @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    protected $configWriter;

    /**
     *
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
     */
    public function __construct(
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
        )
    {
        parent::__construct();
        $this->configWriter = $configWriter;
    }

    /**
     * @inheritdoc
     */
     protected function configure(){
         $this->setName('new-arrivals:enable');
         $this->setDescription('This command for enable auto "New Arrivals"');

         parent::configure();
     }

     /**
      * @inheritdoc
      */
     protected function execute(InputInterface $input, OutputInterface $output){
         $this->configWriter->save('auto_category/general/enable',  $value=1, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
         $output->writeln("Auto new arrivals has been enable");
     }
}