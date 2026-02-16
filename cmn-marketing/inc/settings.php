<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Default schools partner tiers.
 *
 * @return array<int, array<string, mixed>>
 */
function cmn_marketing_default_schools_tiers()
{
	return array(
		array(
			'name'        => 'Bronze',
			'metric'      => '5% Loyalty Credit',
			'description' => 'Entry tier for partner schools beginning structured usage.',
			'benefits'    => array(
				'Priority emergency request queueing.',
				'Monthly service summary snapshot.',
				'Dedicated onboarding touchpoint.',
			),
		),
		array(
			'name'        => 'Silver',
			'metric'      => '10% Loyalty Credit',
			'description' => 'For consistent schools requiring greater day-to-day continuity.',
			'benefits'    => array(
				'Enhanced response prioritisation.',
				'Expanded booking visibility reports.',
				'Quarterly account planning review.',
			),
		),
		array(
			'name'        => 'Gold',
			'metric'      => '1.25x Reward Multiplier',
			'description' => 'Strategic tier for schools with higher operational demand.',
			'benefits'    => array(
				'Accelerated emergency escalation path.',
				'Customised service quality dashboard.',
				'Named senior account oversight.',
			),
		),
		array(
			'name'        => 'Elite',
			'metric'      => '1.50x Reward Multiplier',
			'description' => 'Top tier for multi-site and high-frequency partner operations.',
			'benefits'    => array(
				'Highest priority emergency allocation.',
				'Advanced transparency reporting suite.',
				'Executive service continuity planning.',
			),
		),
	);
}

/**
 * Default candidate reward tiers.
 *
 * @return array<int, array<string, mixed>>
 */
function cmn_marketing_default_candidate_tiers()
{
	return array(
		array(
			'name'        => 'Standard',
			'metric'      => 'Base Reward Access',
			'description' => 'Starting tier for professionals completing core reliability requirements.',
			'benefits'    => array(
				'Access to baseline reward pathways.',
				'Eligibility for role consistency tracking.',
				'Foundational support and feedback loops.',
			),
		),
		array(
			'name'        => 'Silver',
			'metric'      => '1.15x Reward Multiplier',
			'description' => 'Mid tier for sustained availability and dependable shift completion.',
			'benefits'    => array(
				'Enhanced reward weighting on qualifying work.',
				'Priority visibility for matching opportunities.',
				'Expanded candidate development resources.',
			),
		),
		array(
			'name'        => 'Elite',
			'metric'      => '1.35x Reward Multiplier',
			'description' => 'Top tier for high-trust professionals with strong delivery records.',
			'benefits'    => array(
				'Highest reward multiplier eligibility.',
				'Fast-track consideration for urgent assignments.',
				'Named account guidance for growth planning.',
			),
		),
	);
}

/**
 * Default theme settings.
 *
 * @return array<string, mixed>
 */
function cmn_marketing_default_settings()
{
	return array(
		'support_email'       => 'support@covermenow.co.uk',
		'support_phone'       => '+44 0000 000000',
		'office_hours'        => 'Mon-Fri, 08:00-18:00',
		'address'             => '',
		'primary_cta_label'   => 'Book a Demo',
		'primary_cta_url'     => home_url('/contact/'),
		'secondary_cta_label' => 'Learn More',
		'secondary_cta_url'   => home_url('/services/'),
		'social_linkedin'     => '',
		'social_x'            => '',
		'social_facebook'     => '',
		'social_instagram'    => '',
		'brand_tagline'       => 'Premium safeguarding infrastructure for schools and candidates.',
		'schools_tiers'       => cmn_marketing_default_schools_tiers(),
		'candidate_tiers'     => cmn_marketing_default_candidate_tiers(),
		'faqs'                => array(),
	);
}

/**
 * Sanitize a single settings value by key.
 *
 * @param string $key Setting key.
 * @param mixed  $value Setting value.
 * @return string
 */
function cmn_marketing_sanitize_setting_value($key, $value)
{
	$value = is_scalar($value) ? (string) $value : '';

	switch ($key) {
		case 'support_email':
			return sanitize_email($value);
		case 'address':
			return sanitize_textarea_field($value);
		case 'primary_cta_url':
		case 'secondary_cta_url':
		case 'social_linkedin':
		case 'social_x':
		case 'social_facebook':
		case 'social_instagram':
			return esc_url_raw($value);
		default:
			return sanitize_text_field($value);
	}
}

