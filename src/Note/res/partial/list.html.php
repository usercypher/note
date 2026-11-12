<?php 

foreach (array(
    'app',
    'notes',
    'user',
    'redirect',
    'redirect_alt',
    'session_token',
    'is_logged_in',
    'total_size',
    'server_total'
) as $v) {
    $$v = $data[$v];
}

?>

<table style="margin-top: 0.5em;">
    <tr>
        <th>Quota Used</th>
        <td><?php echo $total_size; ?></td>
    </tr>
    <tr>
        <th>Quota Total</th>
        <td>500 KB</td>
    </tr>
    <tr>
        <th>Server Total</th>
        <td><?php echo $server_total; ?></td>
    </tr>
</table>

<?php if ($is_logged_in): ?>

<div style="margin-bottom: 0.5em ;">
    <a class="button" style="margin-right: 1em;" href="<?php echo $app->url('route', 'note/create'); ?>">Create</a>
</div>

<?php endif; ?>

<div class="overflow">
<table style="margin-top: 0.5em;">
    <tr>
        <th></th>
        <th>Notes</th>

        <?php if ($is_logged_in): ?>

        <th>Actions</th>

        <?php endif; ?>

    </tr>
    <?php if (!$notes): ?>
        <tr><td colspan="<?php echo $is_logged_in ? '3': '2'; ?>">There is no notes</td></tr>
    <?php endif; ?>
        
<?php foreach ($notes as $i => $note) : ?>
    <tr>
        <td><?php echo $i + 1; ?></td>
        <td><a href="<?php echo $app->url('note', $user['username'] . '/' . $note); ?>"><?php echo $note; ?></td>

        <?php if ($is_logged_in): ?>

        <td style="white-space: nowrap;">
            <a style="display: inline-block; margin: 0.5em;" class="button" href="<?php echo $app->url('route', 'note/edit/:filename', array(
                ':filename' => $note
            ));?>">Edit</a>
            <form style="display: inline-block; border: 1px solid ButtonFace;" method="POST" action="<?php echo $app->url('route', 'note/delete?redirect=:redirect&redirect_alt=:redirect_alt', array(':redirect' => $redirect, ':redirect_alt' => $redirect_alt));?>">
                <input type="hidden" name="session_token" value="<?php echo $app->htmlEncode($session_token); ?>">
                <input type="hidden" name="note[filename]" value="<?php echo $note; ?>">
                <input style="margin: 0.5em;" name="confirm" type="checkbox" required>
                <button>Delete</button>
            </form>
       </td>
       
       <?php endif; ?>

    </tr>
<?php endforeach; ?>
</table>
</div>