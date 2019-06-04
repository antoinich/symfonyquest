<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleSearchType;

class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/blog", name="blog_index")
     * @return Response A response instance
     */
    public function index() : Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        $form = $this->createForm(
            ArticleSearchType::class,
            null,
            ['method' => Request::METHOD_GET]
        );

        return $this->render(
            'blog/index.html.twig', [
                'articles' => $articles,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/blog/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *  @return Response A response instance
     */
    public function show(?string $slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }
    /**
     *
     * @param string $categoryName
     *
     * @Route("/category/{name}", name="show_category")
     *  @return Response A response instance
     */
    public function showByCategory(Category $category) : Response
        {
            /*$category = $this->getDoctrine()
                ->getRepository(Category::class)->find($id);
                //->findOneBy(['name'=>$categoryName]);

            /*$articles = $this->getDoctrine()
                ->getRepository((Article::class))
                ->findBy(['category'=>$category], array('id'=>'DESC'),3);*/

            return $this->render(
                'blog/category.html.twig',
                ['category'=>$category,
                'articles'=>$category->getArticles(),]
            );
        }
    /**
     * @Route("/tag/{name}", name="show_tag", methods={"GET"})
     */
    public function showByTag(Tag $tag) :Response
    {
        return $this->render(
            'blog/tag.html.twig',
            [
                'tagName' => $tag->getName(),
                'articles' => $tag->getArticles(),
            ]
        );
    }
}