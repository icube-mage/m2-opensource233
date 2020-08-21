<?php

namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class NewDisableArrival extends command {

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
 ) {
  parent::__construct();
  $this->configWriter = $configWriter;
 }

 /**
  * @inheritdoc
  */
 protected function configure() {
  $this->setName('icube:dis_newarr');
  $this->setDescription('This command for disable auto "New Arrivals"');

  parent::configure();
 }

 /**
  * @inheritdoc
  */
 protected function execute(InputInterface $input, OutputInterface $output) {
  $this->configWriter->save(
      'autocategory/general/enable',
      $value   = 0,
      $scope   = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
      $scopeId = false);
  $output->writeln("Auto new arrivals has been disabled");
 }

}
