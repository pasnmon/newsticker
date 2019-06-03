<?php

namespace Controllers;

use Entities\Article;
use Doctrine\ORM\EntityManager;

class IndexController extends AbstractSecurity
{

    public function __construct($basePath, EntityManager $em)
    {
        parent::__construct($basePath, $em,"article");
    }

    protected function indexAction()
    {
        $em = $this->getEntityManager();
        $articles = $em
            ->createQueryBuilder()
            ->select("a, t, u")
            ->from("Entities\Article","a")
            ->leftJoin("a.tags","t")
            ->leftJoin("a.user","u")
            ->orderBy("a.createdAt","DESC")
            ->getQuery()
            ->getResult();

        $this->addContext("articles",$articles);
    }

    protected function searchAction(){

        $like = clean($_GET["searchField"]);
        /*$query = $this->getEntityManager()              //search for id
            ->createQueryBuilder()->select("a")
            ->from("Entities\Article","a")
            ->where("a.id >= :id1")
            ->andWhere("a.id <= :id2")
            ->setParameters($data)
            ->getQuery();*/

        $query = $this->getEntityManager()             //search for title
            ->createQueryBuilder()
            ->select("a")
            ->from("Entities\Article","a")
            ->where("a.title LIKE :search")
            ->setParameter("search", "%".$like."%")
            ->orderBy("a.createdAt","DESC")
            ->getQuery();

        $this->addContext("like",$like);
        $this->addContext("articles",$query->getResult());
        $this->setTemplate("indexAction");
    }

    protected function readAction(){
        $em = $this->getEntityManager();

        $article	=	$em
            ->getRepository('Entities\Article')
            ->find((int)$_GET['id'])
        ;

        $article || $this->render404();

        $this->addContext("article",$article);
    }

    protected function editAction(){
        $em = $this->getEntityManager();
        $tags = $em
            ->getRepository("Entities\Tag")
            ->findAll();
        $article = $em
            ->getRepository('Entities\Article')
            ->find((int)$_REQUEST['id'])
        ;

        $article || $this->render404();

        if ($_POST){
            $article->mapFromArray($_POST);
            $article->clearTags();

            $tag_ids = $_POST["tag_ids"] ?? [];

            foreach ($tag_ids as $id){
                $article->addTag(
                    $em->getRepository("Entities\Tag")->find($id)
                );
            }

            $validator = $em
                ->getValidator($article)
                ->validateCsrfToken($this->getTemplate(), $_POST);
            if ($validator->isValid()){
                $em->persist($article);
                $em->flush();

                $this->setMessage("Artikel wurde aktualisiert.");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());

        }

        $this->addContext("article",$article);
        $this->addContext("tags",$tags);
        $this->addContext(
            'token',
            getCsrfToken($this->getTemplate())
        );
    }

    protected function addAction(){
        $em = $this->getEntityManager();
        $tags = $em
            ->getRepository("Entities\Tag")
            ->findAll();
        $article = new Article();

        if ($_POST){
            $article->mapFromArray($_POST);
            $article->clearTags();

            $tag_ids = $_POST["tag_ids"] ?? [];

            foreach ($tag_ids as $id){
                $article->addTag(
                    $em->getRepository("Entities\Tag")->find($id)
                );
            }

            $article->setUser(
                $em->getRepository("Entities\User")->find($_SESSION["user_id"])
            );

            $validator = $em
                ->getValidator($article)
                ->validateCsrfToken($this->getTemplate(),$_POST);
            if ($validator->isValid()) {

                $em->persist($article);
                $em->flush();

                $this->setMessage("Article saved");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());
        }

        $this->addContext("article",$article);
        $this->addContext("tags",$tags);
        $this->addContext(
            'token',
            getCsrfToken($this->getTemplate())
        );
        $this->setTemplate("editAction");
    }

    protected function deleteAction(){
        $em = $this->getEntityManager();
        $article = $em
            ->getRepository("Entities\Article")
            ->find((int)$_REQUEST["id"]);

        $article || $this->render404();

        if ($_POST){

            $validator = new \Validators\TokenValidator($em, new class {
                use \Traits\ArrayMappable;
            });
            $validator->validateCsrfToken($this->getTemplate(), $_POST);

            if ($validator->isValid()){
                $em->remove($article);
                $em->flush();

                $this->setMessage("Article deleted");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());
        }
        $this->addContext("article",$article);
        $this->addContext(
            'token',
            getCsrfToken($this->getTemplate())
        );
    }
}
