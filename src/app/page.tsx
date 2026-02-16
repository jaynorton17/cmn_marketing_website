import type { Metadata } from "next";
import { ASSETS } from "../assets/assetRegistry";
import AssetImage from "../components/AssetImage";
import CTAButton from "../components/CTAButton";
import Section from "../components/layout/Section";
import MarketingHero from "../components/MarketingHero";

export const metadata: Metadata = {
  title: "Home",
  description: "Recruitment. Rebuilt for Education.",
};

const HOW_IT_WORKS = [
  {
    iconId: "icon_01",
    title: "Confirm availability",
    copy: "Candidates confirm daily availability in a tight window — so you only see people who can actually work.",
  },
  {
    iconId: "icon_06",
    title: "Match instantly",
    copy: "Schools see vetted, available candidates in real time and request cover in minutes.",
  },
  {
    iconId: "icon_05",
    title: "Book with confidence",
    copy: "Confirmations, audit trail and support are built-in — no messy spreadsheets.",
  },
] as const;

const LIVE_AVAILABILITY_POINTS = [
  { iconId: "icon_01", label: "Available candidates only" },
  { iconId: "icon_07", label: "Instant confirmations" },
  { iconId: "icon_06", label: "Support when it matters" },
] as const;

const LIVE_AVAILABILITY_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_11") ? "laptop_11" : "laptop_01";
const REWARDS_LOYALTY_POINTS = [
  "Tiered rewards (Silver → Gold)",
  "Priority access to bookings",
  "Partner programme for schools",
] as const;
const REWARDS_LOYALTY_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_12") ? "laptop_12" : "laptop_08";
const COMPLIANCE_TRUST_ITEMS = [
  { label: "Vetted candidates", iconId: "icon_05" },
  { label: "Clear booking history", iconId: "icon_06" },
  { label: "Support + escalation", iconId: "icon_07" },
] as const;
const COMPLIANCE_TRUST_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_06") ? "laptop_06" : "laptop_01";