/**
 * Sanitize a tier entry.
 *
 * @param mixed $tier Raw tier payload.
 * @return array<string, mixed>
 */
function cmn_marketing_sanitize_tier($tier)
{
	$tier = is_array($tier) ? $tier : array();
	$benefits_raw = isset($tier['benefits']) && is_array($tier['benefits']) ? array_values($tier['benefits']) : array();
	$benefits = array();

	for ($i = 0; $i < 3; $i++) {
		$benefit_value = isset($benefits_raw[$i]) ? $benefits_raw[$i] : '';
		$benefits[$i] = sanitize_text_field(is_scalar($benefit_value) ? (string) $benefit_value : '');
	}

	$name_value = isset($tier['name']) ? $tier['name'] : '';
	$metric_value = isset($tier['metric']) ? $tier['metric'] : '';
	$description_value = isset($tier['description']) ? $tier['description'] : '';

	return array(
		'name'        => sanitize_text_field(is_scalar($name_value) ? (string) $name_value : ''),
		'metric'      => sanitize_text_field(is_scalar($metric_value) ? (string) $metric_value : ''),
		'description' => sanitize_text_field(is_scalar($description_value) ? (string) $description_value : ''),
		'benefits'    => $benefits,
	);
}

/**
 * Check whether a tier contains any user-provided content.
 *
 * @param array<string, mixed> $tier Tier payload.
 * @return bool
 */
function cmn_marketing_tier_has_content($tier)
{
	if (!is_array($tier)) {
		return false;
	}

	if ((isset($tier['name']) && $tier['name'] !== '') || (isset($tier['metric']) && $tier['metric'] !== '') || (isset($tier['description']) && $tier['description'] !== '')) {
		return true;
	}

	$benefits = isset($tier['benefits']) && is_array($tier['benefits']) ? $tier['benefits'] : array();
	foreach ($benefits as $benefit) {
		if (is_scalar($benefit) && sanitize_text_field((string) $benefit) !== '') {
			return true;
		}
	}

	return false;
}

/**
 * Sanitize a tier collection with fallback support.
 *
 * @param mixed                                  $tiers Raw tiers.
 * @param int                                    $max Maximum allowed tiers.
 * @param array<int, array<string, mixed>>       $fallback_tiers Defaults.
 * @return array<int, array<string, mixed>>
 */
function cmn_marketing_sanitize_tiers($tiers, $max, $fallback_tiers)
{
	$max = max(0, (int) $max);
	$tiers = is_array($tiers) ? array_values($tiers) : array();
	$sanitized = array();

	foreach ($tiers as $raw_tier) {
		if (count($sanitized) >= $max) {
			break;
		}

		$clean_tier = cmn_marketing_sanitize_tier($raw_tier);
		if (cmn_marketing_tier_has_content($clean_tier)) {
			$sanitized[] = $clean_tier;
		}
	}

	if (empty($sanitized)) {
		$fallback_tiers = is_array($fallback_tiers) ? array_values($fallback_tiers) : array();
		foreach ($fallback_tiers as $fallback_tier) {
			if (count($sanitized) >= $max) {
				break;
			}
			$sanitized[] = cmn_marketing_sanitize_tier($fallback_tier);
		}
	}

	return array_slice($sanitized, 0, $max);
}

/**
 * Sanitize a single FAQ item.
 *
 * @param mixed $item Raw FAQ item payload.
 * @return array<string, string>
 */
function cmn_marketing_sanitize_faq_item($item)
{
	$item = is_array($item) ? $item : array();
	$question_raw = isset($item['q']) ? $item['q'] : '';
	$answer_raw = isset($item['a']) ? $item['a'] : '';

	return array(
		'q' => sanitize_text_field(is_scalar($question_raw) ? (string) $question_raw : ''),
		'a' => wp_kses_post(is_scalar($answer_raw) ? (string) $answer_raw : ''),
	);
}

/**
 * Determine if an FAQ item has meaningful content.
 *
 * @param array<string, string> $item FAQ item payload.
 * @return bool
 */
