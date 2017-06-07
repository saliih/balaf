<?php

namespace PostBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ViewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlexaRepository extends EntityRepository
{
    public function findMonth(){
        $dt = new \DateTime();
        $dt->modify("-10 days");
        $query = $this->getEntityManager()
            ->createQuery("select a from
                                PostBundle\Entity\Alexa as a where 
                                 a.dcr >='".$dt->format('Y-m-d')."'");
        return $query->getResult();

    }
}
