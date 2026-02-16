<?php
/**
 * Template Name: CMN Schools
 * Template Post Type: page
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main id="cmn-main" class="cmn-schools" aria-label="<?php esc_attr_e('Schools page content', 'cmn-marketing'); ?>">
	<?php get_template_part('template-parts/schools/hero'); ?>
	<?php get_template_part('template-parts/schools/differentiators'); ?>
	<?php get_template_part('template-parts/schools/partner-programme'); ?>
	<?php get_template_part('template-parts/schools/infrastructure'); ?>
	<?php get_template_part('template-parts/schools/faq'); ?>
	<?php get_template_part('template-parts/schools/final-cta'); ?>
</main>
<?php get_footer(); ?>