function cmn_marketing_faq_item_has_content($item)
{
	if (!is_array($item)) {
		return false;
	}

	$question = isset($item['q']) ? trim((string) $item['q']) : '';
	$answer = isset($item['a']) ? trim(wp_strip_all_tags((string) $item['a'])) : '';

	return ($question !== '' && $answer !== '');
}

/**
 * Sanitize a single FAQ group.
 *
 * @param mixed $group Raw FAQ group payload.
 * @param int   $max_items Maximum FAQ items per group.
 * @return array<string, mixed>
 */
function cmn_marketing_sanitize_faq_group($group, $max_items)
{
	$group = is_array($group) ? $group : array();
	$title_raw = isset($group['title']) ? $group['title'] : '';
	$items_raw = isset($group['items']) && is_array($group['items']) ? array_values($group['items']) : array();
	$items = array();

	$max_items = max(0, (int) $max_items);
	foreach ($items_raw as $item) {
		if (count($items) >= $max_items) {
			break;
		}

		$clean_item = cmn_marketing_sanitize_faq_item($item);
		if (cmn_marketing_faq_item_has_content($clean_item)) {
			$items[] = $clean_item;
		}
	}

	return array(
		'title' => sanitize_text_field(is_scalar($title_raw) ? (string) $title_raw : ''),
		'items' => $items,
	);
}

/**
 * Determine if an FAQ group has meaningful content.
 *
 * @param array<string, mixed> $group FAQ group payload.
 * @return bool
 */
function cmn_marketing_faq_group_has_content($group)
{
	if (!is_array($group)) {
		return false;
	}

	$items = isset($group['items']) && is_array($group['items']) ? $group['items'] : array();

	return !empty($items);
}

/**
 * Sanitize FAQ groups collection.
 *
 * @param mixed $groups Raw FAQ groups.
 * @param int   $max_groups Maximum FAQ groups.
 * @param int   $max_items Maximum FAQ items per group.
 * @return array<int, array<string, mixed>>
 */
function cmn_marketing_sanitize_faq_groups($groups, $max_groups, $max_items)
{
	$groups = is_array($groups) ? array_values($groups) : array();
	$max_groups = max(0, (int) $max_groups);
	$max_items = max(0, (int) $max_items);
	$sanitized = array();

	foreach ($groups as $group) {
		if (count($sanitized) >= $max_groups) {
			break;
		}

		$clean_group = cmn_marketing_sanitize_faq_group($group, $max_items);
		if (cmn_marketing_faq_group_has_content($clean_group)) {
			$sanitized[] = $clean_group;
		}
	}

	return $sanitized;
}

/**
 * Sanitize settings payload.
 *
 * @param mixed $settings Raw settings array.
 * @return array<string, mixed>
 */
function cmn_marketing_sanitize_settings($settings)
{
	$defaults = cmn_marketing_default_settings();
	$settings = is_array($settings) ? $settings : array();
	$sanitized = array();

	foreach ($defaults as $key => $default_value) {
		if ($key === 'schools_tiers') {
			$raw_tiers = isset($settings[$key]) ? $settings[$key] : array();
			$sanitized[$key] = cmn_marketing_sanitize_tiers($raw_tiers, 4, cmn_marketing_default_schools_tiers());
			continue;
		}

		if ($key === 'candidate_tiers') {
			$raw_tiers = isset($settings[$key]) ? $settings[$key] : array();
			$sanitized[$key] = cmn_marketing_sanitize_tiers($raw_tiers, 3, cmn_marketing_default_candidate_tiers());
			continue;
		}

		if ($key === 'faqs') {
			$raw_groups = isset($settings[$key]) ? $settings[$key] : array();
			$sanitized[$key] = cmn_marketing_sanitize_faq_groups($raw_groups, 6, 8);
			continue;
		}

		$raw_value = array_key_exists($key, $settings) ? $settings[$key] : $default_value;
		$clean_value = cmn_marketing_sanitize_setting_value($key, $raw_value);

		if ($clean_value === '' && in_array($key, array('support_email', 'primary_cta_label', 'primary_cta_url'), true)) {
			$clean_value = cmn_marketing_sanitize_setting_value($key, $default_value);
		}

		$sanitized[$key] = $clean_value;
	}

	return $sanitized;
}

