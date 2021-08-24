<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package simona
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
        
        <?php if ( get_theme_mod( 'simona_custom_instagram' ) ) { ?>
        <div class="simona-instagram" data-inst="<?php echo esc_html( get_theme_mod( 'simona_custom_instagram' ) ); ?>">
            <h3 class="simona-instagram-title"><?php esc_html_e( 'Follow me on Instagram!', 'simona' ); ?></h3>
            <div class="simona-instagram-wrapper"></div>
        </div>
        <?php } ?>

		<div class="site-info">
			Copyright ©  2021 Selvel Domestoware All rights reserved.
        </div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->



<?php wp_footer(); ?>
<script type="text/javascript" src="https://selvelglobal.com/blog/wp-content/themes/selvel/js/jquery-ui.js"></script>
<script type="text/javascript" src="https://selvelglobal.com/blog/wp-content/themes/selvel/js/jquery-3.3.1.min.js"></script>
<script>
jQuery(window).scroll(function(){
  if (jQuery(window).scrollTop() >= 150) {
    jQuery('header').addClass('sticky');
  }
  else {
    jQuery('header').removeClass('sticky');
  }
  });

var cv = $(window).width();
    if (cv < 600) {


        $('.togglemenus').on("click", function(event)
            {
                $('.menu-menu-container').toggleClass('slide');
                event.stopPropagation();
            });

            $('.menu-menu-container').on("click", function(event)
            {
                event.stopPropagation();
            });

            $(document).on("click", function(event)
            {
                $('.menu-menu-container').removeClass("slide");
            });

       
    } 
  </script>
</body>
</html>
