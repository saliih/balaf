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
		/*if($posts==null){
			exit;
		}*/
        $webpath = '/var/www/tounsia/web';
        echo $img = /*$webpath .*/ $posts->getPic();
        echo "\n";
       // $response = $auth->postMedia('media/upload', $img);
       // $media_ids[] = $response['media_id'];
        $year = $posts->getPublieddate()->format('Y');
        $month = $posts->getPublieddate()->format('m');
        // $path = r':year,'month':month,'categoryname':object.category.slug}) %}
		if($posts->getShortlink()==""){
			$url = $this->getContainer()->get('router')->generate('front_article', array(
				'locale' => 'fr',
				'slug' => $posts->getAlias(),
				'year' => $year,
				'month' => $month,
				'categoryname' => $posts->getCategory()->getSlug(),

			));
			$url = "http://www.tounsia.net".$url;
		}else{
			$url = $posts->getShortlink();
		}
        $params = array(
            'status' => '#Recette : ' . $posts->getTitle() . "\n >> ".$url,
            //'media_ids' => implode(',', $media_ids),
        );

        $response = $auth->post('statuses/update', $params);
        $posts->setTwitter(true);
		$posts->setShortlink($response['entities']['urls'][0]['url']);
        $em->persist($posts);
        $em->flush();
        //print_r($auth->getHeaders());
        print_r($response['entities']['urls'][0]['url']);
    }
}
