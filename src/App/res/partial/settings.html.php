<?php 

foreach (array(
    'app',
    'partial_edit_account',
    'flash_edit',
    'partial_edit_password',
    'partial_delete',
    'flash_delete'
) as $v) {
    $$v = $data[$v];
}

?>
<div style="height: 0.5em;"></div>

<div class="w4 center">
<fieldset>
    <h2>Edit</h2>
    <?php echo $flash_edit; ?>

    <?php if($flash_edit): ?>
        <div style="height: 0.5em;"></div>
    <?php endif; ?>

    <fieldset>
        <legend>Account</legend>

        <?php echo $partial_edit_account; ?>
    </fieldset>
    <fieldset>
        <legend>Password</legend>

        <?php echo $partial_edit_password; ?>
    </fieldset>
</fieldset>
</div>
<div class="w4 center">
<fieldset>
    <h2>Delete</h2>
    <?php echo $flash_delete; ?>

    <?php if($flash_delete): ?>
        <div style="height: 0.5em;"></div>
    <?php endif; ?>

    <?php echo $partial_delete; ?>
</fieldset>
</div>
