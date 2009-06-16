<?php
/*
 * /profile/profile-menu.php
 * Displays the user's avatar as well as a button to add the user as a friend or send
 * the user a message (if the current user is logged in). Think of this as the profile
 * component's sidebar.
 *
 * Loaded by: 'profile/index.php'
 */
?>
<?php bp_the_avatar() ?>

<div class="button-block">
	
	<?php if ( function_exists('bp_add_friend_button') ) : ?>
		
		<?php bp_add_friend_button() ?>
		
	<?php endif; ?>
	
	<?php if ( function_exists('bp_send_message_button') ) : ?>
		
		<?php bp_send_message_button() ?>
		
	<?php endif; ?>
	
</div>

<?php  
global $bp;
global $wpdb;

$current_profile_id =  $bp->displayed_user->id;

	$sql['select'] = 'SELECT puntaje, mularango';
	$sql['from'] = 'FROM wp_users';
	$sql['where'] = 'ID = \'' . $current_profile_id . '\''; 

	$ranking = $wpdb->get_results(implode(' ', $sql));
 ?>
<div id="ranking_<?php echo preg_replace('/ /', '', $ranking->mularango); ?>">
  <p><?php echo $ranking->mularango; ?> con <?php echo $ranking->puntaje; ?></p>
</div>

<?php bp_custom_profile_sidebar_boxes() ?>