<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Server;

class FakeDataCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-fake-data';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
        ->setDescription('Insert data in db')
        ->setHelp('This command allows you to create all data');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        if (empty($this->entityManager->getRepository(User::class)->findByEmail('admin@admin.com'))) {
            $user = new User();
            $user->setEmail('admin@admin.com');
            $user->setPassword('$2y$13$YZr9p1qAsUtpAR/XNrQGCu4BFkZQhRFx2qX1wNHP8B5o4pPQYMimK');
            $user->setApiToken('hRFx2qX1wNHP8B5o');

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        for ($i = 1; $i <= 3; $i++) {
            $server = new Server();
            $server->setName('Server '.$i);
            $server->setActive(true);
            $server->setCustomData('custom_data');

            $this->entityManager->persist($server);
        }

        $this->entityManager->flush();

        $output->writeln([
            '============',
            'user and server created.',
            '============',
        ]);

        return Command::SUCCESS;
    }
}
