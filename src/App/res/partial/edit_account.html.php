<?php 

foreach (array(
    'app',
    't',
    'redirect',
    'redirect_alt',
    'session_token',
    'user'
) as $v) {
    $$v = $data[$v];
}

?>
<form 
    onsubmit="this.querySelector('button').disabled=true; return true;"
    target="_top"
    method="post"
    action="<?php echo($app->url('route', 'user/update?redirect=:redirect&redirect_alt=:redirect_alt', array(':redirect' => $redirect, ':redirect_alt' => $redirect_alt))); ?>" 
>
    <input type="hidden" name="session_token" value="<?php echo $app->htmlEncode($session_token); ?>">
    <input type="hidden" name="context[update_account]" value="1">
    <input type="hidden" name="user[id]" value="<?php echo($app->htmlEncode($user['id'])); ?>">
    <input type="hidden" name="user_old[username]" value="<?php echo($app->htmlEncode($user['username'])); ?>">
    <input type="hidden" name="user_old[email]" value="<?php echo($app->htmlEncode($user['email'])); ?>">

    <p>
        <label>
            <?php echo $t->t('username'); ?><br>
            <input type="text" name="user[username]" required value="<?php echo($app->htmlEncode($user['username'])); ?>">
        </label>
    </p>

    <button><?php echo $t->t('submit'); ?></button>
</form>
