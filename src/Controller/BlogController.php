<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{page}", requirements={"page"="\d*"}, name="blog_index")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'owner' => 'Thomas',
        ]);
    }

    /**
     * @Route("/blog/show/{slug}", requirements={"slug"="[a-z0-9-]*"}, name="blog_slug")
     */
    public function show($slug = "article sans titre")
    {
        if(strlen($slug) === 0 ) {
            $slug = "article-sans-titre";
        }
        $slug = ucwords(str_replace('-', ' ', $slug));
        return $this->render('blog/show.html.twig', [
            'slug' => $slug,
        ]);
    }
}