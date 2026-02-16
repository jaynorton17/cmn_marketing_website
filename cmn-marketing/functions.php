<?php
if (!defined('ABSPATH')) {
	exit;
}

$cmn_settings_file = trailingslashit(get_stylesheet_directory()) . 'inc/settings.php';
if (file_exists($cmn_settings_file)) {
	require_once $cmn_settings_file;
}

/**
 * Sanitize a theme asset relative path.
 *
 * @param string $path Relative asset path.
 * @return string Sanitized relative path.
 */
function cmn_marketing_sanitize_asset_relative_path($path = '')
{
	$path = ltrim(str_replace('\\', '/', (string) $path), '/');

	if ($path === '') {
		return '';
	}

	$segments = explode('/', $path);
	$clean_segments = array();

	foreach ($segments as $segment) {
		if ($segment === '' || $segment === '.') {
			continue;
		}

		if ($segment === '..') {
			return '';
		}

		$clean_segments[] = sanitize_file_name($segment);
	}

	if (empty($clean_segments)) {
		return '';
	}

	return implode('/', $clean_segments);
}

/**
 * Return a local theme asset file path from /assets.
 *
 * @param string $path Relative asset path.
 * @return string
 */
function cmn_marketing_asset_file($path = '')
{
	$base_dir = trailingslashit(get_stylesheet_directory()) . 'assets/';
	$relative_path = cmn_marketing_sanitize_asset_relative_path($path);

	if ($relative_path === '') {
		return $base_dir;
	}

	return $base_dir . $relative_path;
}

/**
 * Return a safe theme asset URL from /assets.
 *
 * @param string $path Relative asset path.
 * @return string
 */
function cmn_marketing_asset_url($path = '')
{
	$base_uri = trailingslashit(get_stylesheet_directory_uri()) . 'assets/';
	$relative_path = cmn_marketing_sanitize_asset_relative_path($path);

	if ($relative_path === '') {
		return $base_uri;
	}

	return $base_uri . $relative_path;
}

/**
 * Resolve an asset path to a minified variant when available.
 *
 * @param string $path Relative asset path.
 * @return string
 */
function cmn_marketing_resolve_asset_path($path)
{
	$relative_path = cmn_marketing_sanitize_asset_relative_path($path);

	if ($relative_path === '') {
		return '';
	}

	$extension = strtolower(pathinfo($relative_path, PATHINFO_EXTENSION));
	if (!in_array($extension, array('css', 'js'), true)) {
		return $relative_path;
	}

	$minified_path = preg_replace('/\.' . preg_quote($extension, '/') . '$/i', '.min.' . $extension, $relative_path);
	if (!is_string($minified_path) || $minified_path === '' || $minified_path === $relative_path) {
		return $relative_path;
	}

	if (is_readable(cmn_marketing_asset_file($minified_path))) {
		return $minified_path;
	}

	return $relative_path;
}

/**
 * Return a cache-busting asset version fingerprint.
 *
 * @param string $path Relative asset path.
 * @param string $theme_version Theme version.
 * @return string
 */
function cmn_marketing_asset_version($path, $theme_version)
{
	$theme_version = is_string($theme_version) && $theme_version !== '' ? $theme_version : '1.0.0';
	$resolved_path = cmn_marketing_resolve_asset_path($path);

	if ($resolved_path === '') {
		return $theme_version;
	}

	$asset_file = cmn_marketing_asset_file($resolved_path);
	if (!is_readable($asset_file)) {
		return $theme_version;
	}

	$file_modified_time = filemtime($asset_file);
	if (!is_int($file_modified_time) || $file_modified_time <= 0) {
		return $theme_version;
	}

	return $theme_version . '.' . $file_modified_time;
}

/**
 * Theme setup.
 */
function cmn_marketing_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	register_nav_menus(
		array(
			'primary' => __('Primary Menu', 'cmn-marketing'),
			'footer'  => __('Footer Menu', 'cmn-marketing'),
		)
	);
}
add_action('after_setup_theme', 'cmn_marketing_setup');

/**
 * Return the brand name used across metadata and schema.
 *
 * @return string
 */
function cmn_marketing_brand_name()
{
	return 'CoverMeNow ONE';
}

/**
 * Get SEO definitions for page templates.
 *
 * @return array<string, array<string, string>>
 */
