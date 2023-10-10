<?php

namespace App\Controller;
use App\Form\AuthorType;    
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    public $authors = array(


        array(
            'id' => 1, 'picture' => '/images/Victor-Hugo.jpg',
            'username' => ' Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100
        ),
        array(
            'id' => 2, 'picture' => '/images/william-shakespeare.jpg',
            'username' => ' William Shakespeare', 'email' => ' william.shakespeare@gmail.com', 'nb_books' => 200
        ),
        array(
            'id' => 3, 'picture' => '/images/Taha_Hussein.jpg',
            'username' => ' Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300
        ),
    );

    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/{n}', name: 'app_show')]
    public function showAuthor($n){
      return $this->render('author/show.html.twig',['name'=>$n]);
    }

    #[Route('/list',name: 'list')]
    public function list(){
        $authors = array(
            array('id' => 1, 'picture' => 'images/victor-hugo.jpg','username' => 'Victor Hugo', 'email' =>
                'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => 'images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
                ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => 'images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
                'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    return $this->render('author/list.html.twig',['authors'=>$authors]);
    }



    #[Route('/show/{id}',name: 'show')]
    public function auhtorDetails ($id)
    {
        $author = null;
        // Parcourez le tableau pour trouver l'auteur correspondant à l'ID
        foreach ($this->authors as $authorData) {
            if ($authorData['id'] == $id) {
                $author = $authorData;
            };
        };
        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
            'id' => $id
        ]);
    }

    #[Route('/affiche', name: 'app_affiche')]
    public function affiche (AuthorRepository $repository)
    {
         $author=$repository->findAll() ;
         return $this->render('author/affiche.html.twig',['author'=>$author]);
    }







    #[Route('/addstatic', name: 'app_addstatic')]
    public function addstatic(EntityManagerInterface $entityManager): Response
    {
        $author1= new Author();
        $author1->setUsername('test');
        $author1->setEmail('testt@gmail.com');
     
        $entityManager->persist($author1);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_affiche');
    
    }



    #[Route('/add-author', name: 'app_add_author')]
    public function addAuthor(Request $request): Response
    {
        $author = new Author();
        $form = $this->createform(AuthorType::class, $author);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager=$this ->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();
            return $this->redirectToRoute('app_affiche');
        }
    
        return $this->render('author/add_author.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/delete/{id}', name: 'app_delete_author')]
public function delete(Request $request, EntityManagerInterface $entityManager,  $author): Response
{
    // Vérifiez si le formulaire a été soumis et si la demande est une demande POST
    if ($request->isMethod('POST')) {
        // Supprimez l'auteur de la base de données
        $entityManager->remove($author);
        $entityManager->flush();

        // Redirigez l'utilisateur vers la liste des auteurs ou une autre page appropriée
        return $this->redirectToRoute('app_affiche');
    }

    // Affichez un formulaire de confirmation de suppression
    return $this->render('author3/delete.html.twig', [
        'author' => $author,
    ]);

}







#[Route('/edit/{id}', name: 'app_edit_author')]
public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
{
    $author = $entityManager->getRepository(Author3::class)->find($id);

    if (!$author) {
        throw $this->createNotFoundException('Auteur non trouvé');
    }

    $form = $this->createForm(AuthorType::class, $author);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Enregistrez les modifications de l'auteur en base de données
        $entityManager->flush();

        // Redirigez l'utilisateur vers la liste des auteurs ou une autre page appropriée
        return $this->redirectToRoute('app_affiche');
    }

    return $this->render('author3/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}
}





