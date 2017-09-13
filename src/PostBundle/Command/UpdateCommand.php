<?php

namespace PostBundle\Command;

use PostBundle\Entity\Alexa;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:update')
            ->setDescription('update');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $posts = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Post')->findAll();
        foreach ($posts as $post){
            $post->setNbview($post->getView()->count());
            $em->persist($post);
            $output->writeln('article id '.$post->getId());
        }
        $em->flush();
        $output->writeln('done');
    }
}