export default function HomePage() {
  return (
    <div className="marketing-page">
      <MarketingHero
        className="home-hero"
        backgroundId="bg_03"
        overlayGraphicId="gfx_02"
        laptopId="laptop_10"
        showLogo
        title="Recruitment. Rebuilt for Education."
        subtitle="Real-time availability. Faster bookings. Better cover."
        primaryCta={{ label: "Book Emergency Cover", href: "/schools" }}
        secondaryCta={{ label: "Join as a Candidate", href: "/candidates" }}
      />

      <Section title="How it works" subtitle="A faster way to book emergency cover — without the back and forth." id="how-it-works">
        <div className="shell-card u-glass u-shadow-soft shell-stack home-how">
          <div className="feature-grid feature-grid--three">
            {HOW_IT_WORKS.map((item) => (
              <article key={item.title} className="feature-card shell-stack u-glass u-shadow-soft">
                <div className="feature-card__icon">
                  <AssetImage category="icon" id={item.iconId} alt={item.title} className="feature-card__icon-image" />
                </div>
                <h3>{item.title}</h3>
                <p>{item.copy}</p>
              </article>
            ))}
          </div>
        </div>
      </Section>

      <Section>
        <div className="shell-card u-glass u-shadow-soft live-availability">
          <div className="live-availability__bg" aria-hidden="true">
            <AssetImage category="graphics" id="gfx_02" alt="" className="live-availability__bg-image" />
          </div>

          <div className="live-availability__layout">
            <div className="live-availability__visual">
              <div className="live-availability__laptop">
                <AssetImage
                  category="laptopui"
                  id={LIVE_AVAILABILITY_LAPTOP_ID}
                  alt="Live availability dashboard preview"
                  className="live-availability__laptop-image"
                />
              </div>

              <div className="live-availability__floating" aria-hidden="true">
                <AssetImage category="graphics" id="gfx_05" alt="" className="live-availability__floating-image" />
              </div>
            </div>

            <div className="live-availability__content shell-stack">
              <h2 className="section-title">Live availability, in real time</h2>
              <p className="hero-lede">
                Confirmations drive everything — so schools stop guessing and candidates stop waiting.
              </p>

              <ul className="live-availability__list">
                {LIVE_AVAILABILITY_POINTS.map((point) => (
                  <li key={point.label} className="live-availability__item">
                    <span className="live-availability__item-icon">
                      <AssetImage category="icons" id={point.iconId} alt={point.label} className="live-availability__item-icon-image" />
                    </span>
                    <span>{point.label}</span>
                  </li>
                ))}
              </ul>

              <div>
                <CTAButton href="/schools" variant="ghost">
                  See how it works
                </CTAButton>
              </div>
            </div>
          </div>
        </div>
      </Section>

      <Section>
        <div className="shell-card u-glass u-shadow-soft rewards-loyalty">
          <div className="rewards-loyalty__bg" aria-hidden="true">
            <AssetImage category="graphics" id="gfx_06" alt="" className="rewards-loyalty__bg-image" />
          </div>

          <div className="rewards-loyalty__layout">
            <div className="rewards-loyalty__visual">
              <div className="rewards-loyalty__laptop">
                <AssetImage
                  category="laptopui"
                  id={REWARDS_LOYALTY_LAPTOP_ID}
                  alt="Rewards and loyalty dashboard preview"
                  className="rewards-loyalty__laptop-image"
                />
              </div>
            </div>

            <div className="rewards-loyalty__content shell-stack">
              <h2 className="section-title">Rewards that build loyalty</h2>
              <p className="hero-lede">
                We reward consistency — better availability, better bookings, better outcomes.
              </p>

              <ul className="rewards-loyalty__list">
                {REWARDS_LOYALTY_POINTS.map((point) => (
                  <li key={point}>{point}</li>
                ))}
              </ul>

              <div>
                <CTAButton href="/candidates" variant="primary">
                  Join as a Candidate
                </CTAButton>
              </div>
            </div>
          </div>
        </div>
      </Section>

      <Section>
        <div className="shell-card u-glass u-shadow-soft compliance-trust">
          <div className="compliance-trust__bg" aria-hidden="true">
            <AssetImage category="graphics" id="gfx_01" alt="" className="compliance-trust__bg-image" />
          </div>

          <div className="compliance-trust__content shell-stack">
            <div className="compliance-trust__header">
              <div className="compliance-trust__copy shell-stack">
                <h2 className="section-title">Compliance-first, always</h2>
                <p className="hero-lede">
                  Audit trail, safeguarding checks, and documentation status — visible at every step.
                </p>
              </div>

              <div className="compliance-trust__laptop">
                <AssetImage
                  category="laptopui"
                  id={COMPLIANCE_TRUST_LAPTOP_ID}
                  alt="Compliance dashboard preview"
                  className="compliance-trust__laptop-image"
                />
              </div>
            </div>

            <div className="compliance-trust__grid">
              {COMPLIANCE_TRUST_ITEMS.map((item) => (
                <article key={item.label} className="compliance-trust__card shell-stack u-glass u-shadow-soft">
                  <span className="compliance-trust__card-icon">
                    <AssetImage category="icons" id={item.iconId} alt={item.label} className="compliance-trust__card-icon-image" />
                  </span>
                  <h3>{item.label}</h3>
                </article>
              ))}
            </div>

            <div className="compliance-trust__cta u-glow-red">
              <p>Ready to book emergency cover without the chaos?</p>
              <div className="compliance-trust__cta-actions">
                <CTAButton href="/schools" variant="primary">
                  Book Emergency Cover
                </CTAButton>
                <CTAButton href="/contact-us" variant="secondary">
                  Book a Demo
                </CTAButton>
              </div>
            </div>
          </div>
        </div>
      </Section>

      <Section variant="tight">
        <div className="shell-card u-glass u-shadow-soft split-section">
          <div className="split-section__graphic" aria-hidden="true">
            <AssetImage category="graphic" id="gfx_03" alt="" className="split-section__graphic-image" />
          </div>
          <div className="split-section__content">
            <article className="split-card shell-stack u-glass u-shadow-soft">
              <p className="section-eyebrow">Schools</p>
              <h2>Run emergency cover with operational control</h2>
              <p>
                Receive real-time candidate availability, place bookings quickly, and keep clear records from request to completion.
              </p>
              <div>
                <CTAButton href="/schools" variant="primary">
                  Explore Schools
                </CTAButton>
              </div>
            </article>

            <article className="split-card shell-stack u-glass u-shadow-soft">
              <p className="section-eyebrow">Candidates</p>
              <h2>Work in a fair, high-visibility system</h2>
              <p>
                Confirm daily availability, receive matched opportunities faster, and build reliability through structured workflows.
              </p>
              <div>
                <CTAButton href="/candidates" variant="secondary">
                  Explore Candidates
                </CTAButton>
              </div>
            </article>
          </div>
        </div>
      </Section>

      <Section variant="tight">
        <div className="shell-card u-glass u-shadow-soft trust-section">
          <div className="trust-section__media">
            <AssetImage category="graphic" id="gfx_01" alt="Compliance and trust visual" className="trust-section__media-image" />
          </div>
          <div className="trust-section__content shell-stack">
            <p className="section-eyebrow">Trust & Compliance</p>
            <h2 className="section-title">Reliable infrastructure under pressure</h2>
            <ul className="bullet-list">
              <li>Compliance-first workflows</li>
              <li>Booking history and audit trail</li>
              <li>Support when it matters</li>
            </ul>
          </div>
        </div>
      </Section>
    </div>
  );
}
