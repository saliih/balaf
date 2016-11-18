<?php

namespace PostBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PublicationCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:activate')
            ->setDescription('Activate Posts');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dt = new \DateTime();
        $posts = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Post')->findBy(array("publieddate"=>$dt,'enabled'=>false));
        foreach ($posts as $post){
            $post->setEnabled(true);
            $em->persist($post);
            $em->flush();
        }
    }
}
