<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 20.03.19
 * Time: 14:26
 */

namespace Repositories;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository{

    public function findDuplicatesByEmail(\Entities\User $user){
        $em = $this->getEntityManager();
        $query = $em
            ->createQueryBuilder()
            ->select("u")
            ->from("Entities\User","u")
            ->where("u.email = :email")
            ->andWhere("u.id != :id")
            ->setParameters(["email" => $user->getEmail(), "id" => $user->getId()])
            ->getQuery();
        return $query->getResult();
    }

    public function findDuplicatesByDisplayName(\Entities\User $user){
        $em = $this->getEntityManager();
        $query = $em
            ->createQueryBuilder()
            ->select("u")
            ->from("Entities\User","u")
            ->where("u.displayName = :displayName")
            ->andWhere("u.id != :id")
            ->setParameters(["displayName" => $user->getDisplayName(), "id" => $user->getId()])
            ->getQuery();
        return $query->getResult();
    }

}