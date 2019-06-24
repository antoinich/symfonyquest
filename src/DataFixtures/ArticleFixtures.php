<?php


namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Service\Slugify;



class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++){
            $article = new Article();
            $faker  =  Faker\Factory::create('fr_FR');
            $article->setTitle(mb_strtolower($faker->sentence()));
            $article->setContent(mb_strtolower($faker->sentence()));
            $slugify = new Slugify();
            $article->setSlug($slugify->generate($article->getTitle()));
            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_'. rand(0,4)));
            $random = rand(0, 4);
            for ($j = 0; $j<$random; $j++) {
                $article->addTag($this->getReference('tag_' . rand(0, 5)));
            }
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }

}