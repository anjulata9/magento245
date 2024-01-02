<?php
 
namespace Anjulata\AddressStatus\Model;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;

class Ping extends Command
{
    protected function configure()
    {
        $this->setName('anjulata:ping')
             ->setDescription('Ping us to support!');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Need Help Contact To Anjulata.com!');
    }
}