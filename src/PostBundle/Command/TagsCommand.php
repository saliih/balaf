<?php

namespace PostBundle\Command;

use PostBundle\Entity\Tags;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TagsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:tags')
            ->setDescription('generate rate tags');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $tags = $this->getContainer()->get('doctrine')->getRepository("PostBundle:Tags")->findAll();
        $total = count($tags);
        /** @var Tags $tag */
        foreach ($tags as $tag){
            $nbpost = count($tag->getPost());
            $rate = $nbpost  / $total;
            $output->writeln($tag->getName()." : ".$rate);
            $tag->setRate($rate);
            $em->persist($tag);
        }
        $em->flush();

    }
}
