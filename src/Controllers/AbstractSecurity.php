<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 21.03.19
 * Time: 09:15
 */

namespace Controllers;


abstract class AbstractSecurity extends AbstractBase
{

    public function run($action){

        $this->addContext("em",$this->em);

        if (!in_array($action,["login","register"]) && !isLoggedIn() ){
            $this->redirect("login","user");
        }
        if (in_array($action,["edit","delete","add"]) && getGroupId($this->getEntityManager()) != 1){
            $this->redirect();
        }
        parent::run($action);
    }
}