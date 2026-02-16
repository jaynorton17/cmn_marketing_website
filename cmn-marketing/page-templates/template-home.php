<?php
/**
 * Template Name: CMN Home
 * Template Post Type: page
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main id="cmn-main" class="cmn-home" aria-label="<?php esc_attr_e('Homepage content', 'cmn-marketing'); ?>">
	<?php get_template_part('template-parts/home/hero'); ?>
	<?php get_template_part('template-parts/home/split-value'); ?>
	<?php get_template_part('template-parts/home/powered'); ?>
	<?php get_template_part('template-parts/home/final-cta'); ?>
</main>
<?php get_footer(); ?>