/**
 * Get all settings with defaults.
 *
 * @return array<string, mixed>
 */
function cmn_marketing_get_settings()
{
	$stored = get_option('cmn_marketing_settings', array());

	return cmn_marketing_sanitize_settings($stored);
}

/**
 * Get a single setting by key.
 *
 * @param string $key Setting key.
 * @param mixed  $default Default value.
 * @return string
 */
function cmn_marketing_get_setting($key, $default = '')
{
	$settings = cmn_marketing_get_settings();

	if (!array_key_exists($key, $settings) || is_array($settings[$key]) || $settings[$key] === '') {
		return cmn_marketing_sanitize_setting_value($key, $default);
	}

	return cmn_marketing_sanitize_setting_value($key, $settings[$key]);
}

/**
 * Get schools tiers with fallback and max limit.
 *
 * @return array<int, array<string, mixed>>
 */
function cmn_marketing_get_schools_tiers()
{
	$settings = cmn_marketing_get_settings();
	$tiers = isset($settings['schools_tiers']) ? $settings['schools_tiers'] : array();

	return cmn_marketing_sanitize_tiers($tiers, 4, cmn_marketing_default_schools_tiers());
}

/**
 * Get candidate tiers with fallback and max limit.
 *
 * @return array<int, array<string, mixed>>
 */
function cmn_marketing_get_candidate_tiers()
{
	$settings = cmn_marketing_get_settings();
	$tiers = isset($settings['candidate_tiers']) ? $settings['candidate_tiers'] : array();

	return cmn_marketing_sanitize_tiers($tiers, 3, cmn_marketing_default_candidate_tiers());
}

/**
 * Get FAQ groups.
 *
 * @return array<int, array<string, mixed>>
 */
function cmn_marketing_get_faq_groups()
{
	$settings = cmn_marketing_get_settings();
	$groups = isset($settings['faqs']) ? $settings['faqs'] : array();

	return cmn_marketing_sanitize_faq_groups($groups, 6, 8);
}

/**
 * Field metadata for scalar settings sections.
 *
 * @return array<string, array<string, mixed>>
 */
function cmn_marketing_settings_sections()
{
	return array(
		'global_contact' => array(
			'title'  => __('Global Contact Info', 'cmn-marketing'),
			'fields' => array(
				'support_email' => array('label' => __('Support Email', 'cmn-marketing'), 'type' => 'email'),
				'support_phone' => array('label' => __('Support Phone', 'cmn-marketing'), 'type' => 'text'),
				'office_hours'  => array('label' => __('Office Hours', 'cmn-marketing'), 'type' => 'text'),
				'address'       => array('label' => __('Address', 'cmn-marketing'), 'type' => 'textarea'),
			),
		),
		'global_cta' => array(
			'title'  => __('Global CTAs', 'cmn-marketing'),
			'fields' => array(
				'primary_cta_label'   => array('label' => __('Primary CTA Label', 'cmn-marketing'), 'type' => 'text'),
				'primary_cta_url'     => array('label' => __('Primary CTA URL', 'cmn-marketing'), 'type' => 'url'),
				'secondary_cta_label' => array('label' => __('Secondary CTA Label', 'cmn-marketing'), 'type' => 'text'),
				'secondary_cta_url'   => array('label' => __('Secondary CTA URL', 'cmn-marketing'), 'type' => 'url'),
			),
		),
		'social_links' => array(
			'title'  => __('Social Links', 'cmn-marketing'),
			'fields' => array(
				'social_linkedin'  => array('label' => __('LinkedIn', 'cmn-marketing'), 'type' => 'url'),
				'social_x'         => array('label' => __('X (Twitter)', 'cmn-marketing'), 'type' => 'url'),
				'social_facebook'  => array('label' => __('Facebook', 'cmn-marketing'), 'type' => 'url'),
				'social_instagram' => array('label' => __('Instagram', 'cmn-marketing'), 'type' => 'url'),
			),
		),
		'brand' => array(
			'title'  => __('Brand Tagline', 'cmn-marketing'),
			'fields' => array(
				'brand_tagline' => array('label' => __('Short Positioning Line', 'cmn-marketing'), 'type' => 'text'),
			),
		),
		'schools_tiers' => array(
			'title'             => __('Schools Partner Tiers', 'cmn-marketing'),
			'type'              => 'tiers',
			'option_key'        => 'schools_tiers',
			'max'               => 4,
			'metric_label'      => __('Tier Percentage / Multiplier', 'cmn-marketing'),
			'description_label' => __('Tier Description (short)', 'cmn-marketing'),
		),
		'candidate_tiers' => array(
			'title'             => __('Candidate Reward Tiers', 'cmn-marketing'),
			'type'              => 'tiers',
			'option_key'        => 'candidate_tiers',
			'max'               => 3,
			'metric_label'      => __('Multiplier or Benefit', 'cmn-marketing'),
			'description_label' => __('Short Description', 'cmn-marketing'),
		),
		'faqs' => array(
			'title'      => __('FAQs', 'cmn-marketing'),
			'type'       => 'faqs',
			'option_key' => 'faqs',
			'max_groups' => 6,
			'max_items'  => 8,
		),
	);
}

