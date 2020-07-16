<?php

namespace App\Controller;

use App\Entity\Espace;
use App\Form\AjoutType;
use App\Form\ModifType;
use App\Form\SuppType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EspaceController extends AbstractController
{
    /**
     * @Route("/", name="espace")
     */
    public function index()
    {

        $repository=$this->getDoctrine()->getRepository(Espace::class);

        $use App\Form\ModifType;=$repository->findAll();

        return $this->render('espace/index.html.twig', [
            "espace"=>$categories,
        ]);
    }

    /**
     * @Route ("/", name="espace")
     */
    public function Ajouter(Request $request){

        $espace = new Espace();


        //création du formulaire
        $form=$this->createForm(EspaceType::class, $espace);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // je récupère l'entity manager (connexion à la bdd)
            $em=$this->getDoctrine()->getManager();
            $em->persist($espace);
            $em->flush();

            return $this->redirectToRoute("espace");
        }

        return $this->render("espace/formulaire.html.twig",[
            "titre"=>"Ajouter une catégorie",
            "formulaire"=>$form->createView(),
        ]);
    
    }

    
    /**
     * @Route ("/", name="espace")
     */
    public function Modifier($id, Request $request){

        $repository=$this->getDoctrine()->getRepository(Espace::class);
        $espace = $repository->find($id);

        //création du formulaire
        $form=$this->createForm(EspaceType::class, $espace);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // je récupère l'entity manager (connexion à la bdd)
            $em=$this->getDoctrine()->getManager();
            $em->persist($espace);
            $em->flush();

            return $this->redirectToRoute("espace");
        }

        return $this->render("espace/formulaire.html.twig",[
            "titre"=>"Modifer une catégorie",
            "formulaire"=>$form->createView(),
        ]);
    
    }

    /**
     * @Route ("/", name="espace")
     */
    public function Supprimer($id, Request $request){

        $repository=$this->getDoctrine()->getRepository(Espace::class);
        $espace = $repository->find($id);

        $form=$this->createForm(EspaceType::class, $espace);

        $form->handleRequest($request);
        //création du formulaire

        
        if($form->isSubmitted() && $form->isValid()){
            // je récupère l'entity manager (connexion à la bdd)
            $em=$this->getDoctrine()->getManager();
            $em->remove($espace);
            $em->flush();

            return $this->redirectToRoute("espace");
        }

           
        

        return $this->render("espace/formulaire.html.twig",[
            "titre"=>"Supprimer la catégorie".$espace->getTitre(),
            "formulaire"=>$form->createView(),
        ]);
    
    }

}
