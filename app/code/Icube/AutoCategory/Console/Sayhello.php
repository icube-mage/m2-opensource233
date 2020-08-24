<?php
namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Icube\AutoCategory\Helper\Data;

class Sayhello extends Command
{
	protected $helper;
	
	public function __construct(
	    Data $helper
	){
		$this->helper = $helper;
		parent::__construct();
	}
	
   protected function configure()
   {
       $this->setName('training:sayhello');
       $this->setDescription('Training command line');
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
       $output->writeln("Hello World Icube!");
   }
}