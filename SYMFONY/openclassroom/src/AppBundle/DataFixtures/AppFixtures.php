<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Category;
use AppBundle\Entity\Image;
use Doctrine\Common\DataFixtures\FixtureInterface;
use UserBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        /* INSÉRER DES CATÉGORIES */
       /* $categories = [
            "Développement Web",
            "Développement Mobile",
            "Graphisme",
            "Intégration",
            "Réseaux"
        ];
        foreach ($categories as $category_name){
            $category = new Category();
            $category->setName($category_name);
            $manager->persist($category);
        }*/
        /* INSÉRER DES IMAGES */
   /*     $url = "https://via.placeholder.com/150/0000FF/808080";
        $images_alt = [
            "job de reve",
            "poste de vos attentes",
            "post",
        ];
        foreach ($images_alt as $alt){
            $image = new Image();
            $image->setUrl($url);
            $image->setAlt($alt);
            $manager->persist($image);
        }*/

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->encoder->encodePassword($user,'admin'));
        $manager->persist($user);
        $manager->flush();
    }

}