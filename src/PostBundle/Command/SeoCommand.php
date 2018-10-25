<?php

namespace PostBundle\Command;

use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeoCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:seo')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $posts = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Post')->findBy(['titleSeo' => null]);
        /** @var Post $post */
        foreach ($posts as $post) {
            $title = $post->getCategory()->getTitle() . " : " . $post->getTitle() . "  de la cuisine tunisienne";
            $description = "Recette tunisienne - " . $post->getCategory()->getDescription() . " , " . $post->getTitle();
            if ($post->getRamadan2017()) {
                $dt = new \DateTime();
                $description .= " pour Ramadan " . $dt->format('Y');
            }
            $post->setTitleSeo($title);
            $post->setDescriptionSeo($description);
            $em->persist($post);
        }
        $em->flush();
        echo "done";
    }
}
