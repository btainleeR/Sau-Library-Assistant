<?php if (!defined('THINK_PATH')) exit();?><div class="form-group">
    <select class="form-control" id="seat">
    <?php if(is_array($seats)): foreach($seats as $key=>$seat): ?><option value="<?php echo ($seat['number']); ?>"><?php echo ($seat['name']); ?></option><?php endforeach; endif; ?>
    </select>
</div>