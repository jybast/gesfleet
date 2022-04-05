<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Image;
use App\Form\EditProfileType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user', name: 'app_user_')]
//#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    //#[IsGranted('ROLE_USER')]
    public function profile(): Response
    {
        return $this->render('user/profile.html.twig', []);
    }

    #[Route('/profile/edit', name: 'profile_edit')]
    //#[IsGranted('ROLE_USER')]
    public function editProfile(Request $request, ManagerRegistry $doctrine, TranslatorInterface $translator): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Get sent images
            $images = $form->get('images')->getData();
            // On boucle sur les images
            foreach ($images as $image) {
                // create a new file name
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // copy image file to the directory
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // create image file name into the database
                $img = new Image();
                $img->setName($fichier);
                $user->addImage($img);
            }

            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', $translator->trans('Your profile is up to date !'));
            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/data', name: 'data')]
    //#[IsGranted('ROLE_USER')]
    public function data(): Response
    {
        return $this->render('user/data.html.twig', []);
    }

    #[Route('/data/download', name: 'data_download')]
    //#[IsGranted('ROLE_USER')]
    public function download(): Response
    {
        // PDF options
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($options);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        $dompdf->setHttpContext($context);

        // Load HTML content
        $dompdf->loadHtml(
            $this->renderView('user/download.html.twig', [])
        );
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();

        // create a new file name
        $fileName = $this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname() . '.pdf';

        // Output the generated PDF to Browser
        $dompdf->stream($fileName, [
            'Attachment' => true
        ]);

        return new Response();
    }

    #[Route('/pass/edit', name: 'pass_edit')]
    //#[IsGranted('ROLE_USER')]
    public function editPass(Request $request, UserPasswordHasherInterface $encoder, ManagerRegistry $doctrine, TranslatorInterface $translator): Response
    {
        if ($request->isMethod('POST')) {
            $em = $doctrine->getManager();
            // Connected user
            $user = $this->getUser();

            // On vérifie si les 2 mots de passe sont identiques
            if ($request->request->get('pass') == $request->request->get('pass2')) {
                $user->setPassword($encoder->hashPassword($user, $request->request->get('pass')));

                $em->persist($user);
                $em->flush();

                $this->addFlash('message', $translator->trans('Password updated'));

                return $this->redirectToRoute('app_user_profile');
            } else {
                $this->addFlash('error', $translator->trans('Both passwords must be the same'));
            }
        }

        return $this->render('user/editPassword.html.twig');
    }


    #[Route('/delete/image/{id}', name: 'delete_image', methods: ['DELETE'])]
    public function deleteImage(Image $image, Request $request, ManagerRegistry $doctrine, TranslatorInterface $translator): Response
    {
        $data = json_decode($request->getContent(), true);

        // Verify if token is valid
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            // Get image name
            $nom = $image->getName();
            // delete file
            unlink($this->getParameter('images_directory') . '/' . $nom);

            // delete image entry in database
            $em = $doctrine->getManager();
            $em->remove($image);
            $em->flush();

            // response in json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => $translator->trans('Invalid Token')], 400);
        }
    }
}
