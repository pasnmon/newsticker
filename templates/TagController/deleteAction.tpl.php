<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 20.03.19
 * Time: 13:23
 */?>

<p>
    Wollen Sie den Tag
    &quot;<?= clean($tag->getTitle())?>&quot;
    wirklich entfernen?
</p>

<form action="index.php?controller=tag&action=delete" method="post">
    <input type="hidden" name="id" value="<?= (int)$tag->getId() ?>"/>
    <input class="btn btn-success" type="submit" class="button" value="Ja" />
    <input  type="hidden" name="csrf_token" value="<?= clean($token, false) ?>" />
    <a class="btn btn-danger" href="index.php">Abbrechen</a>
</form>