function cmn_marketing_get_seo_definitions()
{
	$brand_name = cmn_marketing_brand_name();

	return array(
		'home' => array(
			'label'       => 'Home',
			'title'       => 'Reliable Emergency Cover Infrastructure | ' . $brand_name,
			'description' => 'CoverMeNow ONE helps schools secure reliable emergency cover with transparent booking records, live availability visibility, and dedicated account support.',
		),
		'schools' => array(
			'label'       => 'Schools',
			'title'       => 'Schools Partner Programme & Infrastructure | ' . $brand_name,
			'description' => 'Explore how CoverMeNow ONE supports schools with same-day emergency focus, transparent booking logs, structured partner tiers, and accountable service delivery.',
		),
		'candidates' => array(
			'label'       => 'Candidates',
			'title'       => 'Candidate Rewards & Professional Standards | ' . $brand_name,
			'description' => 'Join CoverMeNow ONE as a candidate and access a structured, fair, reward-driven system with clear expectations, tier progression, and professional support.',
		),
		'services' => array(
			'label'       => 'Services',
			'title'       => 'Recruitment Infrastructure Services for Education | ' . $brand_name,
			'description' => 'Review the CMN ONE infrastructure modules including live availability, booking and chat logging, compliance support, reporting, and account management.',
		),
		'contact' => array(
			'label'       => 'Contact',
			'title'       => 'Contact CoverMeNow ONE',
			'description' => 'Contact CoverMeNow ONE to discuss school cover needs, candidate onboarding, platform services, and structured support from our operations team.',
		),
	);
}

/**
 * Get current SEO page key.
 *
 * @return string
 */
function cmn_marketing_get_seo_page_key()
{
	if (is_front_page() || is_page_template('page-templates/template-home.php')) {
		return 'home';
	}

	if (is_page_template('page-templates/template-schools.php') || is_page('schools')) {
		return 'schools';
	}

	if (is_page_template('page-templates/template-candidates.php') || is_page('candidates')) {
		return 'candidates';
	}

	if (is_page_template('page-templates/template-services.php') || is_page('services')) {
		return 'services';
	}

	if (is_page_template('page-templates/template-contact.php') || is_page('contact')) {
		return 'contact';
	}

	return '';
}

/**
 * Get current frontend page URL.
 *
 * @return string
 */
function cmn_marketing_get_current_page_url()
{
	if (is_singular()) {
		$permalink = get_permalink();
		if (is_string($permalink) && $permalink !== '') {
			return $permalink;
		}
	}

	return home_url('/');
}

/**
 * Get social image URL for Open Graph / Twitter.
 *
 * @return string
 */
function cmn_marketing_get_social_image_url()
{
	$candidate_paths = array(
		'img/og-default.jpg',
		'img/og-default.png',
		'img/og-default.webp',
		'img/og-default.svg',
		'img/hero-laptop.png',
	);

	foreach ($candidate_paths as $candidate_path) {
		if (is_readable(cmn_marketing_asset_file($candidate_path))) {
			return cmn_marketing_asset_url($candidate_path);
		}
	}

	$site_icon_url = get_site_icon_url(512);
	if (is_string($site_icon_url) && $site_icon_url !== '') {
		return $site_icon_url;
	}

	return home_url('/');
}

/**
 * Get SEO context for current request.
 *
 * @return array<string, string>
 */
function cmn_marketing_get_seo_context()
{
	$definitions = cmn_marketing_get_seo_definitions();
	$page_key = cmn_marketing_get_seo_page_key();

	$context = array(
		'key'         => $page_key,
		'label'       => '',
		'title'       => cmn_marketing_brand_name(),
		'description' => '',
		'url'         => cmn_marketing_get_current_page_url(),
		'image'       => cmn_marketing_get_social_image_url(),
	);

	if ($page_key !== '' && isset($definitions[$page_key])) {
		$definition = $definitions[$page_key];
		$context['label'] = (string) $definition['label'];
		$context['title'] = (string) $definition['title'];
		$context['description'] = (string) $definition['description'];
		return $context;
	}

	if (is_singular()) {
		$page_title = get_the_title();
		if (is_string($page_title) && $page_title !== '') {
			$context['title'] = $page_title . ' | ' . cmn_marketing_brand_name();
		}

		$excerpt = trim(wp_strip_all_tags(get_the_excerpt()));
		if ($excerpt !== '') {
			$context['description'] = $excerpt;
		}
	}

	if ($context['description'] === '') {
		$brand_tagline = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('brand_tagline', '') : '';
		$context['description'] = $brand_tagline !== '' ? $brand_tagline : 'CoverMeNow ONE marketing platform for structured school cover and candidate support.';
	}

	return $context;
}

