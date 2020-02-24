<?php

namespace Icube\AutoCategory\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Icube\AutoCategory\Helper\Config;
use Icube\AutoCategory\Model\AssigneeManagement;

class AutoNewCategory extends Command
{
    /**
     * @var AssigneeManagement
     */
    private $_assigneeManagement;

    /**
     * @var Config
     */
    private $_config;

    /**
     * @param \Icube\AutoCategory\Model\AssigneeManagement $assigneeManagement
     * @param \Icube\AutoCategory\Helper\Config $config
     */
    public function __construct(
        AssigneeManagement $assigneeManagement,
        Config $config
    ) {
        $this->_assigneeManagement = $assigneeManagement;
        $this->_config = $config;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('autocategory:assign:new');
        $this->setDescription('Assign products to new arrivavls category.');

        $this->addOption(
            'range',
            'r',
            InputOption::VALUE_OPTIONAL,
            'Custom day(s) range product marked as new?',
            $this->_config->getDayAsNew()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->_config->isEnabled()) {
            $output->writeln('<error>Module Icube_AutoCategory is not enabled.</error>');
            return;
        }

        $days = $input->getOption('range') ? (int) $input->getOption('range') : $this->_config->getDayAsNew();
        $output->writeln('<comment>Assigning new products to New Arrivals category.</comment>');
        $output->writeln('...');

        $products = $this->_assigneeManagement->assignNew($days);
        if (count($products) === 0) {
            $output->writeln('<info>No product(s) available to assign to New Arrivals category.</info>');
        } else {
            $output->writeln('<info>Total '.count($products).' product(s) has been assigned to New Arrivals category.</info>');
        }
        $output->writeln('');

        $removedProducts = $this->_assigneeManagement->cleanNew();
        if (count($removedProducts) > 0) {
            $output->writeln('<info>Total ' . count($removedProducts) . ' product(s) has been removed from New Arrivals category.</info>');
        }
        $output->writeln('');
    }
}
