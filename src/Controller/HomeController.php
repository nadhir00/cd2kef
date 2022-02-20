<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $users = $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
      $ads = $manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')->getSingleScalarResult();
      $reponse = $manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a WHERE (a.reponse IS Not NULL)')->getSingleScalarResult();
      
      $homme =$manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u Where (u.genre = :genre)');
      $homme->setParameter('genre', 'ذكر  ');
      $rojla = $homme->getSingleScalarResult();
      $femme =$manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u Where (u.genre = :genre)');
      $femme->setParameter('genre', 'أنثى  ');
      $ontha = $homme->getSingleScalarResult();
   
     
      //   dump($users);
 
        return $this->render('home/index.html.twig', [
           'stats' =>compact('users','ads','reponse','rojla','ontha')
        ]);
       
    }
}