/**
 * Filter document title with page-specific SEO titles.
 *
 * @param string $title Existing title.
 * @return string
 */
function cmn_marketing_filter_document_title($title)
{
	if (is_admin() || is_feed() || is_robots()) {
		return $title;
	}

	$context = cmn_marketing_get_seo_context();
	if ($context['key'] !== '' && $context['title'] !== '') {
		return $context['title'];
	}

	return $title;
}
add_filter('pre_get_document_title', 'cmn_marketing_filter_document_title');

/**
 * Output SEO meta tags and social tags.
 */
function cmn_marketing_print_meta_tags()
{
	if (is_admin() || is_feed() || is_robots()) {
		return;
	}

	$context = cmn_marketing_get_seo_context();
	$title = isset($context['title']) ? trim((string) $context['title']) : '';
	$description = isset($context['description']) ? trim((string) $context['description']) : '';
	$url = isset($context['url']) ? (string) $context['url'] : home_url('/');
	$image = isset($context['image']) ? (string) $context['image'] : '';
	$og_type = (isset($context['key']) && $context['key'] === 'home') ? 'website' : 'article';

	if ($description !== '') {
		echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
	}

	echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";

	if ($image !== '') {
		echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
	}

	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";

	if ($image !== '') {
		echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
	}
}
add_action('wp_head', 'cmn_marketing_print_meta_tags', 2);

/**
 * Build breadcrumb schema object.
 *
 * @param array<string, string> $context SEO context.
 * @return array<string, mixed>
 */
function cmn_marketing_get_breadcrumb_schema($context)
{
	$page_key = isset($context['key']) ? (string) $context['key'] : '';
	$current_label = isset($context['label']) ? (string) $context['label'] : '';
	$current_url = isset($context['url']) ? (string) $context['url'] : home_url('/');

	if ($page_key === '' || $current_label === '') {
		return array();
	}

	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Home',
			'item'     => home_url('/'),
		),
	);

	if ($page_key === 'home') {
		$items[0]['item'] = $current_url;
	} else {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => $current_label,
			'item'     => $current_url,
		);
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => $current_url . '#breadcrumb',
		'itemListElement' => $items,
	);
}

/**
 * Build FAQ schema object for pages that render FAQ sections.
 *
 * @param array<string, string> $context SEO context.
 * @return array<string, mixed>
 */
function cmn_marketing_get_faq_schema($context)
{
	$page_key = isset($context['key']) ? (string) $context['key'] : '';
	if (!in_array($page_key, array('schools', 'candidates', 'contact'), true)) {
		return array();
	}

	if (!function_exists('cmn_marketing_get_faq_groups')) {
		return array();
	}

	$faq_groups = cmn_marketing_get_faq_groups();
	if (!is_array($faq_groups) || empty($faq_groups)) {
		return array();
	}

	$entities = array();
	foreach ($faq_groups as $group) {
		$items = isset($group['items']) && is_array($group['items']) ? $group['items'] : array();
		foreach ($items as $item) {
			$question = isset($item['q']) ? trim((string) $item['q']) : '';
			$answer = isset($item['a']) ? trim((string) wp_strip_all_tags($item['a'])) : '';

			if ($question === '' || $answer === '') {
				continue;
			}

			$entities[] = array(
				'@type'          => 'Question',
				'name'           => $question,
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $answer,
				),
			);
		}
	}

	if (empty($entities)) {
		return array();
	}

	$current_url = isset($context['url']) ? (string) $context['url'] : home_url('/');
	return array(
		'@type'      => 'FAQPage',
		'@id'        => $current_url . '#faq',
		'mainEntity' => $entities,
	);
}

/**
 * Output JSON-LD schema graph.
 */
