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

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $data = "http://data.alexa.com/data?cli=10&url=tounsia.net";
        if (($response_xml_data = file_get_contents($data)) === false) {
            echo "Error fetching XML\n";
        } else {
            libxml_use_internal_errors(true);
            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                echo "Error loading XML\n";
                foreach (libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            } else {
                $rate = $data->SD->COUNTRY['RANK'];
                if (isset($rate)) {
                    $value = (string)$rate;
                    $alexa = new Alexa();
                    $alexa->setValue($value);
                    $em->persist($alexa);
                    $em->flush();
                    echo "\n done";
                }
            }
        }
    }
}
