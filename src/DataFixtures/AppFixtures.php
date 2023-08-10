<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {

    }
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('test@test.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                '12345678'
            )
        );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('john@test.com');
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                '12345678'
            )
        );
        $manager->persist($user2);

        $microPost = new MicroPost();
        $microPost->setTitle("最初の投稿");
        $microPost->setText("最初の投稿です");
        $microPost->setCreated(new \DateTime());
        $manager->persist($microPost);

        $microPost2 = new MicroPost();
        $microPost2->setTitle("最初の投稿2");
        $microPost2->setText("最初の投稿2です");
        $microPost2->setCreated(new \DateTime());
        $manager->persist($microPost2);

        $microPost3 = new MicroPost();
        $microPost3->setTitle("最初の投稿3");
        $microPost3->setText("最初の投稿3です");
        $microPost3->setCreated(new \DateTime());
        $manager->persist($microPost3);

        $manager->flush();
    }
}
