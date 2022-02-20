<?php

namespace App\DataFixtures;

use App\Entity\Ad;


use Faker\Factory;
use App\Entity\Role;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('FR-fr');
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        
        $adminUser = new User();
        $adminUser->setNom('Fayssel')
                  ->setPrenom('bellakhel')
                  ->setTel('21015887')
                  ->setEmail('cha@gmail.com')
                  ->setGenre('male')
                  ->setPicture('http://placehold.it/64x64')
                  ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                  
                  ->addUserRole($adminRole);
                  $manager->persist($adminUser);

// Nous gérons les utilisateurs
        $users = [];
       
        for($i =1; $i<= 5;$i++){
            $user = new User();
            

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            

            $hash = $this->encoder->encodePassword($user, 'password');
            $user->setNom($faker->sentence())
                 ->setPrenom($faker->sentence())
                 ->setTel('21015887')
                 ->setEmail('hamdi_nadhir@yahoo.fr')
                 ->setHash($hash)
                 ->setPicture($picture)
                 ->setGenre('dkr');
                
                 $manager->persist($user);
                 $users[] = $user;
        }


// Nous gérons les annonces
        for($i =1; $i<= 10;$i++){
        $ad = new Ad;
        $type = $faker->sentence();
        $lieu = $faker->sentence();
        $cite = $faker->paragraph(2);
        $content = $faker->paragraph(2);
        $solution = $faker->paragraph(2);
        $x = $faker->sentence();
        
        

        $user = $users[mt_rand(0, count($users) - 1)];

        $ad->setType($type)
            ->setLieu($lieu)
            ->setCite($cite)
            ->setContent($content)
            ->setSolution($solution)
            
            ->setAuthor($user)
            ->setImageName($x)
            ;
            
         
        $manager->persist($ad);
    }

        $manager->flush();
    }
}
