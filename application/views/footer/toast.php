<html>

<!-- show toast -->
<div style="text-align: center;">
    <?php if (isset($error)) { ?>
        <script>$.notify('<strong></strong><?= $error;?>',
        { allow_dismiss: true, type: 'danger', placement: {from: 'bottom', align: 'right'}});</script>

    <?php } if (isset($warning)) { ?>
        <script>$.notify('<strong>Atención!  </strong><?= $warning;?>',
        { allow_dismiss: true, type: 'warning', placement: {from: 'bottom', align: 'right'}});</script>

    <?php } if (isset($success)) {?>
        <script>$.notify('<strong></strong><?= $success;?>',
        { allow_dismiss: true, type: 'success', placement: {from: 'bottom', align: 'right'}});</script>
    <?php } ?>
</div>

</html>
