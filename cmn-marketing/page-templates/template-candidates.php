<?php
/**
 * Template Name: CMN Candidates
 * Template Post Type: page
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main id="cmn-main" class="cmn-candidates" aria-label="<?php esc_attr_e('Candidates page content', 'cmn-marketing'); ?>">
	<?php get_template_part('template-parts/candidates/hero'); ?>
	<?php get_template_part('template-parts/candidates/rewards'); ?>
	<?php get_template_part('template-parts/candidates/conduct'); ?>
	<?php get_template_part('template-parts/candidates/referral'); ?>
	<?php get_template_part('template-parts/candidates/learning'); ?>
	<?php get_template_part('template-parts/candidates/faq'); ?>
	<?php get_template_part('template-parts/candidates/final-cta'); ?>
</main>
<?php get_footer(); ?>
