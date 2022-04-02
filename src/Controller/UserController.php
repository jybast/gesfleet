<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
}
