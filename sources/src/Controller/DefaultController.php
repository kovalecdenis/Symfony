<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
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

    /**
     * @Route("/create", name="default_create_post")
     * @return Response
     */
    public function CreatePost()
    {
        $post = new Post();
        $post->setName('Post - ' . rand(1, 499));
        $post->setDescription('It`s my' . rand(1, 30) . ' post');
        $post->setPublishedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return new Response('create');
    }

    /**
     * @Route("/posts", name="default_create_post")
     * @ret
     * @return Response
     */
    public function ShowPosts()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAll();

        return $this->render('default/showposts.html.twig', [
            'posts' => $posts,
        ]);
    }
}