/**
 * Render tier fields for a section.
 *
 * @param array<string, mixed> $section Section metadata.
 * @param array<string, mixed> $settings Saved settings.
 */
function cmn_marketing_render_tier_section($section, $settings)
{
	$section_title = isset($section['title']) ? (string) $section['title'] : '';
	$option_key = isset($section['option_key']) ? (string) $section['option_key'] : '';
	$max = isset($section['max']) ? (int) $section['max'] : 0;
	$metric_label = isset($section['metric_label']) ? (string) $section['metric_label'] : __('Metric', 'cmn-marketing');
	$description_label = isset($section['description_label']) ? (string) $section['description_label'] : __('Description', 'cmn-marketing');

	$tiers = isset($settings[$option_key]) && is_array($settings[$option_key]) ? array_values($settings[$option_key]) : array();
	?>
	<h2><?php echo esc_html($section_title); ?></h2>
	<p><?php esc_html_e('Leave all fields empty in a tier row to remove it. If all rows are empty, defaults will be used.', 'cmn-marketing'); ?></p>
	<?php for ($index = 0; $index < $max; $index++) : ?>
		<?php
		$tier = isset($tiers[$index]) && is_array($tiers[$index]) ? cmn_marketing_sanitize_tier($tiers[$index]) : cmn_marketing_sanitize_tier(array());
		$benefits = isset($tier['benefits']) && is_array($tier['benefits']) ? array_values($tier['benefits']) : array('', '', '');
		for ($benefit_index = 0; $benefit_index < 3; $benefit_index++) {
			if (!isset($benefits[$benefit_index])) {
				$benefits[$benefit_index] = '';
			}
		}
		?>
		<h3><?php echo esc_html(sprintf(__('Tier %d', 'cmn-marketing'), $index + 1)); ?></h3>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row">
						<label for="<?php echo esc_attr($option_key . '_' . $index . '_name'); ?>"><?php esc_html_e('Tier Name', 'cmn-marketing'); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="<?php echo esc_attr($option_key . '_' . $index . '_name'); ?>"
							name="cmn_marketing_settings[<?php echo esc_attr($option_key); ?>][<?php echo esc_attr((string) $index); ?>][name]"
							value="<?php echo esc_attr((string) $tier['name']); ?>"
							class="regular-text"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="<?php echo esc_attr($option_key . '_' . $index . '_metric'); ?>"><?php echo esc_html($metric_label); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="<?php echo esc_attr($option_key . '_' . $index . '_metric'); ?>"
							name="cmn_marketing_settings[<?php echo esc_attr($option_key); ?>][<?php echo esc_attr((string) $index); ?>][metric]"
							value="<?php echo esc_attr((string) $tier['metric']); ?>"
							class="regular-text"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="<?php echo esc_attr($option_key . '_' . $index . '_description'); ?>"><?php echo esc_html($description_label); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="<?php echo esc_attr($option_key . '_' . $index . '_description'); ?>"
							name="cmn_marketing_settings[<?php echo esc_attr($option_key); ?>][<?php echo esc_attr((string) $index); ?>][description]"
							value="<?php echo esc_attr((string) $tier['description']); ?>"
							class="large-text"
						>
					</td>
				</tr>
				<?php for ($benefit_index = 0; $benefit_index < 3; $benefit_index++) : ?>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr($option_key . '_' . $index . '_benefit_' . $benefit_index); ?>">
								<?php echo esc_html(sprintf(__('Benefit %d', 'cmn-marketing'), $benefit_index + 1)); ?>
							</label>
						</th>
						<td>
							<input
								type="text"
								id="<?php echo esc_attr($option_key . '_' . $index . '_benefit_' . $benefit_index); ?>"
								name="cmn_marketing_settings[<?php echo esc_attr($option_key); ?>][<?php echo esc_attr((string) $index); ?>][benefits][<?php echo esc_attr((string) $benefit_index); ?>]"
								value="<?php echo esc_attr((string) $benefits[$benefit_index]); ?>"
								class="large-text"
							>
						</td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	<?php endfor; ?>
	<?php
}

