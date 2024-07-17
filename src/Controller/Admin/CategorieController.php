<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/categorie', name: 'admin_categorie_')]
class CategorieController extends AbstractController
{
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

    #[Route('/update{id}', name: 'update', requirements:['id' => Requirement ::DIGITS])]
    public function update($id, CategorieRepository $repository,EntityManagerInterface $em): Response
    {
        $candy = $repository->findOneBy([
            'slug' => 'fraise',
            'name' => 'fraise'
        ]);
        $categorie = $repository->find($id);
        $categorie -> setName('fraise');
        $em->flush();
        return $this->render('admin/categorie/update.html.twig');
    }

    #[Route('/delete{id}', name: 'delete')]
    public function delete($id, CategorieRepository $repository, EntityManagerInterface $em): Response
    {
        $categorie = $repository->find($id);
        $em ->remove($categorie);
        $em->flush();
        return $this->render('admin/categorie/delete.html.twig');
    }
}
