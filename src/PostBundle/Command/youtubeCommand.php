<?php

namespace PostBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class youtubeCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:youtube')
            ->setDescription('update all body videos');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $videos = $this->getContainer()->get('doctrine')->getRepository("PostBundle:Videos")->findAll();
        foreach ($videos as $video){
            $output->writeln($video->getName());
            $html = 'https://www.googleapis.com/youtube/v3/videos?id=' . $video->getVideosId() . '&key=AIzaSyBGseWi-G-NxC1wO0R4UtTEg0HmSPXSJlI&part=snippet';
            $response = file_get_contents($html);
            $decoded = json_decode($response, true);
            //echo "<pre>";print_r($decoded);exit;
            $data = $decoded['items'][0]['snippet'];
            $video->setBody($data['description']);
            $em->persist($video);
        }
        $em->flush();
        $output->writeln("Done");
    }
}
