<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function findRandoms($max = 5)
    {
        $em = $this->getEntityManager();
        $config = $em->getConfiguration();
        $config->addCustomNumericFunction(
            'RAND',
            '\Webmasters\Doctrine\ORM\Query\RandFunction'
        );

        $query = $em
            ->createQueryBuilder()
            ->select('a, RAND() AS rnd')
            ->from('Entities\Article', 'a')
            ->orderBy('rnd')
            ->setMaxResults($max)
            ->getQuery()
        ;
        $result = $query->getResult();

        // Noetig wegen der speziellen Schreibweise von RAND()
        return array_column($result, 0);
    }

    public function findDuplicates(\Entities\Article $article){
        $em = $this->getEntityManager();
        $query = $em
            ->createQueryBuilder()
            ->select("a")
            ->from("Entities\Article","a")
            ->where("a.title = :title")
            ->andWhere("a.id != :id")
            ->setParameters(["title" => $article->getTitle(),"id" => $article->getId()])
            ->getQuery();
        return $query->getResult();
    }

    public function findArticle(){
        $em = $this->getEntityManager();
        $id = isset($_GET["id"]) && !empty($_GET["id"]) ? $_GET["id"] : $_REQUEST["id"];

        $article = $em
            ->createQueryBuilder()
            ->select("a,t,u")
            ->from("Entities\Article","a")
            ->where("a.id = :id")
            ->leftJoin("a.tags","t")
            ->leftJoin("a.user","u")
            ->setParameter("id",(int)$id)
            ->getQuery()
            ->getSingleResult();
        return $article;
    }
}
