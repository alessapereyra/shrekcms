<?php
    global $comment, $gdsr;
    $review = GDSRDatabase::get_comment_review($comment->comment_ID);
?>
<div id="gdsrreviewdiv" class="stuffbox">
    <h3>GD Star Rating</h3>
    <div class="inside">
    <?php wp_gdsr_new_comment_review($review); ?>
    <input type="hidden" id="gdsr_comment_edit" name="gdsr_comment_edit" value="edit" />
    </div>
</div>