/**
 * Render FAQ fields for settings.
 *
 * @param array<string, mixed> $section Section metadata.
 * @param array<string, mixed> $settings Saved settings.
 */
function cmn_marketing_render_faq_section($section, $settings)
{
	$section_title = isset($section['title']) ? (string) $section['title'] : '';
	$option_key = isset($section['option_key']) ? (string) $section['option_key'] : 'faqs';
	$max_groups = isset($section['max_groups']) ? (int) $section['max_groups'] : 0;
	$max_items = isset($section['max_items']) ? (int) $section['max_items'] : 0;
	$groups = isset($settings[$option_key]) && is_array($settings[$option_key]) ? array_values($settings[$option_key]) : array();
	?>
	<h2><?php echo esc_html($section_title); ?></h2>
	<p><?php esc_html_e('Create FAQ groups and fill the items you need. Leave a group and all of its items empty to remove it. Basic HTML is allowed in answers.', 'cmn-marketing'); ?></p>
	<?php for ($group_index = 0; $group_index < $max_groups; $group_index++) : ?>
		<?php
		$group = isset($groups[$group_index]) && is_array($groups[$group_index]) ? cmn_marketing_sanitize_faq_group($groups[$group_index], $max_items) : array(
			'title' => '',
			'items' => array(),
		);
		$items = isset($group['items']) && is_array($group['items']) ? array_values($group['items']) : array();
		?>
		<h3><?php echo esc_html(sprintf(__('FAQ Group %d', 'cmn-marketing'), $group_index + 1)); ?></h3>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row">
						<label for="<?php echo esc_attr($option_key . '_' . $group_index . '_title'); ?>"><?php esc_html_e('Group Title', 'cmn-marketing'); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="<?php echo esc_attr($option_key . '_' . $group_index . '_title'); ?>"
							name="cmn_marketing_settings[<?php echo esc_attr($option_key); ?>][<?php echo esc_attr((string) $group_index); ?>][title]"
							value="<?php echo esc_attr((string) $group['title']); ?>"
							class="large-text"
						>
					</td>
				</tr>
				<?php for ($item_index = 0; $item_index < $max_items; $item_index++) : ?>
					<?php
					$item = isset($items[$item_index]) && is_array($items[$item_index]) ? cmn_marketing_sanitize_faq_item($items[$item_index]) : array(
						'q' => '',
						'a' => '',
					);
					?>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr($option_key . '_' . $group_index . '_q_' . $item_index); ?>">
								<?php echo esc_html(sprintf(__('Question %d', 'cmn-marketing'), $item_index + 1)); ?>
							</label>
						</th>
						<td>
							<input
								type="text"
								id="<?php echo esc_attr($option_key . '_' . $group_index . '_q_' . $item_index); ?>"
								name="cmn_marketing_settings[<?php echo esc_attr($option_key); ?>][<?php echo esc_attr((string) $group_index); ?>][items][<?php echo esc_attr((string) $item_index); ?>][q]"
								value="<?php echo esc_attr((string) $item['q']); ?>"
								class="large-text"
							>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr($option_key . '_' . $group_index . '_a_' . $item_index); ?>">
								<?php echo esc_html(sprintf(__('Answer %d', 'cmn-marketing'), $item_index + 1)); ?>
							</label>
						</th>
						<td>
							<textarea
								id="<?php echo esc_attr($option_key . '_' . $group_index . '_a_' . $item_index); ?>"
								name="cmn_marketing_settings[<?php echo esc_attr($option_key); ?>][<?php echo esc_attr((string) $group_index); ?>][items][<?php echo esc_attr((string) $item_index); ?>][a]"
								rows="3"
								class="large-text"
							><?php echo esc_textarea((string) $item['a']); ?></textarea>
						</td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	<?php endfor; ?>
	<?php
}

