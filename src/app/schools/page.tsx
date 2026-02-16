import type { Metadata } from "next";
import { ASSETS } from "../../assets/assetRegistry";
import AssetImage from "../../components/AssetImage";
import CTAButton from "../../components/CTAButton";
import Section from "../../components/layout/Section";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = {
  title: "Schools",
  description: "Book emergency cover in minutes with visibility, confirmations and compliance built in.",
};

const HERO_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_06") ? "laptop_06" : "laptop_01";
const ENGINE_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_11") ? "laptop_11" : "laptop_01";
const TRACKING_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_09") ? "laptop_09" : "laptop_01";

const ENGINE_POINTS = [
  { iconId: "icon_01", label: "See only available candidates" },
  { iconId: "icon_07", label: "Instant confirmation workflow" },
  { iconId: "icon_06", label: "Audit trail by default" },
] as const;

const TRUST_ITEMS = [
  { iconId: "icon_05", label: "Safeguarding visibility" },
  { iconId: "icon_06", label: "Booking history" },
  { iconId: "icon_07", label: "Support + escalation" },
] as const;

export default function SchoolsPage() {
  return (
    <div className="marketing-page schools-page">
      <div className="shell-container page-hero-wrap">
        <MarketingHero
          backgroundId="bg_01"
          overlayGraphicId="gfx_05"
          laptopId={HERO_LAPTOP_ID}
          eyebrow="For Schools"
          title="For Schools"
          subtitle="Book emergency cover in minutes — with visibility, confirmations and compliance built in."
          primaryCta={{ label: "Book a Demo", href: "/contact-us" }}
          secondaryCta={{ label: "Enter CMN ONE", href: "/covermenow-one" }}
        />
      </div>

      <Section>
        <div className="shell-card u-glass u-shadow-soft schools-engine">
          <div className="schools-engine__layout">
            <div className="schools-engine__content shell-stack">
              <h2 className="section-title">Live Availability Engine</h2>
              <p className="hero-lede">
                Confirmed availability drives every recommendation, so your operations team spends less time chasing and more time booking.
              </p>

              <ul className="schools-points">
                {ENGINE_POINTS.map((point) => (
                  <li key={point.label} className="schools-points__item">
                    <span className="schools-points__icon">
                      <AssetImage category="icons" id={point.iconId} alt={point.label} className="schools-points__icon-image" />
                    </span>
                    <span>{point.label}</span>
                  </li>
                ))}
              </ul>
            </div>

            <div className="schools-engine__media">
              <AssetImage
                category="laptopui"
                id={ENGINE_LAPTOP_ID}
                alt="Live availability engine dashboard"
                className="schools-engine__media-image"
              />
            </div>
          </div>
        </div>
      </Section>

      <Section>
        <div className="shell-card u-glass u-shadow-soft schools-tracking">
          <div className="schools-tracking__layout">
            <div className="schools-tracking__media">
              <AssetImage
                category="laptopui"
                id={TRACKING_LAPTOP_ID}
                alt="Confirmations and tracking dashboard"
                className="schools-tracking__media-image"
              />
            </div>

            <div className="schools-tracking__content shell-stack">
              <h2 className="section-title">Confirmations &amp; Tracking</h2>
              <p>
                Every request, confirmation, and update is visible from first contact to completed booking.
              </p>
              <p>
                Leaders and coordinators get shared visibility, so decisions are faster and accountability stays clear.
              </p>
              <p>
                With structured tracking in one place, emergency cover becomes consistent rather than reactive.
              </p>
            </div>
          </div>
        </div>
      </Section>

      <Section>
        <div className="shell-card u-glass u-shadow-soft schools-compliance">
          <div className="schools-compliance__bg" aria-hidden="true">
            <AssetImage category="graphics" id="gfx_01" alt="" className="schools-compliance__bg-image" />
          </div>

          <div className="schools-compliance__content shell-stack">
            <h2 className="section-title">Compliance &amp; Peace of Mind</h2>
            <p className="hero-lede">
              Keep safeguarding, record-keeping, and operational response aligned without adding manual admin overhead.
            </p>

            <div className="schools-compliance__grid">
              {TRUST_ITEMS.map((item) => (
                <article key={item.label} className="schools-compliance__card shell-stack u-glass u-shadow-soft">
                  <span className="schools-compliance__card-icon">
                    <AssetImage
                      category="icons"
                      id={item.iconId}
                      alt={item.label}
                      className="schools-compliance__card-icon-image"
                    />
                  </span>
                  <h3>{item.label}</h3>
                </article>
              ))}
            </div>
          </div>
        </div>
      </Section>

      <Section variant="tight">
        <div className="shell-card u-glass u-shadow-soft u-glow-red schools-cta">
          <h2>Ready to book emergency cover without the chaos?</h2>
          <div className="schools-cta__actions">
            <CTAButton href="/covermenow-one" variant="primary">
              Enter CMN ONE
            </CTAButton>
            <CTAButton href="/contact-us" variant="secondary">
              Book a Demo
            </CTAButton>
          </div>
        </div>
      </Section>
    </div>
  );
}
