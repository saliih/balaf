<?php

namespace PostBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ViewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ViewsRepository extends EntityRepository
{
    public function findpopular()
    {
        $dt = new \DateTime();
        $dt->modify("-1 week");
        $query = $this->getEntityManager()
            ->createQuery("select p  from
                                PostBundle\Entity\Views as p where 
                                 p.dv >='" . $dt->format('Y-m-d') . "'");
        return $query->getResult();

    }
    public function findYear()
    {
        $dt = new \DateTime();
        $dt->modify("-1 year");
        $query = $this->getEntityManager()
            ->createQuery("select p  from
                                PostBundle\Entity\Views as p where 
                                 p.dv >='" . $dt->format('Y-m-d') . "'");
        return $query->getResult();

    }

    public function findMonth()
    {
        $dt = new \DateTime();
        $dt->modify("-10 days");
        $query = $this->getEntityManager()
            ->createQuery("select p  from
                                PostBundle\Entity\Views as p where 
                                 p.dv >='" . $dt->format('Y-m-d') . "'");
        return $query->getResult();

    }

    public function findquanze()
    {
        $dt = new \DateTime();
        $dt->modify("-15 days");
        $query = $this->getEntityManager()
            ->createQuery("select p  from
                                PostBundle\Entity\Views as p where 
                                 p.dv >='" . $dt->format('Y-m-d') . "'");
        return $query->getResult();

    }

    public function findWeek()
    {
        $dt = new \DateTime();
        $dt->modify("-8 days");
        $dtend = new \DateTime();
        $dtend->modify('-1 day');
        $query = $this->getEntityManager()
            ->createQuery("select p  from
                                PostBundle\Entity\Views as p where 
                                 p.dv >='" . $dt->format('Y-m-d') . " 00:00:00'
                                 and p.dv <= '" . $dtend->format('Y-m-d') . " 23:59:59'
                                 ");
        return $query->getResult();

    }

    public function findToday()
    {
        $dt = new \DateTime();
        $query = $this->getEntityManager()
            ->createQuery("select p  from
                                PostBundle\Entity\Views as p where 
                                 p.dv >='" . $dt->format('Y-m-d') . " 00:00:00'");
        return $query->getResult();

    }

    public function findOneday($dt)
    {
        $query = $this->getEntityManager()
            ->createQuery("select p  from
                                PostBundle\Entity\Views as p where 
                                 p.dv >='" . $dt->format('Y-m-d') . " 00:00:00'
                                 and  p.dv <='" . $dt->format('Y-m-d') . " 23:59:59'
                                 ");
        return $query->getResult();

    }
}
