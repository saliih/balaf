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
        );
        $serializer = new ArraySerializer();
        $auth = new SingleUserAuth($credentials, $serializer);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dt = new \DateTime();
        $posts = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Post')->findOneBy(array('twitter' => false, 'enabled' => true), array('id' => 'DESC'));
        try {
            if ($posts) {
                $year = $posts->getPublieddate()->format('Y');
                $month = $posts->getPublieddate()->format('m');
                $url = $this->getContainer()->get('router')->generate('front_article', array(
                    'locale' => 'fr',
                    'slug' => $posts->getAlias(),
                    'year' => $year,
                    'month' => $month,
                    'categoryname' => $posts->getCategory()->getSlug(),
                ));
                $url = "http://www.tounsia.net" . $url;

                $params = array(
                    'status' => '#Recette : ' . $posts->getTitle() . "\n  " . $url,
                    //'media_ids' => implode(',', $media_ids),
                );
                if (strlen('#Recette : ' . $posts->getTitle() . "\n  " . $url) < 140)
                    $response = $auth->post('statuses/update', $params);
                $message = \Swift_Message::newInstance()
                    ->setSubject('share reseted')
                    ->setFrom('tounsianet@gmail.com')
                    ->setTo('salah.chtioui@gmail.com')
                    ->setBody("shared : ".$posts->getTitle());
                $this->getContainer()->get('mailer')->send($message);
                $posts->setTwitter(true);
                if (isset($response['entities']['urls'][0]['url']))
                    $posts->setShortlink($response['entities']['urls'][0]['url']);
                $em->persist($posts);
                $em->flush();
                echo "done \n";
            } else {
                $posts = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Post')->findAll();
                foreach ($posts as $post) {
                    $post->setTwitter(false);
                    $em->persist($posts);
                }
                $em->flush();
                echo "reset \n";
                $message = \Swift_Message::newInstance()
                    ->setSubject('share reseted')
                    ->setFrom('tounsianet@gmail.com')
                    ->setTo('salah.chtioui@gmail.com')
                    ->setBody("share reseted");
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
}
