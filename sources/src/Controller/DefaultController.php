<?php
namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAll();

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
        ]);

    }

    /**
     * @Route("/about", name="default_about")
     * @return Response
     */
    public function About()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/feedback", name="default_feedback")
     * @return Response
     */
    public function Feedback()
    {
        return $this->render('default/feedback.html.twig');
    }

}
