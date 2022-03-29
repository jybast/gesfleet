<?php

namespace App\Controller;

use App\Form\ContactType;

use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;

class MainController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig', []);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        // set form contact
        $form = $this->createForm(ContactType::class);

        // Handle form
        $contact = $form->handleRequest($request);
        $token = $request->attributes->get('token');

        // operates with datas
        if ($form->isSubmitted() && $form->isValid()) {
            // prepare context of the mail       
            // get data
            $from = $contact->get('email')->getData();
            $subject = $contact->get('subject')->getData();
            $message = $contact->get('message')->getData();

            // prepare email
            $email = (new TemplatedEmail())
                ->from($from)
                ->to('Contact@Gesfleet.fr')
                ->subject($subject)
                ->htmlTemplate('templated_emails/email-contact.html.twig')
                ->context([
                    'subject' => $subject,
                    'message' => $message,
                    'from' => $from
                ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                // error

                $this->addFlash('error', $translator->trans('Your mail was not sent successfully'));
            }

            // confirm message send
            $this->addFlash('message', $translator->trans('Your mail was sent successfully'));

            // redirect to home page
            return $this->redirectToRoute('app_home');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/infos', name: 'app_infos')]
    public function infos(): Response
    {
        return $this->render('main/infos.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
