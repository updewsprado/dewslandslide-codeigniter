
<style type="text/css">
    #locked-row, #normal-row, #archived-row {
        font-size: 12px;
    }
    .glyphicon-trash {
        top: 2px;
    }
</style>

<!-- <div class="row">
    <div class="col-sm-12"><h3>Active Issues and Reminders</h3></div>
</div> -->

<?php  
    $locked_and_normal = json_decode($locked_and_normal);
?>

<div class="panel panel-danger">
    <div class="panel-heading"><h4><strong>&nbsp;Active Issues and Reminders</strong></h4></div>
    <div class="panel-body">
        <div id="locked-row">
            <?php if(count($locked_and_normal) == 0): ?>
                <div class="text-center">
                    <strong>No active issues/reminders</strong></div>
                </div>
            <?php endif; ?>
            <?php $i = 0; $end = end($locked_and_normal); $second = prev($locked_and_normal); foreach ($locked_and_normal as $post): ?>
            <?php if($i % 2 == 0) echo "<div class='row'>"; ?>
            <div class="col-sm-6">
                <div class="alert alert-<?php if($post->status == 'normal') echo 'info'; else echo 'danger'; ?>" <?php if($post === $end || count($locked_and_normal) % 2 == 0 && $post === $second) echo "style='margin-bottom:0'"; ?>>
                    <div class="row">
                        <div class="col-sm-9"><?php echo date("j F Y, g:i A", strtotime($post->ts_posted)); ?></div>
                        <div class="col-sm-3"><div class="pull-right"><?php if($post->status == 'locked'): ?><span class="glyphicon glyphicon-lock" title="Locked Announcement" data-iar-id="<?php echo $post->iar_id; ?>"></span><?php endif; ?>&ensp;<span class="glyphicon glyphicon-edit" title="Edit" data-iar-id="<?php echo $post->iar_id; ?>"></span>&ensp;<span class="glyphicon glyphicon-trash" title="Archive" data-iar-id="<?php echo $post->iar_id; ?>"></span></div></div>
                    </div>
                    <br/>
                    <?php
                        if( $post->event_id != null ): ?>
                         <div class="row">
                            <div class="col-sm-12 text-justify"><strong>Event Monitoring for <?php echo strtoupper($post->name); ?></strong></div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-12 text-justify">&emsp;&emsp;<?php echo nl2br($post->detail); ?></div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12"><span class="pull-right"><?php echo "$post->first_name $post->last_name"; ?></span></div>
                    </div>
                </div>
            </div>
            <?php if($post === $end) echo "</div>"; else if($i % 2 == 1) echo "</div>"; $i++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading"><h4><strong>&nbsp;Archived Issues and Reminders</strong></h4></div>
    <div class="panel-body">
        <div id="archived-row" class="row">
            <?php if(count(json_decode($archived)) == 0): ?>
                <div class="text-center">
                    <strong>No archived issues/reminders</strong></div>
                </div>
            <?php endif; ?>
            <?php foreach (json_decode($archived) as $post): ?>
            <div class="col-sm-6">
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-sm-10"><?php echo date("j F Y, g:i A", strtotime($post->ts_posted)); ?></div>
                        <div class="col-sm-2"><div class="pull-right"><span class="glyphicon glyphicon-lock" title="Archived Announcement"></span></div></div>
                    </div>
                    <br/>
                    <?php
                        if( $post->event_id != null ): ?>
                         <div class="row">
                            <div class="col-sm-12 text-justify"><strong>Event Monitoring for <?php echo strtoupper($post->name); ?></strong></div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-12 text-justify">&emsp;&emsp;&emsp;<?php echo nl2br($post->detail); ?></div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12"><span class="pull-right"><?php echo "$post->first_name $post->last_name"; ?></span></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>    
    </div>
</div>































