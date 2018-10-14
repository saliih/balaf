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
        $tools = $this->getContainer()->get('Tools.utils');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $tags = $this->getContainer()->get('doctrine')->getRepository("PostBundle:Tags")->findAll();
        $total = count($tags);
        $data = array();
        $nbpost = 0;
        /** @var Tags $tag */
        foreach ($tags as $tag){
            $data[] = array(
                'object' => $tag,
                "count" => count($tag->getPost()),
            );
            $nbpost += count($tag->getPost());
        }
        foreach ($data as $datum){
            /** @var Tags $obj */
            $obj = $datum["object"];
            $rate = $datum['count'] * 100 / $nbpost;
            $obj->setRate($rate);
            if($obj->getSlug() === "" || $obj->getSlug() === null){
                $obj->setSlug($tools->slugify($obj->getName()));
            }
            $em->persist($obj);
            $output->writeln($obj->getName()." : ".$obj->getRate());
        }
        $em->flush();

    }
}
