<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Message;
use App\Form\CategoryType;
use App\Form\MessageType;
use App\Repository\CategoryRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepo): Response
    {
		$categories = $categoryRepo->findAll();
		
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }
	
	#[Route('/category/{id}', name: 'app_category_show', requirements: ['id' => '\d+'])]
	public function showMessages(
		MessageRepository $messageRepo,
		CategoryRepository $categoryRepo,
		int $id
	): Response {
		$category = $categoryRepo->find($id);
		$messages = $messageRepo->findBy(['category' => $id], ['createdAt' => 'DESC']);
		
		return $this->render('category/messages.html.twig', [
			'messages' => $messages,
			'category' => $category
		]);
	}
	
	#[Route('/category/new', name: 'app_category_new', methods: ['GET', 'POST'])]
	public function newCategory(
		Request $request,
		EntityManagerInterface $em,
	): Response {
		$category = new Category();
		$form = $this->createForm(CategoryType::class, $category)->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$lastCategory = $em->getRepository(Category::class)->findOneBy([], ['position' => 'DESC']);
			$category->setPosition($lastCategory->getPosition() + 1);
			$category->setColor(str_replace('#', '', $category->getColor()));
			$em->persist($category);
			$em->flush();
			
			return $this->redirectToRoute('app_category');
		}
		
		return $this->render('message/form.html.twig', [
			'form' => $form->createView()
		]);
	}
	
	#[Route('/category/{id}/new', name: 'app_category_msg_new', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
	public function new(
		Request $request,
		EntityManagerInterface $em,
		int $id
	): Response
	{
		$message = new Message();
		$form = $this->createForm(MessageType::class, $message)->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$category = $em->getRepository(Category::class)->find($id);
			$message->setAuthor($this->getUser());
			$message->setCreatedAt(new \DateTime());
			$message->setCategory($category);
			$em->persist($message);
			$em->flush();
			
			return $this->redirectToRoute('app_category_show', ['id' => $message->getCategory()->getId()]);
		}
		
		return $this->render('message/form.html.twig', [
			'form' => $form->createView()
		]);
	}
	
	#[Route('/category/{id}/remove', name: 'app_category_remove', requirements: ['id' => '\d+'], methods: ['GET'])]
	public function remove(
		EntityManagerInterface $em,
		int $id
	): Response
	{
		$category = $em->getRepository(Category::class)->find($id);
		$em->remove($category);
		$em->flush();
		
		return $this->redirectToRoute('app_category');
	}
}
