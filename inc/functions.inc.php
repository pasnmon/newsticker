<?php

function logIn($id){
    $_SESSION["user_id"] = $id;
}

function isLoggedIn(){
    return (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]));
}

function getGroupId($em){
    if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
        $user = $em
            ->createQueryBuilder()
            ->select("u")
            ->from("Entities\User","u")
            ->where("u.id = :id")
            ->setParameter("id",$_SESSION["user_id"])
            ->leftJoin("u.userGroup","g")
            ->getQuery()
            ->getSingleResult();
        return $user->getUserGroupId();
    }
}

function logOut(){
    unset($_SESSION["user_id"]);
}

function getCsrfToken($template)
{
    $nonce = bin2hex(random_bytes(64));

    if (empty($_SESSION['csrf_tokens'])) {
        $_SESSION['csrf_tokens'] = [];
    }

    $_SESSION['csrf_tokens'][$nonce] = $template;

    return $nonce;
}

function validateCsrfToken($token, $template)
{
    $valid = false;
    if (isset($_SESSION['csrf_tokens'][$token])) {
        if ($_SESSION['csrf_tokens'][$token] === $template) {
            $valid = true;
        }

        unset($_SESSION['csrf_tokens'][$token]);
    }

    return $valid;
}