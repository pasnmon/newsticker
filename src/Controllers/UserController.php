<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 20.03.19
 * Time: 14:06
 */

namespace Controllers;

use Entities\User;
use Doctrine\ORM\EntityManager;

class UserController extends AbstractSecurity
{

    public function __construct($basePath, EntityManager $em)
    {
        parent::__construct($basePath, $em,"user");
    }

    protected function showAction(){

        $em = $this->getEntityManager();
        $users = $em->getRepository("Entities\User")
                    ->findAll();
        $this->addContext("users",$users);
    }

    protected function loginAction(){

        $em = $this->getEntityManager();

        if ($_POST){
            $user = $em
                ->getRepository("Entities\User")
                ->findOneByEmail($_POST["email"]);

            $validator = new \Validators\TokenValidator($em, new class {
                use \Traits\ArrayMappable;
            });
            $validator->validateCsrfToken($this->getTemplate(), $_POST);

            if ($validator->isValid()){
                if ($user && $user->verifyPasswordHash($_POST["password"])){
                    if ($user->checkPasswordNeedsRehash()){
                        $user->hashPassword();
                    }

                    logIn($user->getId());

                    $this->setMessage("User wurde eingeloggt.");
                    $this->redirect();
                }
            }

            $this->addContext("errors",["Fehlerhafte Logindaten!"]);

        }
        $this->addContext("token",getCsrfToken($this->getTemplate()));
    }

    protected function logoutAction(){

            logOut();
            $this->setMessage("User ausgeloggt");
            $this->redirect();
    }

    protected function registerAction(){

        $em = $this->getEntityManager();
        $user = new User();

        if ($_POST){

            $_POST["userGroup"] = $em->getRepository("Entities\UserGroup")->find(2);

            $user->mapFromArray($_POST);

            $validator = $em
                ->getValidator($user)
                ->validateCsrfToken($this->getTemplate(),$_POST);
            if ($validator->isValid()){
                $em->persist($user);
                $em->flush();

                $this->setMessage("User registriert");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());
        }

        $this->addContext("user",$user);
        $this->addContext("token",getCsrfToken($this->getTemplate()));
        $this->setTemplate("editAction");
    }

    protected function editUserAction(){

        $em = $this->getEntityManager();
        $user = $em
                ->getRepository("Entities\User")
                ->find((int)$_SESSION["user_id"]);
        $this->setTemplate("editAction");

        $user || $this->render404();

        if ($_POST){
            $data = $_POST;
            if ($this->context["action"] == "editUser" && trim($data["password"]) == ""){
                unset($data["password"]);
            }

            $user -> mapFromArray($data);

            $validator = $em
                    ->getValidator($user)
                    ->validateCsrfToken($this->getTemplate(),$data);
            if ($validator->isValid()){
                $em->persist($user);
                $em->flush();

                $this->setMessage("User wurde aktualisiert.");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());
        }

        $this->addContext("token",getCsrfToken($this->getTemplate()));
        $this->addContext("user",$user);
    }

    protected function editAction(){

        $em = $this->getEntityManager();
        $user = $em
            ->getRepository('Entities\User')
            ->find((int)$_REQUEST['id'])
        ;
        $userGroups = $em->getRepository("Entities\UserGroup")
            ->findAll();

        $user || $this->render404();

        if ($_POST){

            $data = $_POST;
            if ($this->context["action"] == "edit" && trim($data["password"]) == ""){
                $data["password"] = null;
            }
            $data["userGroup"] = $em->getRepository("Entities\UserGroup")->find((int)$data["userGroup"]);

            $user->mapFromArray($data);

            $validator = $em
                ->getValidator($user)
                ->validateCsrfToken($this->getTemplate(),$data);
            if ($validator->isValid()){
                $em->persist($user);
                $em->flush();

                $this->setMessage("User wurde aktualisiert.");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());

        }

        $this->addContext("token",getCsrfToken($this->getTemplate()));
        $this->addContext("userGroups",$userGroups);
        $this->addContext("user",$user);
    }

    protected function deleteAction(){

        $em = $this->getEntityManager();

        $user = $em
            ->getRepository("Entities\User")
            ->find((int)$_REQUEST["id"]);

        $deleted = $em
                    ->createQueryBuilder()
                    ->select("u")
                    ->from("Entities\User","u")
                    ->where("u.displayName = :dpName")
                    ->setParameters(["dpName" => "deleted"])
                    ->getQuery()
                    ->getSingleResult();

        $articles = $em
                    ->getRepository("Entities\Article")
                    ->findAll();

        $user || $this->render404();

        if ($_POST){
            $validator = new \Validators\TokenValidator($em, new class {
                use \Traits\ArrayMappable;
            });
            $validator->validateCsrfToken($this->getTemplate(), $_POST);

            if($validator->isValid()){

                foreach ($articles as $article){
                    if ($article->getUserId() == $user->getId()){
                        $article->setUser($deleted);
                        $em->persist($article);
                        $em->flush();
                    }
                }

                $em->remove($user);
                $em->flush();

                $this->setMessage("User gelöscht");
                $this->redirect();
            }
            $this->addContext("errors",$validator->getErrors());
        }

        $this->addContext("user",$user);
        $this->addContext("token",getCsrfToken($this->getTemplate()));
    }
}