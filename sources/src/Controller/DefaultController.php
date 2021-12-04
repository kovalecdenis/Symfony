<?php
namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FeedbackForm;

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
     * @param Request         $request
     * @param MailerInterface $mailer
     * @return Response
     */
    public function Feedback(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(FeedbackForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = new Email();
            $email->from('kovalecdenis2005@gmail.com');
            $email->to('kovalecdenis2005@gmail.com');

            $name = $data['Name'];
            $contact = $data['Contact'];
            $message = $data['Description'];

            $email->subject('Feedback message');
            $email->text(
                'Name : ' . $name . "\n" .
                      'Contact : ' . $contact . "\n" .
                      'Message : ' . "\n" . $message
            );
            $email->html(
                $this->renderView('email/feedback_message.html.twig', [
                    'name' => $name,
                    'contact' => $contact,
                    'message' => $message,
                ])
            );

            $mailer->send($email);

            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/feedback.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
