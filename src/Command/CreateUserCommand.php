<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    private $passwordEncoder;
    private $entityManager;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        
        parent::__construct();
    }
    
    protected function configure()
    {
        $this
            ->setDescription('Create user with one command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $io->writeln('User Creator');
        $io->writeln('------------');
        
        $results = $this->askQuestions($input, $output);
        
        $user = new User();
        $user->setEmail($results['email']);
        $user->setUsername($results['username']);
        $user->setRegisterIp('::1');
        $user->setPassword($this->passwordEncoder->encodePassword($user, $results['password']));
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        $io->writeln('Successfully created user');
        
        return 0;
    }
    
    private function askQuestions(InputInterface $input, OutputInterface $output): array 
    {
        $usernameQuestion = new Question('Please enter the username', 'admin');
        $passwordQuestion = new Question('Please enter the password');
        $passwordQuestion->setHidden(true);
        $emailQuestion = new Question('Please enter the email');
        
        $helper = $this->getHelper('question');
        
        $username = $helper->ask($input, $output, $usernameQuestion);
        $password = $helper->ask($input, $output, $passwordQuestion);
        $email = $helper->ask($input, $output, $emailQuestion);
        
        return [
          'username' => $username,
          'password' => $password,
          'email' => $email
        ];
    }
}
