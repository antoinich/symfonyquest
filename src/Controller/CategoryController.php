<?php


namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class CategoryController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/category", name="blog_index")
     * @return Response A response instance
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'The category has been edited');
        }

        return $this->render(
            'blog/index.html.twig', [
                'Categorie' => $category,
                'form' => $form->createView(),
            ]
        );
    }



}