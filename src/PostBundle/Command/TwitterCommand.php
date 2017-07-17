<?php

namespace PostBundle\Command;

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
        $credentials = array(
            'consumer_key' => 'k8wNWmHoqs4iHIxAXBlIIQPSm',
            'consumer_secret' => 'p2t1b0Vc47fjfs1y50Wrrzy77zcdrt4ZCDZNC6YOu0JIjRjpjK',
            'oauth_token' => '745913210520375296-jJ00sOLElS3nA6y7XSrvSYzvItP4iUM',
            'oauth_token_secret' => 'gEN2VT4DSZwAVPOiE7dws4jUKj2Ybfl0SwJjN5QlM91EY',
        );$output->writeln("1");
        $serializer = new ArraySerializer();
        $auth = new SingleUserAuth($credentials, $serializer);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dt = new \DateTime();
        $output->writeln("2");
        $posts = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Post')->findOneBy(array('twitter' => false, 'enabled' => true), array('id' => 'DESC'));
        $autoshare =$this->getContainer()->get('doctrine')->getRepository('PostBundle:Settings')->find(1);
        if($autoshare->getAct()) {$output->writeln("3");
            try {
                if ($posts != null) {
                    $year = $posts->getPublieddate()->format('Y');
                    $month = $posts->getPublieddate()->format('m');
                    $url = $this->getContainer()->get('router')->generate('front_article', array(
                        'locale' => $posts->getLocale(),
                        'slug' => $posts->getAlias(),
                        'year' => $year,
                        'month' => $month,
                        'categoryname' => $posts->getCategory()->getSlug(),
                    ));
                    $url = "https://www.tounsia.net" . $url;
                    $output->writeln($url);
                    $params = array(
                        'status' => '#Recette : ' . $posts->getTitle() . "\n  " . $url,
                        //'media_ids' => implode(',', $media_ids),
                    );
                    if (strlen('#Recette : ' . $posts->getTitle() . "\n  " . $url) < 140)
                        $response = $auth->post('statuses/update', $params);

                    $posts->setTwitter(true);
                    if (isset($response['entities']['urls'][0]['url']))
                        $posts->setShortlink($response['entities']['urls'][0]['url']);
                    $em->persist($posts);
                    $em->flush();
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
                    ->setBody('Exception reçue : ' . $e->getMessage());
                $this->getContainer()->get('mailer')->send($message);
            }
        }
        $output->writeln("4");
    }
}
