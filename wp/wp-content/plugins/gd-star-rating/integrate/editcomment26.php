<div id="gdsr_comment_review_edit" style="display: none;">
    <?php include(STARRATING_PATH.'integrate/editcomment.php'); ?>
</div>
<script type="text/javascript">
    function gdsr_move_editbox() {
        document.getElementById("uridiv").parentNode.insertBefore(document.getElementById("gdsr_comment_review_edit"), document.getElementById("uridiv").nextSibling);
        document.getElementById("gdsr_comment_review_edit").style.display="block";
    }
    if (window.addEventListener){ 
       window.addEventListener("load", gdsr_move_editbox, false); 
     } else if (obj.attachEvent){ 
       var r = obj.attachEvent("onload", gdsr_move_editbox); 
     }
</script>
