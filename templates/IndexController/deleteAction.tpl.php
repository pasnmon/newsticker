<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 20.03.19
 * Time: 13:23
 */?>

<p>
    Wollen Sie den Artikel
    &quot;<?= clean($article->getTitle())?>&quot;
    vom <?= clean($article->getCreatedAt()->format("d.m.Y")) ?>
    wirklich entfernen?
</p>

<form action="index.php?action=delete" method="post">
        <input type="hidden" name="id" value="<?= (int)$article->getId() ?>"/>
        <input class="btn btn-success" type="submit" class="button" value="Ja" />
    <input type="hidden" name="csrf_token" value="<?= clean($token, false) ?>" />
        <a class="btn btn-danger" href="index.php">Abbrechen</a>
</form>
