<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 20.03.19
 * Time: 16:25
 */
?>

<div id="container">
    <form action="index.php?controller=user&action=login" method="post">
        <ul>
            <li>
                <label for="email">Email:*</label>
                <span><input type="text" id="email" name="email" /></span>
            </li>
            <li>
                <label for="password">Password:*</label>
                <span><input type="password" id="password" name="password"/></span>
            </li>
            <input type="hidden" name="csrf_token" value="<?= clean($token, false) ?>" />
            <li>
                <input type="submit" class="btn btn-success" value="Senden" />
            </li>
        </ul>
    </form>
</div>
