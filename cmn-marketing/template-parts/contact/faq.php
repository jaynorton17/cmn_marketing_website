<?php
if (!defined('ABSPATH')) {
	exit;
}

$faq_groups = cmn_marketing_get_faq_groups();
if (empty($faq_groups)) {
	return;
}
?>
<section class="cmn-section cmn-contact-faq" aria-labelledby="cmn-contact-faq-title">
	<div class="cmn-container cmn-stack">
		<div class="cmn-stack">
			<p class="cmn-eyebrow">FAQs</p>
			<h2 id="cmn-contact-faq-title" class="cmn-h2">Frequently asked questions.</h2>
		</div>

		<div class="cmn-panel cmn-faq">
			<?php foreach ($faq_groups as $group_index => $group) : ?>
				<?php
				$group_title = isset($group['title']) ? (string) $group['title'] : '';
				$group_items = isset($group['items']) && is_array($group['items']) ? $group['items'] : array();
				if (empty($group_items)) {
					continue;
				}
				$group_heading_id = 'cmn-contact-faq-group-' . ($group_index + 1);
				?>
				<section class="cmn-faq__group" <?php echo $group_title !== '' ? 'aria-labelledby="' . esc_attr($group_heading_id) . '"' : ''; ?>>
					<?php if ($group_title !== '') : ?>
						<h3 id="<?php echo esc_attr($group_heading_id); ?>" class="cmn-faq__group-title"><?php echo esc_html($group_title); ?></h3>
					<?php endif; ?>
					<div class="cmn-faq__items">
						<?php foreach ($group_items as $item) : ?>
							<?php
							$question = isset($item['q']) ? (string) $item['q'] : '';
							$answer = isset($item['a']) ? (string) $item['a'] : '';
							if ($question === '' || trim(wp_strip_all_tags($answer)) === '') {
								continue;
							}
							?>
							<details class="cmn-faq__item">
								<summary><?php echo esc_html($question); ?></summary>
								<div class="cmn-faq__answer"><?php echo wp_kses_post(wpautop($answer)); ?></div>
							</details>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
</section>
