<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use App\Repository\TagsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
		TagsRepository $tagsRepo,
	    MessageRepository $messageRepo
    ): Response {
		$tags = $tagsRepo->findAll();
		$messages = $messageRepo->findBy([], ['createdAt' => 'DESC'], 3);
		
        return $this->render('home/index.html.twig', [
			'tags' => $tags,
	        'messages' => $messages
        ]);
    }
}