/**
 * Register settings menu page.
 */
function cmn_marketing_register_settings_menu()
{
	add_menu_page(
		__('CMN Marketing Settings', 'cmn-marketing'),
		__('CMN Marketing Settings', 'cmn-marketing'),
		'manage_options',
		'cmn-marketing-settings',
		'cmn_marketing_render_settings_page',
		'dashicons-admin-generic',
		59
	);
}
add_action('admin_menu', 'cmn_marketing_register_settings_menu');

/**
 * Render settings admin page.
 */
function cmn_marketing_render_settings_page()
{
	if (!current_user_can('manage_options')) {
		wp_die(esc_html__('You do not have permission to access this page.', 'cmn-marketing'));
	}

	if (
		isset($_POST['cmn_marketing_settings_submit']) &&
		is_string($_POST['cmn_marketing_settings_submit'])
	) {
		check_admin_referer('cmn_marketing_settings_save', 'cmn_marketing_settings_nonce');

		$raw_settings = isset($_POST['cmn_marketing_settings']) ? wp_unslash($_POST['cmn_marketing_settings']) : array();
		$sanitized_settings = cmn_marketing_sanitize_settings($raw_settings);
		update_option('cmn_marketing_settings', $sanitized_settings);

		add_settings_error(
			'cmn_marketing_settings',
			'cmn_marketing_settings_saved',
			esc_html__('Settings saved.', 'cmn-marketing'),
			'updated'
		);
	}

	$settings = cmn_marketing_get_settings();
	$sections = cmn_marketing_settings_sections();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('CMN Marketing Settings', 'cmn-marketing'); ?></h1>
		<?php settings_errors('cmn_marketing_settings'); ?>
		<form method="post" action="">
			<?php wp_nonce_field('cmn_marketing_settings_save', 'cmn_marketing_settings_nonce'); ?>

			<?php foreach ($sections as $section) : ?>
				<?php if (isset($section['type']) && $section['type'] === 'tiers') : ?>
					<?php cmn_marketing_render_tier_section($section, $settings); ?>
					<?php continue; ?>
				<?php endif; ?>
				<?php if (isset($section['type']) && $section['type'] === 'faqs') : ?>
					<?php cmn_marketing_render_faq_section($section, $settings); ?>
					<?php continue; ?>
				<?php endif; ?>

				<h2><?php echo esc_html($section['title']); ?></h2>
				<table class="form-table" role="presentation">
					<tbody>
						<?php foreach ($section['fields'] as $field_key => $field) : ?>
							<?php $field_value = isset($settings[$field_key]) && !is_array($settings[$field_key]) ? $settings[$field_key] : ''; ?>
							<tr>
								<th scope="row">
									<label for="<?php echo esc_attr($field_key); ?>"><?php echo esc_html($field['label']); ?></label>
								</th>
								<td>
									<?php if ($field['type'] === 'textarea') : ?>
										<textarea
											id="<?php echo esc_attr($field_key); ?>"
											name="cmn_marketing_settings[<?php echo esc_attr($field_key); ?>]"
											rows="4"
											class="large-text"
										><?php echo esc_textarea((string) $field_value); ?></textarea>
									<?php else : ?>
										<input
											type="<?php echo esc_attr($field['type']); ?>"
											id="<?php echo esc_attr($field_key); ?>"
											name="cmn_marketing_settings[<?php echo esc_attr($field_key); ?>]"
											value="<?php echo esc_attr((string) $field_value); ?>"
											class="regular-text"
										>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endforeach; ?>

			<p class="submit">
				<button type="submit" name="cmn_marketing_settings_submit" value="1" class="button button-primary">
					<?php esc_html_e('Save Settings', 'cmn-marketing'); ?>
				</button>
			</p>
		</form>
	</div>
	<?php
}
