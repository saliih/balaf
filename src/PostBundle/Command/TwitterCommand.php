<?php

namespace PostBundle\Command;

use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PostBundle\twitter\Auth\SingleUserAuth;
use PostBundle\twitter\Serializer\ArraySerializer;

class TwitterCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:twitter')
            ->setDescription('autoShare Twitter');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        date_default_timezone_set('UTC');
        $servicePost = $this->getContainer()->get('Tools.utils');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dt = new \DateTime();
        /** @var Post $posts */
        $posts = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Post')->findOneBy(array('twitter' => false, 'enabled' => true), array('id' => 'DESC'));//'ramadan2017'=>true,
        $autoshare =$this->getContainer()->get('doctrine')->getRepository('PostBundle:Settings')->find(1);
        if($autoshare->getAct()) {
            try {
                if ($posts != null) {
                    $servicePost->sharePostTwitter($posts);
                    $output->writeln( "done");
                } else {
                    $posts = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Post')->findAll();
                    foreach ($posts as $post) {
                        $post->setTwitter(false);
                        $em->persist($post);
                    }
                    $autoshare->setAct(false);
                    $em->persist($autoshare);
                    $em->flush();
                    $output->writeln( "Reset");
                    $message = \Swift_Message::newInstance()
                        ->setSubject('share reseted')
                        ->setFrom('tounsianet@gmail.com')
                        ->setTo('salah.chtioui@gmail.com')
                        ->setBody("share reseted you must activate script");
                    $this->getContainer()->get('mailer')->send($message);
                }
            } catch (\Exception $e) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('problème partage')
                    ->setFrom('tounsianet@gmail.com')
                    ->setTo('salah.chtioui@gmail.com')
                    ->setBody('Exception reçue : ' . $e->getMessage()." <br>".$posts->getTitle());
                $this->getContainer()->get('mailer')->send($message);
                $output->writeln("Error");
            }
        }else{
            $output->writeln("Not Activated");
        }
    }
}
