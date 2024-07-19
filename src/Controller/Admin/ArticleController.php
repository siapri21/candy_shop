<?php

namespace App\Controller\Admin;

use App\Entity\Candy;
use App\Form\CandyType;
use App\Repository\CandyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/article', 'admin_article_')]
class ArticleController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    } 

    #[Route('/', name: 'index')]
    public function index():Response
    {
        $candies=$this->em->getRepository(Candy::class)->findAll();

        return $this->render('admin/article/index.html.twig',['candies' => $candies]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request ,EntityManagerInterface $em , SluggerInterface $sluggger ):Response
    {
        $candy= new Candy();
       $form=$this->createForm(CandyType::class, $candy);

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid())

       {
         // Génère le slug à partir du nom du bonbon
        $slug = $sluggger->slug($candy->getName()) -> lower();
        $candy->setSlug($slug);

        $candy->setCreateAt(new DateTimeImmutable());

        $em->persist($candy);
        $em->flush();

        $this->addFlash('success', 'Categorie ajoutée avec succès');

        return $this->redirectToRoute('admin_article_index');
        }

// $em->persist($candy); : La méthode persist prend un objet en argument (dans ce cas, $candy) et le marque comme "persistant" dans l'EntityManager. Cela signifie que l'objet est ajouté à la liste des objets à sauvegarder dans la base de données lors de la prochaine opération de flush.

// $em->persist($candy); : La méthode persist prend un objet en argument (dans ce cas, $candy) et le marque comme "persistant" dans l'EntityManager. Cela signifie que l'objet est ajouté à la liste des objets à sauvegarder dans la base de données lors de la prochaine opération de flush.
        

        // flush dit à Doctrine : "Ok, j'ai fini de préparer les objets à sauvegarder. Maintenant, écris-les dans la base de données."
       

      

        return $this->render('admin/article/create.html.twig', ['form'=> $form]);
    }

     #[Route('/update/{id}', name: 'update')]
    public function update($id, Candy $candy ,Request $request):Response
    {
        $form=$this->createForm(CandyType::class, $candy);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();

            $this->addFlash('success', 'Categorie modifiée avec succès');


            return $this->redirectToRoute('admin_article_index',[]);

        }
        // find() permet de recuperer un enregistrement de la base de données grâce à son id
        // $candy = $repository->find(1);

        //  findAll() permet de recuperer tous les enregistrement de la base de données
        // $candy = $repository->findAll();

        //  findBy() permet de recuperer tous les enregistrement de la base de données correspondant à des conditions sur les champs
        // $candy = $repository->findBy(['name' => 'fraise']);

        //  findBy() permet de recuperer un enregistrement de la base de données correspondant à des conditions sur les champs
      
        return $this->render('admin/article/update.html.twig', ['form'=>$form]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id,CandyRepository $repository,EntityManagerInterface $em):Response
    {
        $candy = $repository->find($id);
        $em ->remove($candy);
        $em->flush();
        return $this->render('admin/article/delete.html.twig');
    }
}
