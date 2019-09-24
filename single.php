<?php
/**
 * The template for single listings.
 *
 * @package WPCasa Geneva
 */
get_header();  ?>

<?php if( ! wpsight_is_listing_expired() || wpsight_user_can_edit_listing( get_the_id() ) ) :

    //disable default wpcasa output. Both elementor and wpcasa do overload global post. Here we prevent overload by wpcasa
    add_filter('wpsight_listing_single_output', function() {
        return false;
    });

    //if elementor pro tempalate set, show it
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) :

        //if elementor pro tempalate not set
        if ( geneva_is_built_with_elementor(get_the_ID()) ) : //check if elementor turned on to this particular page

            the_post(); // WARNING fix by added the_post here. Related to how wpcasa work
            the_content();

        else : // if elementor turned off to this page return wpcasa post overloading and show default content

            add_filter('wpsight_listing_single_output', function() {
                return true;
            });
 ?>

        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
    <?php get_template_part( 'template-parts/content-listing', 'single-expired' ); ?>
<?php endif; ?>


<?php  get_footer(); ?>
