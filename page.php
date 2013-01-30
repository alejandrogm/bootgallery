<?php get_header();?>
		<section id="page" class="container">			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
			<article class="row-fluid">
				<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<div class="span9">
					<?php the_content();?>
				</div>
			</article>			
			<?php endwhile; else: ?>
			<?php endif; ?>
		</section>
<?php get_footer();?>