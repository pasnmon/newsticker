<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 28.05.19
 * Time: 12:32
 */

namespace Repositories;

use Doctrine\ORM\EntityRepository;

class UserGroupRepository  extends EntityRepository
{
    public function findDuplicates(\Entities\UserGroup $group){
        $em = $this->getEntityManager();
        $query = $em
            ->createQueryBuilder()
            ->select("g")
            ->from("Entities\UserGroup","g")
            ->where("g.title = :title")
            ->andWhere("g.id != :id")
            ->setParameters(["title" => $group->getTitle(),"id" => $group->getId()])
            ->getQuery();
        return $query->getResult();
    }
}