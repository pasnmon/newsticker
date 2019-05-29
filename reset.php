<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 18.03.19
 * Time: 10:34
 */

require_once 'inc/bootstrap.inc.php';
require_once 'inc/helper.inc.php';
use Entities\{
    Tag,
    User,
    Article,
};
// Schritt 1
$em->getConnection()->query('SET FOREIGN_KEY_CHECKS=0;');
$em->getConnection()->query('TRUNCATE TABLE tags;');
$em->getConnection()->query('TRUNCATE TABLE users;');
$em->getConnection()->query('TRUNCATE TABLE tagging;');
$em->getConnection()->query('TRUNCATE TABLE userGroups;');
$em->getConnection()->query('TRUNCATE TABLE articles;');
$em->getConnection()->query('SET FOREIGN_KEY_CHECKS=1;');
// Schritt 2
$entries = [
    ['title' => 'HTML'],
    ['title' => 'JavaScript'],
    ['title' => 'PHP'],
];
foreach ($entries as $entry) {
    $tag = new Tag($entry);
    $em->persist($tag);
}
$entries = [["title" => "Admin","rights" => 11], ["title" => "Gast","rights" => 11]];
foreach ($entries as $entry){
    $userGroup = new \Entities\UserGroup($entry);
    $em->persist($userGroup);
}
$em->flush();

$entry = [
    'email' => 'honk@example.com',
    'displayName' => 'honk',
    'password' => 'Test1234!Test1234!',
];
$user = new User($entry);
$user->setUserGroup($userGroup);
$em->persist($user);

$em->flush();

$query = $em
    ->createQueryBuilder()
    ->select('t')
    ->from('Entities\Tag', 't')
    ->where('t.title = :title1 OR t.title = :title2')
    ->setParameters(['title1' => 'HTML', 'title2' => 'PHP'])
    ->getQuery()
;
$tags = $query->getResult();
$entry = [
    'title' => 'Nur ein Test',
    'teaser' => 'Dies ist nur ein Test ...',
    'news' => 'Erster Absatz' . "\n\n" . 'Zweiter Absatz',
    'published_at' => 'now',
];
$article = new Article($entry);
$user->addArticle($article);
$article->setUser($user);
foreach ($tags as $tag) {
    $tag->addArticle($article);
    $article->addTag($tag);
}
$em->persist($article);
$em->flush();