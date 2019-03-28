<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 19.03.19
 * Time: 10:23
 */

namespace Repositories;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{

    public function findDuplicates(\Entities\Tag $tag){
        $em = $this->getEntityManager();
        $query = $em
            ->createQueryBuilder()
            ->select("t")
            ->from("Entities\Tag","t")
            ->where("t.title = :title")
            ->andWhere("t.id != :id")
            ->setParameters(["title" => $tag->getTitle(),"id" => $tag->getId()])
            ->getQuery();
        return $query->getResult();
    }
}