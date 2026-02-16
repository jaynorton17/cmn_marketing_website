<?php
if (!defined('ABSPATH')) {
	exit;
}

$schools_tiers = array_values(array_slice(cmn_marketing_get_schools_tiers(), 0, 4));
?>
<section class="cmn-section cmn-schools-programme" aria-labelledby="cmn-schools-programme-title">
	<div class="cmn-container cmn-stack">
		<div class="cmn-panel cmn-panel--strong cmn-schools-programme__panel">
			<div class="cmn-stack cmn-schools-heading">
				<p class="cmn-eyebrow">Partner Programme</p>
				<h2 id="cmn-schools-programme-title" class="cmn-h2">A structured loyalty model designed for long-term partnership.</h2>
				<p class="cmn-lede">[Placeholder copy: replace with programme logic overview, including how partner schools progress through tiers and how value accumulates over time.]</p>
			</div>

			<div class="cmn-grid cmn-schools-programme__tiers">
				<?php foreach ($schools_tiers as $index => $tier) : ?>
					<?php
					$tier_name = isset($tier['name']) ? (string) $tier['name'] : '';
					$tier_metric = isset($tier['metric']) ? (string) $tier['metric'] : '';
					$tier_description = isset($tier['description']) ? (string) $tier['description'] : '';
					$badge_class = $index >= 2 ? 'cmn-badge--accent' : 'cmn-badge--muted';

					$tier_benefits = array();
					if (isset($tier['benefits']) && is_array($tier['benefits'])) {
						foreach ($tier['benefits'] as $benefit) {
							if (is_scalar($benefit) && sanitize_text_field((string) $benefit) !== '') {
								$tier_benefits[] = (string) $benefit;
							}
						}
					}

					if ($tier_name === '') {
						continue;
					}
					?>
					<article class="cmn-card cmn-schools-tier">
						<p class="cmn-badge <?php echo esc_attr($badge_class); ?>"><?php echo esc_html($tier_name); ?></p>
						<h3 class="cmn-card__title"><?php echo esc_html($tier_name); ?></h3>
						<?php if ($tier_metric !== '') : ?>
							<p class="cmn-schools-tier__metric"><?php echo esc_html($tier_metric); ?></p>
						<?php endif; ?>
						<?php if ($tier_description !== '') : ?>
							<p class="cmn-card__body"><?php echo esc_html($tier_description); ?></p>
						<?php endif; ?>
						<?php if (!empty($tier_benefits)) : ?>
							<ul class="cmn-schools-tier__list">
								<?php foreach ($tier_benefits as $benefit) : ?>
									<li><?php echo esc_html($benefit); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
