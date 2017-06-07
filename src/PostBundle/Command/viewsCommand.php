<?php

namespace PostBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PostBundle\Entity\Refer;

class viewsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:views')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $views = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Views')->findBy(array('referLinks' => null), array(), 2500);
        if (count($views)) {
            foreach ($views as $view) {
                $refer = $view->getRefer();
                $referLink = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Refer')->findOneBy(array('title' => $refer));
                if ($referLink == null) {
                    $referLink = new Refer();
                    $referLink->setTitle($refer);
                    $em->persist($referLink);
                    $em->flush();
                }
                $view->setReferLinks($referLink);
                $em->persist($view);
                $em->flush();
            }
        } else
            $output->writeln("fin");
        $output->writeln("done");
    }
}
