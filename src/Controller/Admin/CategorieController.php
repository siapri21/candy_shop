<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\CategorieType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin/categorie', name: 'admin_categorie_')]
class CategorieController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em): Response
    {
        $categorie = new  Categorie();
        $categorie->setName('sucette')
        ->setDescription('super')
        ->setCreateAt(new DateTimeImmutable())
        ->setUpdateAt(new DateTimeImmutable());
        $em->persist($categorie);
        $em->flush();

        return $this->render('admin/categorie/create.html.twig');
    }

    #[Route('/update/{id}', name: 'update')]
    public function update($id, Categorie $categorie, Request $request): Response
    {
        $form = $this->createForm(CategorieType::class , $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->em->flush();
            $this->redirectToRoute('admin_categorie_index');
        }
    //      $categorie;
    //     $categorie->setName('sucette')
    // ->setDescription('super')
    // ->setCreateAt(new DateTimeImmutable());
    //     $this-> em->flush();
        return $this->render('admin/categorie/update.html.twig',
    ['form' =>$form]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Categorie $categorie): Response
    {

        $this->em ->remove($categorie);
        $this->em->flush();
        return $this->render('admin/categorie/delete.html.twig');
    }
}
