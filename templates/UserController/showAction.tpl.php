<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 20.03.19
 * Time: 15:27
 */
?>

<?php foreach ($users as $user): ?>
<div class="jumbotron">
    <article>
        <header>
            <h1>Email: <?= $user->getEmail() ?></h1>
            <p>Berechtigung: <?= $user->getUserGroup() ?></p>
        </header>
        <div class="links">
            <a href="index.php?controller=user&action=edit&id=<?= $user->getId() ?>"><i class="fas fa-edit fa-2x"></i></a>
            <a href="index.php?controller=user&action=delete&id=<?= $user->getId() ?>"><i class="fas fa-trash-alt fa-2x"></i></a>
        </div>
    </article>
</div>
<?php endforeach; ?>
