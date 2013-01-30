<?php get_header();?>
		<section id="single" class="container">			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
			<article class="row-fluid">
				<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<div class="span6 thumbnail">
					<?php the_post_thumbnail('full');?>
				</div>
				<div class="content">
					<?php the_content();?>
				</div>
			</article>		
			<?php endwhile; else: ?>
			<?php endif; ?>
			<section id="comments">
				<?php comments_template('',true); ?>
			</section>	
		</section>
<?php get_footer();?>