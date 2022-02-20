<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ad_index")
     */
    public function index(AdRepository $repo)
    {   
       
        $ads = $repo->findAll();
        
        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }
   
    /**
     * permet créer une chkeya
     * 
     * @Route("/ads/new",name="ads_create")
     * @IsGranted("ROLE_USER")
     * 
     */
    public function create(Request $request){
        
        $ad = new Ad();
        
       

        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
           $ad->setAuthor($this->getUser());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ad);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "التشكي رقم <strong>{$ad->getId()}</strong> اضيف بنجاح "
            );

            return $this->redirectToRoute('ads_show',[
                'id' => $ad->getId()
            ]);
        }

        
                    
        
        return $this->render('ad/new.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * permet d'afficher chkeya
     * 
     * @Route("/ads/{id}",name="ads_show")
     * 
     */
    public function show($id, Ad $ad){
        // je recupére l a chkeya bil id
        //$ad = $repo->findOneById($id);
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);

    }
}
