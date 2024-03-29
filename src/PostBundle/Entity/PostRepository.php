<?php

namespace PostBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    public function getTags($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->join('p.tags', 'f')
            ->where($qb->expr()->eq('f.id', $id));
        return $qb;
    }
    public function search($str){
        $query = $this->getEntityManager()
            ->createQuery("select p  from
                                PostBundle\Entity\Post as p where p.title like '%$str%' or p.article  like '%$str%' or p.strtags  like '%$str%'");
        return $query->getResult();
    }
    public function related($cat)
    {
        $query = $this->getEntityManager()
            ->createQuery("select post  from
                                PostBundle\Entity\Post as post
                                where  post.category=" . $cat . " and
								post.enabled = true
                            order by rand()
                            ");
        echo $query->getSQL();
        exit;
        return $query->getResult();
    }

    public function findbycat($cat = array())
    {
        $str = "";
        foreach ($cat as $value) {
            $str .= $value . ", ";
        }
        $str = substr($str, 0, -2);
        $query = $this->getEntityManager()
            ->createQuery("select post  from
                                PostBundle\Entity\Post as post ,
                                PostBundle\Entity\Category as cat
                                where  post.category=cat.id
								post.enabled = true
                                and cat.id in (str)
                            order by post.id DESC
                            ");
        echo $query->getSQL();
        exit;
        return $query->getResult();
    }
}
