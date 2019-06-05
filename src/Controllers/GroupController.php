<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 28.05.19
 * Time: 09:42
 */

namespace Controllers;

use Doctrine\ORM\EntityManager;

class GroupController extends AbstractSecurity
{

    public function __construct($basePath, EntityManager $em)
    {
        parent::__construct($basePath, $em,"user");
    }

    protected function addAction(){
        $em = $this->getEntityManager();
        $groups = $em->getRepository("Entities\UserGroup")
            ->findAll();
        $group = new \Entities\UserGroup();

        if ($_POST){
            $group->mapFromArray($_POST);

            $validator = $em
                ->getValidator($group)
                ->validateCsrfToken($this->getTemplate(),$_POST);
            if ($validator->isValid()){
                $em->persist($group);
                $em->flush();

                $this->setMessage("Group added");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());
        }

        $this->addContext("group", $group);
        $this->addContext("groups", $groups);
        $this->addContext("token",getCsrfToken($this->getTemplate()));
        $this->setTemplate("editAction");
    }

    protected function editAction(){
        $em = $this->getEntityManager();
        $groups = $em
            ->getRepository("Entities\UserGroup")
            ->findAll();
        $group = $em
            ->getRepository("Entities\UserGroup")
            ->find($_REQUEST["id"]);

        $group || $this->render404();

        if ($_POST){
            $group->mapFromArray($_POST);

            $validator = $em
                ->getValidator($group)
                ->validateCsrfToken($this->getTemplate(),$_POST);

            if ($validator->isValid()){
                $em->persist($group);
                $em->flush();

                $this->setMessage("Group edited");
                $this->redirect("index","index");
            }

            $this->addContext("errors",$validator->getErrors());
        }

        $this->addContext("group", $group);
        $this->addContext("groups", $groups);
        $this->addContext("token",getCsrfToken($this->getTemplate()));
    }

    protected function deleteAction(){
        $em = $this->getEntityManager();
        $group = $em
            ->getRepository("Entities\UserGroup")
            ->find((int)$_REQUEST["id"]);

        $guestGroup = $em
                    ->createQueryBuilder()
                    ->select("g")
                    ->from("Entities\UserGroup","g")
                    ->where("g.title = :title")
                    ->setParameters(["title" => "Gast"])
                    ->getQuery()
                    ->getSingleResult();

        $users = $em
            ->getRepository("Entities\User")
            ->findAll();

        $group || $this->render404();

        if ($_POST){

            $validator = new \Validators\TokenValidator($em, new class {
                use \Traits\ArrayMappable;
            });
            $validator->validateCsrfToken($this->getTemplate(), $_POST);

            if($validator->isValid()){

                foreach ($users as $user){

                    if ($user->getUserGroupId() == $group->getId()){        //Users of the group that gets deleted, get the guest group

                        $user->setUserGroup($guestGroup);
                        $em->persist($user);
                    }

                }
                $em->flush();

                $em->remove($group);
                $em->flush();

                $this->setMessage("Group deleted");
                $this->redirect();
            }

            $this->addContext("errors",$validator->getErrors());
        }
        $this->addContext("group",$group);
        $this->addContext("token",getCsrfToken($this->getTemplate()));
    }
}