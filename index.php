<?php get_header();?>
		<section id="content" class="container">			
			<div class="thumbnails">
				<?php
					$i=0;
					if ( have_posts() ) : while ( have_posts() ) : the_post();
					$i++;
					if($i==3){$sizeclass = 'span6';} elseif($i==4){$sizeclass = 'span3 left';} elseif($i==6){$sizeclass = 'span6 left';} elseif($i==7 || $i==9){$sizeclass = 'span3 noleft';} else{$sizeclass = 'span3';}
					if($i %6==0 || $i==1){ echo '<div class="row-fluid">'; }
				?>
				<article class="<?php echo $sizeclass;?>">
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<a class="thumbnail" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('large');?>
					</a>
				</article>			
				<?php if($i %5==0){ echo '</div>'; }?>
				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<div id="navigation" class="container">
			<?php next_posts_link( __( '<div class="btn btn-info"><span class="meta-nav">&larr;</span> Older posts</div>') ); ?>
			<?php previous_posts_link( __( '<div class="btn btn-info">Newer posts <span class="meta-nav">&rarr;</span></div>') ); ?>
		</div>
<?php get_footer();?>