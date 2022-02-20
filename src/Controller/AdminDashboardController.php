<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;



use Doctrine\ORM\EntityManagerInterface;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(EntityManagerInterface $manager)
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
 
        return $this->render('admin/dashboard/index.html.twig', [
           'stats' =>compact('users','ads','reponse','rojla','ontha')
        ]);
    }
}
