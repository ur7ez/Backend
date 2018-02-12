<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 20:32
 */
$session = \App\Core\App::getSession();
?>
<div class="col-lg-12">
    <h3><?= __('header.contact_us') ?>:</h3>
    <form action="" method="post">
        <input type="text" class="form-control" name="name"
               placeholder="<?= __('contact.name') ?>" <?= ($session->get('login')) ? 'value="' . $session->get('login') . '"' : '' ?>
               required><br>
        <input type="email" class="form-control" name="email"
               placeholder="<?= __('contact.email') ?>" <?= ($session->get('email')) ? 'value="' . $session->get('email') . '"' : '' ?>
               required><br>
        <textarea class="form-control" name="messages" placeholder="<?= __('contact.message') ?>"
                  required></textarea><br>
        <button type="submit" class="btn btn-lg btn-primary btn-block"><?= __('form.send') ?></button>
    </form>
</div>