<?php

namespace App\EventSubscriber;

use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class MessagePostedEventSubscriber
{
	private MailerInterface $mailer;
	
	public function __construct(MailerInterface $mailer)
	{
		$this->mailer = $mailer;
	}
	
	/**
	 * @throws TransportExceptionInterface
	 */
	public function onFlush(PostUpdateEventArgs $args): void
	{
		$entity = $args->getObject();
		$em = $args->getObjectManager();

		if ($entity instanceof Message) {
			$users = $em->getRepository(User::class)->findAll();
			foreach ($users as $user) {
				$email = (new Email())
					->from('nelly@localhost.com')
					->to($user->getEmail())
					->subject('Nouveau message')
					->html('<p>Un nouveau message a été posté sur le forum par ' . $entity->getAuthor()->getName() .
					'</p>');
				$this->mailer->send($email);
			}
		}
	}
}