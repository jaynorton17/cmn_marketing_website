<?php
/**
 * Template Name: CMN Style Guide
 * Template Post Type: page
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main id="cmn-main">
	<section class="cmn-section">
		<div class="cmn-container cmn-stack">
			<p class="cmn-eyebrow">Internal Reference</p>
			<h1 class="cmn-h1">CMN Style Guide</h1>
			<p class="cmn-lede">Reusable UI components for the CoverMeNow ONE marketing experience. This page is intended for internal QA and consistency reviews.</p>
			<hr class="cmn-divider cmn-divider--spaced">

			<section class="cmn-stack" aria-labelledby="cmn-sg-buttons">
				<h2 id="cmn-sg-buttons" class="cmn-h2">Buttons and Badges</h2>
				<div class="cmn-card">
					<p class="cmn-card__title">Action styles</p>
					<p class="cmn-card__body">Use primary for key conversion actions, ghost for secondary controls, and link style for low-emphasis actions.</p>
					<div class="cmn-inline cmn-card__meta">
						<a class="cmn-btn" href="<?php echo esc_url(home_url('/contact/')); ?>">Primary Button</a>
						<button class="cmn-btn cmn-btn--ghost" type="button">Ghost Button</button>
						<a class="cmn-btn cmn-btn--link" href="<?php echo esc_url(home_url('/services/')); ?>">Link Button</a>
					</div>
				</div>

				<div class="cmn-card cmn-card--tight">
					<p class="cmn-card__title">Badge styles</p>
					<div class="cmn-inline cmn-card__body">
						<span class="cmn-badge cmn-badge--accent">Priority</span>
						<span class="cmn-badge cmn-badge--muted">Draft</span>
						<span class="cmn-badge cmn-badge--success">Verified</span>
					</div>
				</div>
			</section>

			<hr class="cmn-divider cmn-divider--spaced">

			<section class="cmn-stack" aria-labelledby="cmn-sg-cards">
				<h2 id="cmn-sg-cards" class="cmn-h2">Cards and Icon Boxes</h2>
				<div class="cmn-panel">
					<div class="cmn-card--tight">
						<p class="cmn-card__title">Panel baseline</p>
						<p class="cmn-card__body">Use <code>.cmn-panel</code> for neutral containers and layer <code>.cmn-card</code> when elevated interaction or metadata grouping is needed.</p>
					</div>
				</div>
				<div class="cmn-grid">
					<article class="cmn-card cmn-card--clickable">
						<div class="cmn-inline">
							<span class="cmn-iconbox" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<path d="M12 3 4.5 6.2v5.3c0 5.1 3.1 8.4 7.5 9.9 4.4-1.5 7.5-4.8 7.5-9.9V6.2L12 3Z" />
									<path d="m9.6 12 1.8 1.8 3.2-3.2" />
								</svg>
							</span>
							<p class="cmn-badge cmn-badge--accent">Security</p>
						</div>
						<h3 class="cmn-card__title">Safeguarding confidence</h3>
						<p class="cmn-card__body">Glass cards keep content calm and readable while highlighting critical actions and status states.</p>
						<p class="cmn-card__meta">Clickable variant: hover or focus-within lifts and accents border.</p>
					</article>

					<article class="cmn-card cmn-card--clickable">
						<div class="cmn-inline">
							<span class="cmn-iconbox" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<rect x="3.5" y="4" width="17" height="6" rx="2" />
									<rect x="3.5" y="14" width="17" height="6" rx="2" />
								</svg>
							</span>
							<p class="cmn-badge cmn-badge--muted">Structure</p>
						</div>
						<h3 class="cmn-card__title">Composable layout blocks</h3>
						<p class="cmn-card__body">Combine cards, stack rhythm, and grid utilities to build consistent sections across pages.</p>
						<p class="cmn-card__meta">Use tight card spacing for compact metadata clusters.</p>
					</article>

					<article class="cmn-card cmn-card--clickable">
						<div class="cmn-inline">
							<span class="cmn-iconbox" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<circle cx="12" cy="12" r="8" />
									<path d="M12 7v5l3.3 2" />
								</svg>
							</span>
							<p class="cmn-badge cmn-badge--success">Timeliness</p>
						</div>
						<h3 class="cmn-card__title">Operational clarity</h3>
						<p class="cmn-card__body">Muted metadata and measured spacing help teams scan updates without visual fatigue.</p>
						<p class="cmn-card__meta">All icon boxes support inline SVG around 24 to 28 pixels.</p>
					</article>
				</div>
			</section>

			<hr class="cmn-divider cmn-divider--spaced">

			<section class="cmn-stack" aria-labelledby="cmn-sg-forms">
				<h2 id="cmn-sg-forms" class="cmn-h2">Form Fields</h2>
				<form class="cmn-card cmn-stack" action="#" method="post" novalidate>
					<div class="cmn-form-row">
						<div class="cmn-field">
							<label for="cmn-sg-name">Full Name</label>
							<input id="cmn-sg-name" name="cmn-sg-name" type="text" placeholder="Alex Morgan">
							<p class="cmn-help">Use real role owner names for demos.</p>
						</div>
						<div class="cmn-field">
							<label for="cmn-sg-email">Work Email</label>
							<input id="cmn-sg-email" name="cmn-sg-email" type="email" placeholder="name@school.org">
							<p class="cmn-help">Response examples should stay generic in demos.</p>
						</div>
					</div>

					<div class="cmn-form-row">
						<div class="cmn-field">
							<label for="cmn-sg-role">Role Type</label>
							<select id="cmn-sg-role" name="cmn-sg-role">
								<option value="">Select one</option>
								<option value="school">School</option>
								<option value="candidate">Candidate</option>
								<option value="agency">Agency</option>
							</select>
						</div>
						<div class="cmn-field cmn-field--error">
							<label for="cmn-sg-message">Message</label>
							<textarea id="cmn-sg-message" name="cmn-sg-message" placeholder="Describe scope, deadlines, and priority"></textarea>
							<p class="cmn-error">Example error style: Please add a little more context.</p>
						</div>
					</div>

					<div class="cmn-inline">
						<button class="cmn-btn" type="button">Submit Demo Form</button>
						<button class="cmn-btn cmn-btn--ghost" type="reset">Reset</button>
					</div>
				</form>
			</section>

			<hr class="cmn-divider cmn-divider--spaced">

			<section class="cmn-stack" aria-labelledby="cmn-sg-table">
				<h2 id="cmn-sg-table" class="cmn-h2">Table Sample</h2>
				<div class="cmn-card">
					<div class="cmn-table-wrap">
						<table class="cmn-table">
							<thead>
								<tr>
									<th scope="col">Tier</th>
									<th scope="col">Checks Included</th>
									<th scope="col">Response Time</th>
									<th scope="col">Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Core</td>
									<td>ID + qualification baseline</td>
									<td>24 hours</td>
									<td><span class="cmn-badge cmn-badge--muted">Default</span></td>
								</tr>
								<tr>
									<td>Enhanced</td>
									<td>Core + safeguarding flags</td>
									<td>Same day</td>
									<td><span class="cmn-badge cmn-badge--accent">Recommended</span></td>
								</tr>
								<tr>
									<td>Priority</td>
									<td>Enhanced + manual escalation</td>
									<td>Under 2 hours</td>
									<td><span class="cmn-badge cmn-badge--success">Enabled</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</section>
</main>
<?php get_footer(); ?>
