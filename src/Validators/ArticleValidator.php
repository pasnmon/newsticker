<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 19.03.19
 * Time: 10:08
 */

namespace Validators;

use Webmasters\Doctrine\ORM\{Util};

class ArticleValidator extends TokenValidator
{
    public function validatePublishedAt($publishedAt){
        $now = new Util\DateTime("now");

        if (!$publishedAt->isValid()){
            $this->addError("Das Feld PublishAt muss einen korrekten Datumswert enthalten.");
        } elseif (!$now->isValidClosingDate($publishedAt)){
            $this->addError ("Das Feld PublishAt darf kein Datum in der Vergangenheit enthalten.");
        }
    }

    public function validateTitle($title){
        if (empty($title)){
            $this->addError("Das Feld Titel muss ausgefüllt werden.");
        }elseif ($this->getRepository()->findDuplicates($this->getEntity())){
            $this->addError("Der Titel existiert bereits.");
        }
    }

    public function validateTeaser($teaser){
        if (empty($teaser)){
            $this->addError("Das Feld Teaser muss ausgefüllt werden.");
        }
    }

    public function validateNews($news){
        if (empty($news)){
            $this->addError("Das Feld News muss ausgefüllt werden.");
        }
    }

    public function validateTags($tags){
        if ($tags->isEmpty()){
            $this->addError("Es muss mindestens ein Tag ausgewählt werden.");
        }
    }
}