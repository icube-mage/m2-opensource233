<?php 

namespace Icube\AutoCategory\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class NewAssignment extends Command {
    protected $helperData;
    protected $tableHelper;
    

    public function __construct(
        \Icube\AutoCategory\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
        parent::__construct();
    }
    /**
     * @inheritDoc
     */
    protected function configure() {
        $this->setName('icube:autocategory:newassignment');
        $this->setDescription('Icube_AutoCategory assignment for new arrival');
        parent::configure();
    }

    /**
     * Execute the command
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * 
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $newProducts = $this->helperData->getNewAssignment();
        if ($newProducts->getSize()) {            
            $output->writeln('<info>Success assign products to New Arrival!</info>');
            $output->writeln('<info>New Arrival Category ID : '.$this->helperData->getNewArrivalId().'</info>');

            $rows = array();
            foreach ($newProducts as $product) {
                    $rows[] =array($product->getId(),$product->getSku(),$product->getName());
            }

            $table = new Table($output);
            $table->setHeaders(['ID', 'SKU', 'Product Name']);
            $table->setRows($rows);
            $table->render();
        }
        elseif ($newProducts == true) {
            $output->writeln('<info>No product can be assigned!</info>');
        }
        else {
            $output->writeln('<error>Failed. Please enable first on admin config!</error>');
        }
    }



}