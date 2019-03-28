<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 20.03.19
 * Time: 13:51
 */

namespace Validators;


class UserValidator extends TokenValidator
{
    protected const PASSWORD_MIN_LENGTH = 12;

    public function validatePassword($password)
    {
        if ($password != null) {
            $entity = $this->getEntity();

            $usedChars = count_chars($password, 1);

            $hasLetters = $this->filterRegex($password, "/[A-Z]+/");

            $hasLowerLetters = $this->filterRegex($password, "/[a-z]+/");

            $hasNumbers = $this->filterRegex($password, "/\d+/");

            $hasSpecialChars = $this->filterRegex($password, "/[_\W]+/");

            if (empty($password)) {
                $this->addError("Das Feld Passwort ist leer.");
            } elseif (strlen($password) < self::PASSWORD_MIN_LENGTH) {
                $this->addError(
                    sprintf("Das Passwort sollte mindestens %d Zeichen lang sein.", self::PASSWORD_MIN_LENGTH));
            } elseif (count($usedChars) < (strlen($password) / 2)) {
                $this->addError("Das Passwort sollte aus mindestens 50% unterschiedlichen Zeichen bestehen.");
            } elseif (
                ($hasLetters === false) ||
                ($hasLowerLetters === false) ||
                ($hasNumbers === false) ||
                ($hasSpecialChars == false)
            ) {
                $this->addError("Das Passwort sollte Großbuchstaben, Kleinbuchstaben, Zahlen und Sonderzeichen enthalten");
            } elseif ($entity->getEmail() && stristr($password, $entity->getEmail()) !== false) {
                $this->addError("Das Passwort sollte keine Privaten Daten enthalten");
            }
        }
    }


    public function validateEmail($email){
        $user = $this->getEntity();

        if (empty($email)){
            $this->addError("Das Feld Email ist leer.");
        }elseif($this->getRepository()->findDuplicatesByEmail($user)){
            $this->addError("Email bereits vergeben.");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->addError("Ungültige Email");
        }
    }

    public function validateDisplayName($displayName){
        $user = $this->getEntity();

        if (empty($displayName)){
            $this->addError("Das Feld Displayname ist leer.");
        }elseif($this->getRepository()->findDuplicatesByDisplayName($user)){
            $this->addError("Displayname bereits vergeben.");
        }
    }

    protected function filterRegex($wert,$regex){
        return filter_var(
            $wert,
            FILTER_VALIDATE_REGEXP,
            [
                "options" => ["regexp" => $regex]
            ]
        );
    }

}