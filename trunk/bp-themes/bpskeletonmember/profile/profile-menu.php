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
	$sql['where'] = 'ID = ' . $current_profile_id . ''; 

	$ranking = $wpdb->get_results(implode(' ', $sql));
 ?>
<div id="ranking_<?php echo preg_replace('/ /', '', $ranking->mularango); ?>">
  <!-- <p><?php echo $current_profile_id . $ranking->mularango; ?> con <?php echo $ranking->puntaje; ?></p> -->
</div>

<h3>Blogs</h3>

<?php do_action( 'template_notices' ) ?>

<?php if ( bp_has_blogs() ) : ?>
	
	<ul id="blog-list" class="item-list">
		<?php while ( bp_blogs() ) : bp_the_blog(); ?>
			
			<li>
				<h4><a href="<?php bp_blog_permalink() ?>" title="<?php bp_blog_title() ?>"><?php bp_blog_title() ?></a></h4>
				<!-- <p><?php bp_blog_description() ?></p> -->
			</li>
			
		<?php endwhile; ?>
	</ul>
	
<?php else: ?>

	<div id="message" class="info">
		<p><?php bp_word_or_name( __( "You haven't created any blogs yet.", 'buddypress' ), __( "%s hasn't created any public blogs yet.", 'buddypress' ) ) ?> <?php bp_create_blog_link() ?></p>
	</div>

<?php endif;?>

<?php bp_custom_profile_sidebar_boxes() ?>