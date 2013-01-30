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
	
	<!-- You can start editing here. Create and Display Threaded (Nested) comments and the Comment form. -->
	<?php if ( have_comments() ) : ?>
	<h3><?php comments_number('No comments', '1 Comment', '% Comments' );?></h3>
	<div class="row-fluid">
		<ul class="commentlist span6" >
		<?php wp_list_comments(array('avatar_size' => 55)); ?>
		</ul>
	</div>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
	<?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>
	<?php endif; ?>
	<?php endif; ?>
	<?php if ('open' == $post->comment_status) : ?>
	<h3 id="respond">Leave a comment</h3>	
	<div class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></div>
	<?php if(get_option('comment_registration') && !$user_ID ):?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="row-fluid">
	<fieldset class="span6">
	<?php if ( $user_ID ) : ?>
	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
	<?php else : ?>
	<div class="control-group">
		<label class="control-label" for="author">Name <small class="req"><?php if ($req) echo "*"; ?></small></label>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-user">&nbsp;</i></span><<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
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
			<textarea class="input-xxlarge" name="comment" rows="5"></textarea>
		</div>
	</div>
	<input name="submit" type="submit" class="btn .pull-right" value="Send Comment" />
	<?php comment_id_fields(); ?>
	<?php do_action('comment_form', $post->ID); ?>
	</fieldset>
	</form>
	<?php endif; // If registration required and not logged in ?>
	<?php endif; // if you delete this the sky will fall on your head ?>