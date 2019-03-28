<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 19.03.19
 * Time: 09:51
 */

namespace Validators;


class TagValidator extends TokenValidator
{

    public function validateTitle($title){
        $tag = $this->getEntity();
        if (empty($title)){
            $this->addError("Das Feld Title ist leer.");
        } elseif (strlen($title) < 3){
            $this->addError("Der Titel sollte mindestens 3 Zeichen lang sein.");
        } elseif ($this->getRepository()->findDuplicates($tag)){
            $this->addError("Der Titel existiert bereits.");
        }
    }
}