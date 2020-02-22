<?php
namespace App\EventDispatcher;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;
use Doctrine\ORM\EntityManagerInterface;

class SecurityEventsSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $entityManager;
    
    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            SwitchUserEvent::class => 'onSwitchUserEvent',
        ]; 
    }
    
    public function onSwitchUserEvent(SwitchUserEvent $event): void
    {
        if ($event->getTargetUser() instanceof User) {
            //TODO: Refactor
            $user = $this->entityManager->getRepository(User::class)->findBy(['username' => $event->getTargetUser()->getUsername()]);
            
            if (!$user) {
                return;
            }
            
            $email = new Email();
            $email
                ->from("noreply@foundee.org")
                ->to($user->getEmail())
                ->subject("New login to your account at Foundee")
                ->text("We've noticed new login to your account at Foundee at " + \date("Y-m-d H:i:s"))
            ;
            
           $this->mailer->send($email);
        }
    }

}
