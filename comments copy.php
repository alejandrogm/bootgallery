	<?php // Do not delete these lines
		if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	    if (!empty($post->post_password)) { // if there's a password
		    if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password){  // and it doesn't match the cookie
		    ?>
		    	<p class="nocomments">This post are protected with password<p>
			    <?php
				return;
			}
		}
	?>
	
	<?php if ($comments) : ?>
	<h3><?php comments_number('No comments', '1 Comment', '% Comments' );?></h3>
	<ul>
  		<?php wp_list_comments( array('avatar_size' => 55)); ?>
	</ul>
	<?php else : ?>

	<?php if ('open' == $post->comment_status) : ?>
	<h3>No comments for this entry.</h3>
	<?php else : ?>
	<h3>The comments has been closed.</h3>
	<?php endif; ?>
	<?php endif; ?>
	<?php if ('open' == $post->comment_status) : ?>
	<h3 id="respond">Leave a comment</h3>
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>Ups! you need are <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged</a> to post a comment.</p>
	<?php else : ?>
	 
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="form-vertical" id="commentform">
		<?php if ( $user_ID ) : ?>
			<p class="logueado">You are logged as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> | <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>	
		
		<?php else : ?>
		<div class="control-group">
			<label class="control-label" for="author">Name<small class="req"><?php if ($req) echo "*"; ?></small></label>
			<div class="input-prepend">
				<span class="add-on"><i class="icon-user">&nbsp;</i></span><input type="text" id="inputEmail" placeholder="Name" value="<?php echo esc_attr($comment_author);?>" name="author">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">E-mail <small>(don't be public)</small><small class="req"><?php if ($req) echo "*"; ?></small></label>
			<div class="input-prepend">
				<span class="add-on"><i class="icon-envelope">&nbsp;</i></span><input type="email" name="email" placeholder="Email" id="email" value="<?php echo $comment_author_email; ?>"/>	
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="url">Website</label>
			<div class="input-prepend">		
				<span class="add-on"><i class="icon-home">&nbsp;</i></span><input type="url" name="url" placeholder="Url" id="url" value="<?php echo $comment_author_url; ?>"/>
			</div>
		</div>
		<?php endif; ?>
	  
		<div class="control-group">
			<label class="control-label" for="comment">Comment</label>
			<div class="input">
				<textarea class="input-xxlarge" name="comment" rows="10"></textarea>
			</div>
		</div>
		<input name="submit" type="submit" class="btn" value="Send Comment" />
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	  
		<?php do_action('comment_form', $post->ID); ?>
	</form>
	
	
	<?php endif; // If need logged?>
	<?php endif; // If you delete this your theme will die?>