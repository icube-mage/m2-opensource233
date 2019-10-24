<?php
namespace Icube\AutoCategory\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Icube\AutoCategory\Helper\Data;

    /**
     * Class SomeCommand
     */
    class Config extends Command
    {

      const STATUS = 'Status';
      // const RANGE = 'Range';
      // const CRON = 'Cron';

         /**
         * Module list
         *
         * @var Data
         */
         private $data;

        /**
         * @param bookingFactory $bookingFactory
         */
        public function __construct(
          Data $data
        )
        {
          $this->data = $data;
          parent::__construct();
        }
        /**
         * @inheritDoc
         */
        protected function configure()
        {
          $commandoptions = [new InputOption(self::STATUS, null, InputOption::VALUE_REQUIRED, 'Status')];
          // $commandoptions = [new InputOption(self::RANGE, null, InputOption::VALUE_REQUIRED, 'Range')];
          // $commandoptions = [new InputOption(self::CRON, null, InputOption::VALUE_REQUIRED, 'Cron')];

          $this->setName('category:newarrivals:config');
          $this->setDescription('This is my first console command.');
          $this->setDefinition($commandoptions);
          // $this->addArgument('number', InputArgument::REQUIRED, __('Type a string'));

          parent::configure();
        }

        /**
         * @param InputInterface $input
         * @param OutputInterface $output
         *
         * @return null|int
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
          if ($status = $input->getOption(self::STATUS)) {
            if($status == "Yes"){
              $this->data->setStatus(1);
              $output->writeln('<info>Success.</info>');
            }else if($status == "No"){
              $this->data->setStatus(0);
              $output->writeln('<info>Success.</info>');
            }else{
              $output->writeln('<error>--Status=Yes/No.</error>');
            }
          }else{
            $output->writeln('<error>Input Argument.</error>');
          }
        }
      }

      ?>