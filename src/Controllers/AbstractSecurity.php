<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 21.03.19
 * Time: 09:15
 */

namespace Controllers;

use Doctrine\ORM\EntityManager;

abstract class AbstractSecurity extends AbstractBase
{

    protected $permission;

    /**
     * AbstractSecurity constructor.
     * @param $permission
     */
    public function __construct($basePath,EntityManager $em,$permission)
    {
        parent::__construct($basePath,$em);
        $this->permission = $permission;
    }


    public function run($action){

        $this->addContext("em",$this->em);
        $this->addContext('articleRights', getRights("article",$this->em));
        $this->addContext('userRights', getRights("user",$this->em));


        if (!in_array($action,["login","register","index","read"]) && !isLoggedIn() ){
            $this->redirect("login","user");
        }

        if (in_array($action,["edit","delete","add","show"]) && !getRights($this->getPermission(),$this->getEntityManager()))
                $this->redirect();

        parent::run($action);
    }

    /**
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param mixed $permission
     */
    public function setPermission($permission)
    {
        $this->permission = ucfirst($permission);
    }
}