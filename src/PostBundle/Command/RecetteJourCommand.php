<?php

namespace PostBundle\Command;

use PostBundle\Entity\Recettes;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecetteJourCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tounsia:recette')
            ->setDescription('création de recette du jour');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $check = $this->getContainer()->get('doctrine')->getRepository('PostBundle:Recettes')->findOneBy(array('datepub'=>new \DateTime()));
        if(!$check) {
            $recette = new Recettes();
            $recette->setSalade($this->getPost(10));
            $recette->setSoupe($this->getPost(11));
            $recette->setEntree($this->getPost(14));
            $recette->setPrincipal($this->getPost(13));
            $recette->setPatisserie($this->getPost(7));
            $em->persist($recette);
            $em->flush();
            $output->writeln("done");
        }else{
            $output->writeln('exist');
        }
    }
    private function getPost($id){
        $em = $this->getContainer()->get('doctrine')->getManager();
        $entitySoupe = $this->getContainer()->get('doctrine')->getRepository("PostBundle:Category")->find($id);
        $query = $em->createQueryBuilder('c')
            ->select('s')
            ->from('PostBundle:Post', 's')
            ->where('s.ramadan2017 = true')
            ->andWhere('s.category = :category')
            ->setParameter('category',$entitySoupe);
        $result = $query->getQuery()->getResult();
        $current = rand(0,count($result)-1);
        return $result[$current];
    }
}
