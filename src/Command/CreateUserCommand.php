<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'create a new user',
)]
class CreateUserCommand extends Command
{

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $userRepository
    )
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'user email')
            ->addArgument('password', InputArgument::REQUIRED, 'user password')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $user = new User();
        $user->setEmail($email);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $password
            )
        );
        $this->userRepository->add($user, true);




        $io->success(sprintf('ユーザーアカウント(%s)が作成されました', $email));

        return Command::SUCCESS;
    }
}
