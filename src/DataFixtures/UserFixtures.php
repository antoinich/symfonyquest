<?php
namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $author = new User();
        $author->setEmail('author@monsite.com');
        $author->setRoles(['ROLE_AUTHOR']);
        $this->addReference('user_1', $author);
        //$author->setPassword($this->passwordEncoder->encodePassword(
        //    $author,
        //    'the_new_password'
        //));
        $author->setPassword($this->passwordEncoder->encodePassword(
            $author,
            'authorpassword'
        ));
        $manager->persist($author);
        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));
        $manager->persist($admin);
        $manager->flush();
    }
}