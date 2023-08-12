<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\ProfileImageType;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class SettingsProfileController extends AbstractController
{
    #[Route('/settings/profile', name: 'app_settings_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Request $request, UserRepository $repo): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $userProfile = $user->getUserProfile() ?? new UserProfile();

        $form = $this->createForm(UserProfileType::class, $userProfile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userProfile = $form->getData();
            $user->setUserProfile($userProfile);
            $repo->add($user, true);
            $this->addFlash(
                'success',
                '保存しました！'
            );
            return $this->redirectToRoute('app_settings_profile');

        }

        return $this->render('settings_profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/settings/profile-image', name: 'app_settings_profile_image')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function image(Request $request, SluggerInterface $slugger,UserRepository $repo): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getUserProfile()) {
            $oldImage = $user->getUserProfile()->getImage();
        } else {
            $oldImage = null;
        }

        $form = $this->createForm(ProfileImageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $profileImageFile = $form->get('profileImage')->getData();
            if ($profileImageFile) {
                $originalFileName = pathInfo(
                    $profileImageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName . "-" . uniqid() . ".".$profileImageFile->guessExtension();
                try {

                    $profileImageFile->move(
                        $this->getParameter("profiles_directory"),
                        $newFileName
                    );
                    $profile = $user->getUserProfile() ?? new UserProfile();
                    $profile->setImage($newFileName);
                    $user->setUserProfile($profile);
                    $repo->add($user, true);
                    $this->addFlash(
                        'success',
                        '保存しました！'
                    );
                    if ($oldImage && $oldImage != $newFileName) {
                        $filesystem = new Filesystem();
                        $path = $this->getParameter("profiles_directory").$oldImage;
                        $filesystem->remove($path);
                    }
                } catch (FileException $e) {
                    $this->addFlash(
                        'error',
                        '保存に失敗しました'
                    );
                }
            }

            return $this->redirectToRoute('app_settings_profile_image');
        }

        return $this->render('settings_profile/image.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
