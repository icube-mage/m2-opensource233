<?php
namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Icube\AutoCategory\Helper\Data;

class Sayhello extends Command
{
	protected $helper;
	const NAME = 'name';
	
	public function __construct(
	    Data $helper
	){
		$this->helper = $helper;
		parent::__construct();
	}
	
   protected function configure()
   {
   		$option = 
   		[
   			new InputOption(
   				self::NAME,
   				null,
   				InputOption::VALUE_REQUIRED,
   				'Name'
   			)
   		];
       $this->setName('final:sayhello');
       $this->setDescription('Training command line');
       $this->setDefinition($option);
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
   		if($name = $input->getOption(self::NAME))
   		{
   			$output->writeln("Hello ~ : " . $name);
   		}else
   		{
   			$output->writeln($this->helper->getHello());
   		}
       
   }
}