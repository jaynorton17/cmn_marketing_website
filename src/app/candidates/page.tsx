import type { Metadata } from "next";
import Link from "next/link";
import { ASSETS } from "../../assets/assetRegistry";
import AssetImage from "../../components/AssetImage";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = {
  title: "Candidates",
  description: "Confirm daily availability, get booked faster, and build rewards.",
};

const HERO_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_12") ? "laptop_12" : "laptop_08";
const DAILY_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_05") ? "laptop_05" : "laptop_01";
const BOOKINGS_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_08") ? "laptop_08" : "laptop_01";
const REWARDS_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_12") ? "laptop_12" : "laptop_08";

const DAILY_POINTS = [
  { iconId: "icon_01", label: "Fast daily confirmation window" },
  { iconId: "icon_07", label: "More availability = more bookings" },
  { iconId: "icon_06", label: "Clear expectations" },
] as const;

const REWARDS_POINTS = [
  "Tier progression (Silver → Gold)",
  "Priority booking access",
  "Partner programme opportunities",
] as const;

export default function CandidatesPage() {
  return (
    <div className="shell-container shell-stack marketing-page candidates-page">
      <MarketingHero
        backgroundId="bg_02"
        overlayGraphicId="gfx_04"
        laptopId={HERO_LAPTOP_ID}
        eyebrow="For Candidates"
        title="For Candidates"
        subtitle="Confirm daily availability, get booked faster, and build rewards."
        primaryCta={{ label: "Enter CMN ONE", href: "/covermenow-one" }}
        secondaryCta={{ label: "Book a Demo", href: "/contact-us" }}
      />

      <section className="shell-card candidates-daily">
        <div className="candidates-daily__layout">
          <div className="candidates-daily__content shell-stack">
            <h2 className="section-title">Daily availability</h2>
            <p className="hero-lede">
              Confirming consistently keeps you visible when urgent bookings open and helps schools fill cover quickly.
            </p>

            <ul className="candidates-points">
              {DAILY_POINTS.map((point) => (
                <li key={point.label} className="candidates-points__item">
                  <span className="candidates-points__icon">
                    <AssetImage category="icons" id={point.iconId} alt={point.label} className="candidates-points__icon-image" />
                  </span>
                  <span>{point.label}</span>
                </li>
              ))}
            </ul>
          </div>

          <div className="candidates-daily__media">
            <AssetImage
              category="laptopui"
              id={DAILY_LAPTOP_ID}
              alt="Daily availability dashboard"
              className="candidates-daily__media-image"
            />
          </div>
        </div>
      </section>

      <section className="shell-card candidates-bookings">
        <div className="candidates-bookings__layout">
          <div className="candidates-bookings__media">
            <AssetImage
              category="laptopui"
              id={BOOKINGS_LAPTOP_ID}
              alt="Bookings and earnings dashboard"
              className="candidates-bookings__media-image"
            />
          </div>

          <div className="candidates-bookings__content shell-stack">
            <h2 className="section-title">Bookings &amp; earnings</h2>
            <p>
              Track confirmed bookings and expected earnings in one timeline, so your week is easier to plan.
            </p>
            <p>
              Clear visibility reduces uncertainty and helps you focus on reliable, high-quality assignments.
            </p>
          </div>
        </div>
      </section>

      <section className="shell-card candidates-rewards">
        <div className="candidates-rewards__bg" aria-hidden="true">
          <AssetImage category="graphics" id="gfx_06" alt="" className="candidates-rewards__bg-image" />
        </div>

        <div className="candidates-rewards__content shell-stack">
          <div className="candidates-rewards__header">
            <div className="candidates-rewards__copy shell-stack">
              <h2 className="section-title">Rewards &amp; loyalty</h2>
              <p className="hero-lede">
                Reliable behaviour is recognised through structured progression and better booking opportunities.
              </p>
            </div>

            <div className="candidates-rewards__laptop">
              <AssetImage
                category="laptopui"
                id={REWARDS_LAPTOP_ID}
                alt="Rewards and loyalty dashboard"
                className="candidates-rewards__laptop-image"
              />
            </div>
          </div>

          <ul className="candidates-rewards__list">
            {REWARDS_POINTS.map((point) => (
              <li key={point}>{point}</li>
            ))}
          </ul>
        </div>
      </section>

      <section className="shell-card candidates-cta">
        <h2>Ready to get booked faster?</h2>
        <div className="candidates-cta__actions">
          <Link className="btn btn--primary" href="/covermenow-one">
            Enter CMN ONE
          </Link>
          <Link className="btn btn--ghost" href="/contact-us">
            Contact us
          </Link>
        </div>
      </section>
    </div>
  );
}
