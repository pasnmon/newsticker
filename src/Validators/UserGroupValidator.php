<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 28.05.19
 * Time: 11:33
 */

namespace Validators;

class UserGroupValidator extends TokenValidator
{

    public function validateTitle($title){
        $group = $this->getEntity();
        if (empty($title)){
            $this->addError("Das Feld Title ist leer.");
        } elseif (strlen($title) < 3){
            $this->addError("Der Titel sollte mindestens 3 Zeichen lang sein.");
        } elseif ($this->getRepository()->findDuplicates($group)){
            $this->addError("Der Titel existiert bereits.");
        }
    }

}