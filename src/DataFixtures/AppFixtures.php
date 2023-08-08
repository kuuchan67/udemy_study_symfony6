<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
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
