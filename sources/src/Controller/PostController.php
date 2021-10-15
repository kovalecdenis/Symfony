<?php

namespace App\Controller;


use App\Form\PostForm;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController {

    /**
     * @Route("/post/create", name="create_post")
     */
    public function CreatePost(Request $request)
    {
        $post = new Post();
        $post->setName('New Post');
        $post->setDescription('Something');
        $post->setPublishedAt(new \DateTime());

        $PostForm = $this->createForm(PostForm::class, $post);


        $PostForm->handleRequest($request);
        if($PostForm->isSubmitted() && $PostForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('show_post' , [
                'postId' => $post->getId(),
            ]);
        }

        return $this->render("post/create.html.twig", [
            'PostForm' => $PostForm->createView(),
        ]);
    }

    /**
     * @Route("/post/edit/{postId}", name="edit_post")
     */
    public function EditPost(Request $request, $postId)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($postId);
        /*
        $post = $em->getRepository(Post::class)->find($request->get('id')); http://localhost:8000/post/edit?id=1
        */ //example

        $PostForm = $this->createForm(PostForm::class, $post);

        /* одно и тоже
        if($request->query->has('id')) {
            ...
        }

        $id = $request->get('id');
      */ //example
        $PostForm->handleRequest($request);
        if($PostForm->isSubmitted() && $PostForm->isValid())
        {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('show_post', [
                'postId' => $post->getId(),
            ]);
        }

        return $this->render("post/edit.html.twig", [
            'PostForm' => $PostForm->createView(),
           // 'postId' => $post->getId(),
            'post' => $post,
        ]);
    }

    /**
     * @Route("/post/show/{postId}", name="show_post")
     */
    public function ShowPost(Request $request, $postId)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($postId);

        return $this->render("post/show.html.twig", [
            'post' => $post,
        ]);
    }
}
