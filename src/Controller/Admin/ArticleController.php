<?php

namespace App\Controller\Admin;

use App\Entity\Candy;
use App\Repository\CandyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

#[Route('/admin/article', 'admin_article_')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index():Response
    {
        return $this->render('admin/article/index.html.twig');
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em ):Response
    {
        $candy= new Candy();
        $candy->setName('bonbon au lait, Carambar')
        ->setSlog('laitier, chocolaté')
        ->setDescription('le plaisir, le meilleur bonbon')
        ->setCreateAt(new DateTimeImmutable());

// $em->persist($candy); : La méthode persist prend un objet en argument (dans ce cas, $candy) et le marque comme "persistant" dans l'EntityManager. Cela signifie que l'objet est ajouté à la liste des objets à sauvegarder dans la base de données lors de la prochaine opération de flush.

// $em->persist($candy); : La méthode persist prend un objet en argument (dans ce cas, $candy) et le marque comme "persistant" dans l'EntityManager. Cela signifie que l'objet est ajouté à la liste des objets à sauvegarder dans la base de données lors de la prochaine opération de flush.
        $em->persist($candy);

        // flush dit à Doctrine : "Ok, j'ai fini de préparer les objets à sauvegarder. Maintenant, écris-les dans la base de données."
        $em->flush();

        dd($candy);

        return $this->render('admin/article/create.html.twig');
    }

     #[Route('/update/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS])]
    public function update($id, CandyRepository $repository, EntityManagerInterface $em):Response
    {
        dd($repository);
        // find() permet de recuperer un enregistrement de la base de données grâce à son id
        // $candy = $repository->find(1);

        //  findAll() permet de recuperer tous les enregistrement de la base de données
        // $candy = $repository->findAll();

        //  findBy() permet de recuperer tous les enregistrement de la base de données correspondant à des conditions sur les champs
        // $candy = $repository->findBy(['name' => 'fraise']);

        //  findBy() permet de recuperer un enregistrement de la base de données correspondant à des conditions sur les champs
        $candy = $repository->findOneBy([
            'slug' => 'fraise',
            'name' => 'fraise'
        ]);
        $candy = $repository->find($id);
        $candy -> setName('fraise');
        $em->flush();

        return $this->render('admin/article/update.html.twig');
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
