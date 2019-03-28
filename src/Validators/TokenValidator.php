<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 21.03.19
 * Time: 09:56
 */

namespace Validators;

use Webmasters\Doctrine\ORM\EntityValidator;

class TokenValidator extends EntityValidator
{
    protected $csrfTokenChecked = false;

    public function validateCsrfToken($template, $post)
    {
        $token = $post['csrf_token'] ?? '';
        $valid = !empty($token) && validateCsrfToken($token, $template);

        if (!$valid) {
            $this->addError('Sicherheitsproblem: Ungültiges Formular-Token entdeckt.');
        }

        $this->csrfTokenChecked = true;

        return $this;
    }

    public function getErrors()
    {
        if (!$this->isCsrfTokenChecked()) {
            $this->addError('Sicherheitsproblem: Überprüfung des Formular-Tokens fehlt.');
        }

        return parent::getErrors();
    }

    public function isValid()
    {
        return parent::isValid() && $this->isCsrfTokenChecked();
    }

    protected function isCsrfTokenChecked()
    {
        return $this->csrfTokenChecked === true;
    }


}