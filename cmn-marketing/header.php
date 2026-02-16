<?php
if (!defined('ABSPATH')) {
	exit;
}

$default_primary_cta_url = home_url('/contact/');
$primary_cta_label = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('primary_cta_label', 'Book a Demo') : 'Book a Demo';
$primary_cta_url = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('primary_cta_url', $default_primary_cta_url) : $default_primary_cta_url;

if ($primary_cta_label === '') {
	$primary_cta_label = 'Book a Demo';
}

if ($primary_cta_url === '') {
	$primary_cta_url = $default_primary_cta_url;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class('cmn-no-js'); ?>>
<?php wp_body_open(); ?>
<a class="cmn-skip-link" href="#cmn-main"><?php esc_html_e('Skip to content', 'cmn-marketing'); ?></a>
<header class="cmn-site-header">
	<div class="cmn-container cmn-site-header__inner">
		<a class="cmn-brand" href="<?php echo esc_url(home_url('/')); ?>">CoverMeNow ONE</a>

		<nav class="cmn-nav" aria-label="<?php esc_attr_e('Primary navigation', 'cmn-marketing'); ?>">
			<button
				type="button"
				class="cmn-nav__toggle"
				aria-expanded="false"
				aria-controls="cmn-primary-menu"
			>
				<span class="cmn-nav__toggle-text"><?php esc_html_e('Menu', 'cmn-marketing'); ?></span>
				<span class="cmn-nav__toggle-icon" aria-hidden="true">
					<span></span>
					<span></span>
					<span></span>
				</span>
			</button>

			<div id="cmn-primary-menu" class="cmn-nav__menu">
				<?php if (has_nav_menu('primary')) : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_id'        => 'cmn-primary-menu-list',
							'menu_class'     => 'cmn-nav__list',
							'fallback_cb'    => false,
							'depth'          => 1,
						)
					);
					?>
				<?php else : ?>
					<ul id="cmn-primary-menu-list" class="cmn-nav__list">
						<li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
						<li><a href="<?php echo esc_url(home_url('/schools/')); ?>">Schools</a></li>
						<li><a href="<?php echo esc_url(home_url('/candidates/')); ?>">Candidates</a></li>
						<li><a href="<?php echo esc_url(home_url('/services/')); ?>">Services</a></li>
						<li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
					</ul>
				<?php endif; ?>

				<div class="cmn-nav__mobile-cta">
					<a class="cmn-btn" href="<?php echo esc_url($primary_cta_url); ?>"><?php echo esc_html($primary_cta_label); ?></a>
				</div>
			</div>
		</nav>

		<a class="cmn-btn cmn-site-header__cta" href="<?php echo esc_url($primary_cta_url); ?>"><?php echo esc_html($primary_cta_label); ?></a>
	</div>
</header>
