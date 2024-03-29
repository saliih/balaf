<?php

namespace PostBundle\Command;

use PostBundle\Entity\Alexa;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AlexaCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:alexa')
            ->setDescription('GetAlexa rate / day');
    }
	private function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $data = "http://data.alexa.com/data?cli=10&url=tounsia.net";
        if (($response_xml_data = file_get_contents($data)) === false) {
            $output->writeln( "Error fetching XML");
        } else {
            libxml_use_internal_errors(true);
            $data = simplexml_load_string($response_xml_data);
			
            if (!$data) {
                $output->writeln( "Error loading XML");
                foreach (libxml_get_errors() as $error) {
                    $output->writeln( $error->message);
                }
            } else {
                $alexa = new Alexa();
                if(isset($data->SD->COUNTRY['RANK'])) {
                    $rate = $data->SD->COUNTRY['RANK'];
					$rate = $this->xml2array($rate);
                    if (isset($rate)) {
                        $alexa->setValue($rate[0]);
                        $output->writeln("done");
                    }
                }else{
                    $alexa->setValue(0);
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Alexa data')
                        ->setFrom('tounsianet@gmail.com')
                        ->setTo('salah.chtioui@gmail.com')
                        ->setBody('Exception reçue : no data from tunisia ' );
                    $this->getContainer()->get('mailer')->send($message);
                    $output->writeln("No Data");
                }
                $em->persist($alexa);
                $em->flush();
            }
        }
    }
}
