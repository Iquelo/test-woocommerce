<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $woocommerce, $product;

$crosssells = $woocommerce->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = $woocommerce->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', 3 ),
	'no_found_rows'       => 1,
	'orderby'             => 'rand',
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', 4 );

if ( $products->have_posts() ) : ?>

<aside id="crosssell-popup" rel="inline-auto" class="mfp-hide theme-popup" data-class="crosssell-popup">
	<div class="products cf">

		<h2><?php _e('Complimentary Products',THB_THEME_NAME ) ?></h2>

		<div class="products cf">

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div>

	</div>
	<a href="#" onclick="jQuery('.mfp-close').trigger('click'); return false;" class="btn"><?php _e('Back to Shopping Bag', THB_THEME_NAME); ?></a>

</aside>
<?php endif;

wp_reset_query();