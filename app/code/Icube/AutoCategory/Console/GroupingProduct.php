<?php

namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GroupingProduct extends Command {

 protected function configure() {
  $this->setName('icube:gp');
  $this->setDescription('Icube AutoCategory - Grouping New Product');
  parent::configure();
 }

 protected function execute(InputInterface $input, OutputInterface $output) {
  $output->writeln("testing data");
 }

}
