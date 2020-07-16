<?php

namespace App\Controller;

use App\Entity\Chaton;
use App\Form\ChatonType;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Form\ChatonDeleteType;
use App\Form\CategorieDeleteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChatonController extends AbstractController
{
    /**
     * @Route("/chatons/{idCategorie}", name="chaton_voir")
     */
    public function index($idCategorie)
    {

        //Le répository
        $repo=$this->getDoctrine()->getRepository(Categorie::class);

        //Récupérer la catégorie
        $categorie=$repo->find($idCategorie);
        $chatons=$categorie->getChatons();

        return $this->render('chaton/index.html.twig', [
            "categorie"=>$categorie,
            "chatons"=>$chatons,
        ]);
    }

    /**
     * @Route("/chaton/ajouter/{idCategorie}", name="chaton_ajouter")
     */
    public function ajouter(Request $request, $idCategorie)
    {
        //Le répository
        $repo=$this->getDoctrine()->getRepository(Categorie::class);

        //Récupérer la catégorie
        $categorie=$repo->find($idCategorie);
        
        $chaton = new Chaton();
        $chaton->setCategorie($categorie);
        // $categorie -> setTitre("titre par défault")

        //création du formulaire
        $form=$this->createForm(ChatonType::class, $chaton);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $chaton=$form->getData();

            $file=$chaton->getPhoto();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            $file->move(
                'D:\EPSI-Ecole-Adrien\B2\Symfony\ChatonsBDD\public\Photo',
                $fileName
            );

            $chaton->setPhoto($fileName);

            

            $em=$this->getDoctrine()->getManager();
            $em->persist($chaton);
            $em->flush();

            //On retournera à l'index de la ctégorie dans laquelle on a ajouté le chaton
            return $this->redirectToRoute("chaton_voir", ["idCategorie"=>$idCategorie]);
        }

        return $this->render("chaton/formulaire.html.twig",[
            "titre"=>"Nouveau Chaton",
            "formulaire"=>$form->createView(),
        ]);

    }

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route ("/chaton/modifier/{id}", name="chaton_modifier")
     */
    public function Modifier($id, Request $request){

        $repository=$this->getDoctrine()->getRepository(Categorie::class);
        $chaton = $repository->find($id);

        // $categorie -> setTitre("titre par défault")

        //création du formulaire
        $form=$this->createForm(CategorieType::class, $chaton);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // je récupère l'entity manager (connexion à la bdd)

            
            $em=$this->getDoctrine()->getManager();
            $chaton=$em->getRepository('AppEntity:Chaton')->find($id);
            $form=$this->createForm(new ChatonType, $chaton);
            //$em->flush();

            if($request->getMethod() == 'POST'){

                $form->bind($request);
                if($form->isValid()){

                    $em=$this->getDoctrine()->getManager();
                    $em->flush();
                    return $this->redirectToRoute("categorie");

                }

            }

            return $this->redirectToRoute("categorie");
        }

        return $this->render("categorie/formulaire.html.twig",[
            "titre"=>"Modifier un chat",
            "formulaire"=>$form->createView(),
        ]);
    
    }

    /**
     * @Route("/chaton/supprimer/{idCategorie}/{id}", name="chaton_supprime")
     */
    public function Supprimer($id, $idCategorie, Request $request)
    {
        $repository=$this->getDoctrine()->getRepository(Chaton::class);
        $chaton=$repository->find($id);

        // Création du formulaire
        $form = $this->createForm(ChatonDeleteType::class, $chaton);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->remove($chaton);
            $em->flush();

            return $this->redirectToRoute("chatons_voir", ['idCategorie'=>$idCategorie]);
        }

        return $this->render('chaton/formulaire.html.twig', [
            'titre' => 'Supprimer le chaton '.$chaton->getNom(),
            'formulaire' => $form->createView(),
        ]);
    
    }


}