function cmn_marketing_print_schema_graph()
{
	if (is_admin() || is_feed() || is_robots()) {
		return;
	}

	$context = cmn_marketing_get_seo_context();
	$home_url = home_url('/');
	$brand_name = cmn_marketing_brand_name();
	$brand_tagline = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('brand_tagline', '') : '';
	$support_email = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('support_email', '') : '';
	$support_phone = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('support_phone', '') : '';
	$address = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('address', '') : '';
	$logo_url = cmn_marketing_get_social_image_url();

	$social_fields = array('social_linkedin', 'social_x', 'social_facebook', 'social_instagram');
	$same_as = array();
	foreach ($social_fields as $social_field) {
		$social_url = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting($social_field, '') : '';
		if (is_string($social_url) && $social_url !== '') {
			$same_as[] = $social_url;
		}
	}

	$organization = array(
		'@type' => 'Organization',
		'@id'   => $home_url . '#organization',
		'name'  => $brand_name,
		'url'   => $home_url,
	);

	if ($logo_url !== '') {
		$organization['logo'] = $logo_url;
	}

	if ($support_email !== '') {
		$organization['email'] = $support_email;
	}

	if ($support_phone !== '') {
		$organization['telephone'] = $support_phone;
		$organization['contactPoint'] = array(
			array(
				'@type'       => 'ContactPoint',
				'contactType' => 'customer support',
				'telephone'   => $support_phone,
				'email'       => $support_email,
			),
		);
	}

	if ($address !== '') {
		$organization['address'] = array(
			'@type'         => 'PostalAddress',
			'streetAddress' => $address,
		);
	}

	if (!empty($same_as)) {
		$organization['sameAs'] = array_values(array_unique($same_as));
	}

	$website = array(
		'@type'       => 'WebSite',
		'@id'         => $home_url . '#website',
		'url'         => $home_url,
		'name'        => $brand_name,
		'description' => $brand_tagline,
		'publisher'   => array(
			'@id' => $home_url . '#organization',
		),
	);

	$graph = array($website, $organization);

	$breadcrumb = cmn_marketing_get_breadcrumb_schema($context);
	if (!empty($breadcrumb)) {
		$graph[] = $breadcrumb;
	}

	$faq_schema = cmn_marketing_get_faq_schema($context);
	if (!empty($faq_schema)) {
		$graph[] = $faq_schema;
	}

	$payload = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo '<script type="application/ld+json">' . wp_json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'cmn_marketing_print_schema_graph', 25);

/**
 * Register sitemap.xml rewrite rule.
 */
function cmn_marketing_register_sitemap_rewrite()
{
	add_rewrite_rule('^sitemap\.xml$', 'index.php?cmn_marketing_sitemap=1', 'top');
}
add_action('init', 'cmn_marketing_register_sitemap_rewrite');

/**
 * Register sitemap query var.
 *
 * @param array<int, string> $vars Query vars.
 * @return array<int, string>
 */
function cmn_marketing_register_sitemap_query_var($vars)
{
	$vars[] = 'cmn_marketing_sitemap';

	return $vars;
}
add_filter('query_vars', 'cmn_marketing_register_sitemap_query_var');

/**
 * Flush rewrite rules on theme switch to activate sitemap route.
 */
function cmn_marketing_flush_rewrites_on_switch()
{
	cmn_marketing_register_sitemap_rewrite();
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'cmn_marketing_flush_rewrites_on_switch');

/**
 * Ensure sitemap rewrite is flushed once after theme updates.
 */
function cmn_marketing_maybe_flush_rewrites_once()
{
	$rewrite_version = 'cmn-marketing-sitemap-v1';
	$stored_version = get_option('cmn_marketing_rewrite_version', '');

	if ($stored_version === $rewrite_version) {
		return;
	}

	cmn_marketing_register_sitemap_rewrite();
	flush_rewrite_rules(false);
	update_option('cmn_marketing_rewrite_version', $rewrite_version, false);
}
add_action('init', 'cmn_marketing_maybe_flush_rewrites_once', 20);

/**
 * Render sitemap.xml output.
 */
function cmn_marketing_render_sitemap()
{
	$sitemap_query = (string) get_query_var('cmn_marketing_sitemap', '');
	if ($sitemap_query !== '1') {
		return;
	}

	$entries = array();
	$entries[home_url('/')] = array(
		'loc'     => home_url('/'),
		'lastmod' => gmdate('c'),
	);

	$pages = get_pages(
		array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'sort_column' => 'post_modified_gmt',
			'sort_order'  => 'DESC',
		)
	);

	foreach ($pages as $page) {
		$page_url = get_permalink($page->ID);
		if (!is_string($page_url) || $page_url === '') {
			continue;
		}

		$modified = get_post_modified_time('c', true, $page);
		if (!is_string($modified) || $modified === '') {
			$modified = gmdate('c');
		}

		$entries[$page_url] = array(
			'loc'     => $page_url,
			'lastmod' => $modified,
		);
	}

	nocache_headers();
	header('Content-Type: application/xml; charset=utf-8');

	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	foreach ($entries as $entry) {
		$loc = isset($entry['loc']) ? (string) $entry['loc'] : '';
		$lastmod = isset($entry['lastmod']) ? (string) $entry['lastmod'] : '';
		if ($loc === '') {
			continue;
		}

		echo "\t" . '<url>' . "\n";
		echo "\t\t" . '<loc>' . esc_url($loc) . '</loc>' . "\n";
		if ($lastmod !== '') {
			echo "\t\t" . '<lastmod>' . esc_html($lastmod) . '</lastmod>' . "\n";
		}
		echo "\t" . '</url>' . "\n";
	}

	echo '</urlset>';
	exit;
}
add_action('template_redirect', 'cmn_marketing_render_sitemap');

