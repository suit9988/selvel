<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package simona
 */

get_header(); ?>
<div class="row">
    <div id="primary" class="content-area container-fluid">

        <main id="main" class="site-main" role="main">
		<div>
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
   Home > <?php
    if(function_exists('bcn_display'))
    {
            bcn_display();
    }?>
</div></div>

		<?php while ( have_posts() ) : the_post(); ?>
         
            <div class="hidden-xs col-sm-2 col-md-3">
                <?php get_template_part( 'template-parts/content', 'post-date' ); ?>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-7">
                <?php get_template_part( 'template-parts/content', 'single' ); ?>
				
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
				endif;
					?>
</div><!-- .col-md-6 -->
		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

</div><!-- .row -->
<?php get_footer(); ?>
