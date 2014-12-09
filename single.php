<?php get_header(); ?>
    <!-- main container -->
    <div class="container">
    	<div class="article-list">
        <?php while ( have_posts() ) : the_post(); ?>
                <div class="article">
                <h1><?php the_title(); ?></h1>
                <?php if ( has_post_thumbnail() ) { ?>
                <div class="article-img">
                	<?php the_post_thumbnail(); ?>
                </div>
				<?php }?>
                <div class="article-content">
				<?php the_content(); ?>
				<div class="article-copyright"><i class="fa fa-share-alt"></i> 码字很辛苦，转载请注明来自<b><a href="<?php bloginfo('wpurl');?>"><?php bloginfo('name') ?></a></b>的<a href="<?php the_permalink();?>">《<?php the_title();?>》</a></div>
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>
                </div>
                
            </div>
            <?php
			endwhile;
			?>
        </div>
        <?php get_sidebar(); ?>
    </div>
<!------------------------------>
<?php get_footer(); ?>