/**
 * Add resource hints for external fonts.
 *
 * @param array<int, mixed> $urls Hint URLs.
 * @param string            $relation_type Hint relation type.
 * @return array<int, mixed>
 */
function cmn_marketing_resource_hints($urls, $relation_type)
{
	if ($relation_type === 'preconnect') {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	if ($relation_type === 'dns-prefetch') {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = 'https://fonts.gstatic.com';
	}

	return $urls;
}
add_filter('wp_resource_hints', 'cmn_marketing_resource_hints', 10, 2);

/**
 * Print minimal critical CSS for first paint.
 */
function cmn_marketing_print_critical_css()
{
	$critical_css = 'html,body{margin:0;min-height:100%;background:#0b0c10;color:#e7e9ee;font-family:Outfit,sans-serif}body{line-height:1.6}main{display:block}.cmn-site-header{position:sticky;top:0;z-index:120;border-bottom:1px solid rgba(255,255,255,.08);background:rgba(20,22,28,.9)}.cmn-site-header__inner{min-height:80px;display:flex;align-items:center}.cmn-container{width:100%;max-width:1200px;margin-inline:auto;padding-inline:clamp(1rem,2.6vw,2rem)}';
	echo '<style id="cmn-marketing-critical-css">' . $critical_css . '</style>';
}
add_action('wp_head', 'cmn_marketing_print_critical_css', 1);

/**
 * Add cache-control hints to public frontend responses.
 *
 * @param array<string, string> $headers Response headers.
 * @return array<string, string>
 */
function cmn_marketing_add_cache_headers($headers)
{
	if (is_admin() || is_user_logged_in()) {
		return $headers;
	}

	$request_method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper((string) $_SERVER['REQUEST_METHOD']) : 'GET';
	if ($request_method !== 'GET') {
		return $headers;
	}

	$headers['Cache-Control'] = 'public, max-age=300, stale-while-revalidate=600';
	$headers['Vary'] = 'Accept-Encoding';

	if (isset($headers['Pragma'])) {
		unset($headers['Pragma']);
	}

	return $headers;
}
add_filter('wp_headers', 'cmn_marketing_add_cache_headers');

/**
 * Build responsive image data from local theme assets.
 *
 * @param string          $relative_path Relative image path under /assets.
 * @param array<int, int> $widths Target widths.
 * @return array<string, mixed>
 */
function cmn_marketing_get_responsive_image_data($relative_path, $widths = array(480, 768, 1200, 1920))
{
	$relative_path = cmn_marketing_sanitize_asset_relative_path($relative_path);
	if ($relative_path === '') {
		return array();
	}

	$image_info = pathinfo($relative_path);
	$base_name = isset($image_info['filename']) ? (string) $image_info['filename'] : '';
	$extension = isset($image_info['extension']) ? strtolower((string) $image_info['extension']) : '';
	$directory = isset($image_info['dirname']) && $image_info['dirname'] !== '.' ? $image_info['dirname'] . '/' : '';

	if ($base_name === '' || $extension === '') {
		return array();
	}

	$source_path = $directory . $base_name . '.' . $extension;
	$source_file = cmn_marketing_asset_file($source_path);
	if (!is_readable($source_file)) {
		return array();
	}

	$widths = array_filter(array_map('intval', $widths), static function ($width) {
		return $width > 0;
	});
	$widths = array_values(array_unique($widths));
	sort($widths, SORT_NUMERIC);

	$build_srcset = static function ($format) use ($directory, $base_name, $widths) {
		$entries = array();

		foreach ($widths as $width) {
			$candidate_path = $directory . $base_name . '-' . $width . '.' . $format;
			$candidate_file = cmn_marketing_asset_file($candidate_path);
			if (is_readable($candidate_file)) {
				$entries[$width] = cmn_marketing_asset_url($candidate_path) . ' ' . $width . 'w';
			}
		}

		$original_path = $directory . $base_name . '.' . $format;
		$original_file = cmn_marketing_asset_file($original_path);
		if (is_readable($original_file)) {
			$size_data = @getimagesize($original_file);
			$original_width = is_array($size_data) && isset($size_data[0]) ? (int) $size_data[0] : 0;
			if ($original_width > 0) {
				$entries[$original_width] = cmn_marketing_asset_url($original_path) . ' ' . $original_width . 'w';
			}
		}

		if (empty($entries)) {
			return '';
		}

		ksort($entries, SORT_NUMERIC);
		return implode(', ', array_values($entries));
	};

	$size_data = @getimagesize($source_file);
	$source_width = is_array($size_data) && isset($size_data[0]) ? (int) $size_data[0] : 0;
	$source_height = is_array($size_data) && isset($size_data[1]) ? (int) $size_data[1] : 0;

	return array(
		'src'         => cmn_marketing_asset_url($source_path),
		'srcset'      => $build_srcset($extension),
		'webp_srcset' => $build_srcset('webp'),
		'width'       => $source_width,
		'height'      => $source_height,
	);
}

/**
 * Generate responsive hero image derivatives when source image exists.
 */
function cmn_marketing_generate_responsive_images()
{
	if (!function_exists('wp_get_image_editor')) {
		return;
	}

	$source_relative = 'img/hero-laptop.png';
	$source_file = cmn_marketing_asset_file($source_relative);
	if (!is_readable($source_file)) {
		return;
	}

	$source_mtime = filemtime($source_file);
	if (!is_int($source_mtime) || $source_mtime <= 0) {
		return;
	}

	$signature = md5($source_relative . ':' . $source_mtime);
	$stored_signature = get_option('cmn_marketing_image_signature', '');
	if ($stored_signature === $signature) {
		return;
	}

	$widths = array(480, 768, 1200, 1920);
	foreach ($widths as $width) {
		$png_target = cmn_marketing_asset_file('img/hero-laptop-' . $width . '.png');
		if (!is_readable($png_target)) {
			$png_editor = wp_get_image_editor($source_file);
			if (!is_wp_error($png_editor)) {
				$png_editor->resize($width, null, false);
				$png_editor->save($png_target, 'image/png');
			}
		}

		$webp_target = cmn_marketing_asset_file('img/hero-laptop-' . $width . '.webp');
		if (!is_readable($webp_target)) {
			$webp_editor = wp_get_image_editor($source_file);
			if (!is_wp_error($webp_editor)) {
				$webp_editor->resize($width, null, false);
				$webp_editor->save($webp_target, 'image/webp');
			}
		}
	}

	update_option('cmn_marketing_image_signature', $signature, false);
}
add_action('after_switch_theme', 'cmn_marketing_generate_responsive_images');
add_action('admin_init', 'cmn_marketing_generate_responsive_images');

/**
 * Enqueue theme assets.
 */
function cmn_marketing_enqueue_assets()
{
	$theme_version = (string) wp_get_theme()->get('Version');
	$app_css = cmn_marketing_resolve_asset_path('css/app.css');
	$faq_css = cmn_marketing_resolve_asset_path('css/faq.css');
	$home_css = cmn_marketing_resolve_asset_path('css/home.css');
	$schools_css = cmn_marketing_resolve_asset_path('css/schools.css');
	$candidates_css = cmn_marketing_resolve_asset_path('css/candidates.css');
	$services_css = cmn_marketing_resolve_asset_path('css/services.css');
	$contact_css = cmn_marketing_resolve_asset_path('css/contact.css');
	$app_js = cmn_marketing_resolve_asset_path('js/app.js');

	$style_file = trailingslashit(get_stylesheet_directory()) . 'style.css';
	$style_version = $theme_version;
	$style_mtime = is_readable($style_file) ? filemtime($style_file) : false;
	if (is_int($style_mtime) && $style_mtime > 0) {
		$style_version .= '.' . $style_mtime;
	}

	wp_enqueue_style(
		'cmn-marketing-fonts',
		'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'cmn-marketing-app',
		cmn_marketing_asset_url($app_css),
		array('cmn-marketing-fonts'),
		cmn_marketing_asset_version($app_css, $theme_version)
	);

	wp_enqueue_style(
		'cmn-marketing-style',
		get_stylesheet_uri(),
		array('cmn-marketing-app'),
		$style_version
	);

	wp_enqueue_style(
		'cmn-marketing-faq',
		cmn_marketing_asset_url($faq_css),
		array('cmn-marketing-style'),
		cmn_marketing_asset_version($faq_css, $theme_version)
	);

	if (is_page_template('page-templates/template-home.php')) {
		wp_enqueue_style(
			'cmn-marketing-home',
			cmn_marketing_asset_url($home_css),
			array('cmn-marketing-faq'),
			cmn_marketing_asset_version($home_css, $theme_version)
		);
	}

	if (is_page_template('page-templates/template-schools.php')) {
		wp_enqueue_style(
			'cmn-marketing-schools',
			cmn_marketing_asset_url($schools_css),
			array('cmn-marketing-faq'),
			cmn_marketing_asset_version($schools_css, $theme_version)
		);
	}

	if (is_page_template('page-templates/template-candidates.php')) {
		wp_enqueue_style(
			'cmn-marketing-candidates',
			cmn_marketing_asset_url($candidates_css),
			array('cmn-marketing-faq'),
			cmn_marketing_asset_version($candidates_css, $theme_version)
		);
	}

	if (is_page_template('page-templates/template-services.php')) {
		wp_enqueue_style(
			'cmn-marketing-services',
			cmn_marketing_asset_url($services_css),
			array('cmn-marketing-faq'),
			cmn_marketing_asset_version($services_css, $theme_version)
		);
	}

	if (is_page_template('page-templates/template-contact.php')) {
		wp_enqueue_style(
			'cmn-marketing-contact',
			cmn_marketing_asset_url($contact_css),
			array('cmn-marketing-faq'),
			cmn_marketing_asset_version($contact_css, $theme_version)
		);
	}

	wp_enqueue_script(
		'cmn-marketing-app',
		cmn_marketing_asset_url($app_js),
		array(),
		cmn_marketing_asset_version($app_js, $theme_version),
		true
	);
	wp_script_add_data('cmn-marketing-app', 'strategy', 'defer');
	wp_script_add_data('cmn-marketing-app', 'defer', true);
}
add_action('wp_enqueue_scripts', 'cmn_marketing_enqueue_assets');

/**
 * Return the contact submissions table name.
 *
 * @return string
 */
function cmn_marketing_contact_table_name()
{
	global $wpdb;

	return $wpdb->prefix . 'cmn_contact_submissions';
}

/**
 * Create or update the contact submissions table.
 */
function cmn_marketing_maybe_create_contact_table()
{
	global $wpdb;

	$table_name = cmn_marketing_contact_table_name();
	$table_version = '1.0';
	$installed_version = get_option('cmn_marketing_contact_table_version', '');
	$table_exists = $wpdb->get_var(
		$wpdb->prepare('SHOW TABLES LIKE %s', $table_name)
	);

	if ($installed_version === $table_version && $table_exists === $table_name) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE {$table_name} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		name varchar(190) NOT NULL,
		email varchar(190) NOT NULL,
		role varchar(50) NOT NULL DEFAULT 'Other',
		subject varchar(255) NOT NULL DEFAULT '',
		message longtext NOT NULL,
		ip_address varchar(100) NOT NULL DEFAULT '',
		user_agent text NOT NULL,
		created_at datetime NOT NULL,
		PRIMARY KEY (id),
		KEY email (email),
		KEY created_at (created_at)
	) {$charset_collate};";

	dbDelta($sql);
	update_option('cmn_marketing_contact_table_version', $table_version);
}
add_action('init', 'cmn_marketing_maybe_create_contact_table');

