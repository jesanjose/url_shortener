<?php if (hasFlash()) { ?>
    <div class="alert alert-<?php echo Session::get("flash-level") ?>">
        <h4>Warning!</h4><?php echo Session::get("flash-message") ?>
    </div>
<?php } ?>

<div class="row-fluid">
    <div class="span12">
        <?php echo  isset($url) ? $url : ""; ?>
    </div>
</div>