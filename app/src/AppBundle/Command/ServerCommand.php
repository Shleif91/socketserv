<?php

namespace AppBundle\Command;

use AppBundle\Server\Notification;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerCommand extends ContainerAwareCommand
{
    /**
     * Configure a new Command Line
     */
    protected function configure()
    {
        $this
            ->setName('Project:notification:server')
            ->setDescription('Start the notification server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory(new HttpServer(
            new WsServer(
                new Notification($this->getContainer())
            )
        ), 8080);
        $output->writeln('run...');

        $server->run();
    }

}