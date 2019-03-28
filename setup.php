<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 18.03.19
 * Time: 10:16
 */
require_once 'inc/bootstrap.inc.php';
require_once 'inc/helper.inc.php';
$schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
$factory = $em->getMetadataFactory();
$metadata = $factory->getAllMetadata();
try {
    $schemaTool->updateSchema($metadata);
} catch (PDOException $e) {
    echo 'ACHTUNG: Bei der Aktualisierung des Schemas gab es ein Problem: ';
    echo $e->getMessage() . "<br />";
    if (preg_match("/Unknown database '(.*)'/", $e->getMessage(), $matches)) {
        die(
        sprintf(
            'Erstellen Sie die Datenbank %s mit der Kollation utf8_general_ci!',
            $matches[1]
        )
        );
    }
}