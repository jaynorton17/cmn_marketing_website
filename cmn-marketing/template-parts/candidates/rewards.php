<?php
if (!defined('ABSPATH')) {
	exit;
}

$candidate_tiers = array_values(array_slice(cmn_marketing_get_candidate_tiers(), 0, 3));
$total_tiers = count($candidate_tiers);
?>
<section id="cmn-candidates-rewards" class="cmn-section cmn-candidates-rewards" aria-labelledby="cmn-candidates-rewards-title">
	<div class="cmn-container cmn-stack">
		<div class="cmn-stack cmn-candidates-heading">
			<p class="cmn-eyebrow">How Rewards Work</p>
			<h2 id="cmn-candidates-rewards-title" class="cmn-h2">A tier model that recognises consistency and professionalism.</h2>
			<p class="cmn-lede">[Placeholder copy: replace with a clear summary of progression rules, expected behaviors, and reward mechanics.]</p>
		</div>

		<div class="cmn-grid cmn-candidates-rewards__tiers">
			<?php foreach ($candidate_tiers as $index => $tier) : ?>
				<?php
				$tier_name = isset($tier['name']) ? (string) $tier['name'] : '';
				$tier_metric = isset($tier['metric']) ? (string) $tier['metric'] : '';
				$tier_description = isset($tier['description']) ? (string) $tier['description'] : '';
				$badge_class = ($total_tiers > 1 && $index === $total_tiers - 1) ? 'cmn-badge--accent' : 'cmn-badge--muted';

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
				<article class="cmn-card cmn-candidates-tier">
					<p class="cmn-badge <?php echo esc_attr($badge_class); ?>"><?php echo esc_html($tier_name); ?></p>
					<h3 class="cmn-card__title"><?php echo esc_html($tier_name); ?></h3>
					<?php if ($tier_metric !== '') : ?>
						<p class="cmn-candidates-tier__metric"><?php echo esc_html($tier_metric); ?></p>
					<?php endif; ?>
					<?php if ($tier_description !== '') : ?>
						<p class="cmn-card__body"><?php echo esc_html($tier_description); ?></p>
					<?php endif; ?>
					<?php if (!empty($tier_benefits)) : ?>
						<ul class="cmn-candidates-tier__list">
							<?php foreach ($tier_benefits as $benefit) : ?>
								<li><?php echo esc_html($benefit); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