/**
 * Build a safe redirect URL for contact form responses.
 *
 * @param string $status Status query arg value.
 */
function cmn_marketing_contact_redirect($status)
{
	$fallback_url = home_url('/contact/');
	$redirect_target = isset($_POST['redirect_to']) ? wp_unslash($_POST['redirect_to']) : $fallback_url;
	if (!is_string($redirect_target) || $redirect_target === '') {
		$redirect_target = $fallback_url;
	}
	$redirect_url = wp_validate_redirect($redirect_target, $fallback_url);
	$redirect_url = add_query_arg('cmn_contact_status', sanitize_key($status), $redirect_url);

	wp_safe_redirect($redirect_url . '#cmn-contact-form');
	exit;
}

/**
 * Handle contact form submission.
 */
function cmn_marketing_handle_contact_submission()
{
	if (!isset($_SERVER['REQUEST_METHOD']) || strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
		cmn_marketing_contact_redirect('post_error');
	}

	$nonce = isset($_POST['cmn_contact_nonce']) ? sanitize_text_field(wp_unslash($_POST['cmn_contact_nonce'])) : '';
	if ($nonce === '' || !wp_verify_nonce($nonce, 'cmn_contact_submit')) {
		cmn_marketing_contact_redirect('invalid_nonce');
	}

	$honeypot = isset($_POST['cmn_website']) ? trim((string) wp_unslash($_POST['cmn_website'])) : '';
	if ($honeypot !== '') {
		cmn_marketing_contact_redirect('spam');
	}

	$name = isset($_POST['cmn_name']) ? sanitize_text_field(wp_unslash($_POST['cmn_name'])) : '';
	$email = isset($_POST['cmn_email']) ? sanitize_email(wp_unslash($_POST['cmn_email'])) : '';
	$role = isset($_POST['cmn_role']) ? sanitize_text_field(wp_unslash($_POST['cmn_role'])) : 'Other';
	$subject = isset($_POST['cmn_subject']) ? sanitize_text_field(wp_unslash($_POST['cmn_subject'])) : '';
	$message = isset($_POST['cmn_message']) ? wp_kses_post(wp_unslash($_POST['cmn_message'])) : '';
	$message_plain = trim(wp_strip_all_tags($message));

	$allowed_roles = array('School', 'Candidate', 'Other');
	if (!in_array($role, $allowed_roles, true)) {
		$role = 'Other';
	}

	if ($name === '' || $email === '' || $message_plain === '') {
		cmn_marketing_contact_redirect('required');
	}

	if (!is_email($email)) {
		cmn_marketing_contact_redirect('invalid_email');
	}

	$ip_address = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
	$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';

	global $wpdb;
	$inserted = $wpdb->insert(
		cmn_marketing_contact_table_name(),
		array(
			'name'       => $name,
			'email'      => $email,
			'role'       => $role,
			'subject'    => $subject,
			'message'    => $message,
			'ip_address' => $ip_address,
			'user_agent' => $user_agent,
			'created_at' => current_time('mysql'),
		),
		array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
	);

	if ($inserted === false) {
		cmn_marketing_contact_redirect('db_error');
	}

	$notification_subject = $subject !== '' ? $subject : 'Contact form submission';
	$notification_body = "A new contact form submission was received.\n\n";
	$notification_body .= "Name: {$name}\n";
	$notification_body .= "Email: {$email}\n";
	$notification_body .= "Role: {$role}\n";
	$notification_body .= "Subject: " . ($subject !== '' ? $subject : 'N/A') . "\n";
	$notification_body .= "IP Address: {$ip_address}\n";
	$notification_body .= "User Agent: {$user_agent}\n";
	$notification_body .= "Submitted: " . current_time('mysql') . "\n\n";
	$notification_body .= "Message:\n{$message_plain}\n";

	$support_recipient = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('support_email', 'support@covermenow.co.uk') : 'support@covermenow.co.uk';
	if (!is_email($support_recipient)) {
		$support_recipient = 'support@covermenow.co.uk';
	}

	$notification_sent = wp_mail(
		$support_recipient,
		'[CMN Contact] ' . $notification_subject,
		$notification_body,
		array(
			'Content-Type: text/plain; charset=UTF-8',
			'Reply-To: ' . $name . ' <' . $email . '>',
		)
	);

	$confirmation_subject = 'We received your message - CoverMeNow ONE';
	$confirmation_body = "Hi {$name},\n\n";
	$confirmation_body .= "Thank you for contacting CoverMeNow ONE.\n";
	$confirmation_body .= "A member of our team will review your message and reply shortly.\n\n";
	$confirmation_body .= "Regards,\nCoverMeNow ONE";

	$confirmation_sent = wp_mail(
		$email,
		$confirmation_subject,
		$confirmation_body,
		array('Content-Type: text/plain; charset=UTF-8')
	);

	if (!$notification_sent || !$confirmation_sent) {
		cmn_marketing_contact_redirect('mail_error');
	}

	cmn_marketing_contact_redirect('success');
}
add_action('admin_post_cmn_contact_submit', 'cmn_marketing_handle_contact_submission');
add_action('admin_post_nopriv_cmn_contact_submit', 'cmn_marketing_handle_contact_submission');
