<?php

namespace App\Controller;

use App\Form\PostForm;
use App\Entity\Post;
use App\Service\ExportPost;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    /**
     * Создание и сохранение поста
     * @Route("/post/create", name="create_post")
     * @param Request $request
     * @return Response
     */
    public function CreatePost(Request $request)
    {
        $post = new Post();
        $post->setName('New Post');
        $post->setDescription('Something');
        $post->setPublishedAt(new \DateTime());

        $PostForm = $this->createForm(PostForm::class, $post);

        $PostForm->handleRequest($request);
        if ($PostForm->isSubmitted() && $PostForm->isValid()) {
            $file = 0;
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('show_post', [
                'post' => $post->getId(),
                'file' => $file,
            ]);
        }

        return $this->render('post/create.html.twig', [
            'PostForm' => $PostForm->createView(),
        ]);
    }

    /**
     * Редактирование поста
     * @Route("/post/edit/{post}", name="edit_post")
     * @param Request $request
     * @param Post    $post
     * @return Response
     */
    public function EditPost(Request $request, Post $post)
    {
        $file = 0;
        //==========
        $em = $this->getDoctrine()->getManager();
        //$post = $em->getRepository(Post::class)->find($postId);
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
        if ($PostForm->isSubmitted() && $PostForm->isValid()) {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('show_post', [
                'post' => $post->getId(),
                'file' => $file,
            ]);
        }

        return $this->render('post/edit.html.twig', [
            'PostForm' => $PostForm->createView(),
           // 'postId' => $post->getId(),
            'post' => $post,
        ]);
    }

    /**
     * @Route("/post/delete/{post}", name="delete_post")
     * @param  MailerInterface        $mailer
     * @param  Request                $request
     * @param  Post                   $post
     * @param  EntityManagerInterface $em
     * @return Response
     */
    public function DeletePost(MailerInterface $mailer, Request $request, Post $post, EntityManagerInterface $em)
    {
        $email = new Email();

        $email->from('kovalecdenis2005@gmail.com');
        $email->to('kovalecdenis2005@gmail.com');

        $email->subject('Hello from Symfony');
        $email->text('Привет, пост №' . $post->getId() . ' был удален!');

        $email->html(
            $this->renderView('email/delete.html.twig', [
                'post' => $post,
            ])
        );

        $mailer->send($email);

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('homepage');

    }

    /**
     * @Route("/post/show/{post}/{file}", name="show_post")
     * @param  Request $request
     * @param  Post    $post
     * @param  string  $file
     * @return Response
     */
    public function ShowPost(Request $request, Post $post, $file)
    {
            return $this->render('post/show.html.twig', [
                'post' => $post,
                'file' => $file,
            ]);
    }

    /**
     * @Route("/post/csv/{post}", name="export_csv_post")
     * @param  ExportPost $exportPost
     * @param  Post       $post
     * @return Response
     */
    public function exportCsv(ExportPost $exportPost, Post $post)
    {
        $file = $exportPost->Csv($post);

        // $file = $exportPost->show_path . $file;
        //$file = str_replace('\\', '~', $file);
        $file = str_replace('.', '%', $file);

        return $this->redirectToRoute('show_post', [
            'post' => $post->getId(),
            'file' => $file,
        ]);
    }

    /**
     * @Route("/post/html/{post}", name="export_html_post")
     * @param  ExportPost $exportPost
     * @param  Post       $post
     * @return Response
     */
    public function exportHtml(ExportPost $exportPost, Post $post)
    {
        $file = $exportPost->Html($post);
        $file = str_replace('.', '%', $file);

        return $this->redirectToRoute('show_post', [
            'post' => $post->getId(),
            'file' => $file,
        ]);
    }
}
