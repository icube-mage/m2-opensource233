<?php
namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class newarrival extends Command
{
    protected $helper;
	
	public function __construct(
	    \Icube\AutoCategory\Helper\Data $helper
	){
		$this->helper = $helper;
		parent::__construct();
	}
   protected function configure()
   {
       $this->setName('final:newarrival');
       $this->setDescription('Command New Arrival');
       
       parent::configure();
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
       $output->writeln("Tes Command New Arrival");
        // $this->helper->getnewArrival();
   }
}