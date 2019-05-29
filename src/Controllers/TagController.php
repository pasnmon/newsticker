<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 18.03.19
 * Time: 11:03
 */

namespace Controllers;

use Doctrine\ORM\EntityManager;


class TagController extends AbstractSecurity
{

    public function __construct($basePath, EntityManager $em)
    {
        parent::__construct($basePath, $em);
        $this->setPermission("article");
    }

    protected function addAction(){
        $em = $this->getEntityManager();
        $tags = $em
            ->getRepository("Entities\Tag")
            ->findAll();
        $tag = new \Entities\Tag();

        if ($_POST){
            $tag->mapFromArray($_POST);

            $validator = $em
                ->getValidator($tag)
                ->validateCsrfToken($this->getTemplate(),$_POST);
            if ($validator->isValid()){
                $em->persist($tag);
                $em->flush();

                $this->setMessage("Tag added");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());
        }

        $this->addContext("tag", $tag);
        $this->addContext("tags", $tags);
        $this->addContext("token",getCsrfToken($this->getTemplate()));
        $this->setTemplate("editAction");
    }

    protected function readAction(){
        $em = $this->getEntityManager();

        $tag = $em
            ->getRepository("Entities\Tag")
            ->find((int)$_GET["id"]);

        $articles = $tag->getArticles();

        ($articles && $tag ) || $this->render404();

        $this->addContext("tag",$tag);
        $this->addContext("articles",$articles);
        $this->addContext("controller","IndexController");
        $this->addContext("action","index");
        $this->setTemplate("indexAction","IndexController");
    }

    protected function editAction(){
        $em = $this->getEntityManager();
        $tags = $em
            ->getRepository("Entities\Tag")
            ->findAll();
        $tag = $em
            ->getRepository("Entities\Tag")
            ->find($_REQUEST["id"]);

        $tag || $this->render404();

        if ($_POST){
            $tag->mapFromArray($_POST);

            $validator = $em
                ->getValidator($tag)
                ->validateCsrfToken($this->getTemplate(),$_POST);

            if ($validator->isValid()){
                $em->persist($tag);
                $em->flush();

                $this->setMessage("Tag edited");
                $this->redirect("index","index");
            }

            $this->addContext("errors",$validator->getErrors());
        }

        $this->addContext("tag", $tag);
        $this->addContext("tags", $tags);
        $this->addContext("token",getCsrfToken($this->getTemplate()));
    }

    protected function deleteAction(){
        $em = $this->getEntityManager();
        $tag = $em
            ->getRepository("Entities\Tag")
            ->find((int)$_REQUEST["id"]);

        $tag || $this->render404();

        if ($_POST){

            $validator = new \Validators\TokenValidator($em, new class {
                use \Traits\ArrayMappable;
            });
            $validator->validateCsrfToken($this->getTemplate(), $_POST);

            if($validator->isValid()){
                $em->remove($tag);
                $em->flush();

                $this->setMessage("Tag deleted");
                $this->redirect();
            }

            $this->addContext("errors",$validator->getErrors());
        }
        $this->addContext("tag",$tag);
        $this->addContext("token",getCsrfToken($this->getTemplate()));
    }
}