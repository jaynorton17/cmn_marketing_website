import type { Metadata } from "next";
import Link from "next/link";
import { ASSETS } from "../assets/assetRegistry";
import AssetImage from "../components/AssetImage";
import MarketingHero from "../components/MarketingHero";

export const metadata: Metadata = {
  title: "Home",
  description: "Recruitment. Rebuilt for Education.",
};

const HOW_IT_WORKS = [
  {
    iconId: "icon_07",
    title: "Confirm availability",
    copy: "Candidates confirm from the evening before, giving schools a clear early view.",
  },
  {
    iconId: "icon_01",
    title: "Match instantly",
    copy: "Live availability signals route the right educators to urgent requests quickly.",
  },
  {
    iconId: "icon_06",
    title: "Book with confidence",
    copy: "Every booking is tracked, timestamped, and visible for operational confidence.",
  },
] as const;

const HOME_HERO_LAPTOP_ID = ASSETS.laptopui.some((asset) => asset.id === "laptop_10") ? "laptop_10" : "laptop_01";

export default function HomePage() {
  return (
    <div className="shell-container shell-stack marketing-page">
      <MarketingHero className="home-hero" backgroundId="bg_03" overlayGraphicId="gfx_02" overlayGraphicOpacity={0.1}>
        <div className="hero-layout">
          <div className="hero-copy shell-stack">
            <div className="home-hero__brand">
              <AssetImage category="logo" id="logo_main" alt="CoverMeNow ONE logo" className="home-hero__logo" />
            </div>
            <h1 className="hero-title">Recruitment. Rebuilt for Education.</h1>
            <p className="hero-lede">Real-time availability. Faster bookings. Better cover.</p>
            <div className="hero-actions">
              <Link className="btn btn--primary" href="/schools">
                Book Emergency Cover
              </Link>
              <Link className="btn btn--ghost" href="/candidates">
                Join as a Candidate
              </Link>
            </div>
          </div>

          <div className="home-hero__device">
            <div className="hero-device-media home-hero__device-media">
              <AssetImage
                category="laptop"
                id={HOME_HERO_LAPTOP_ID}
                alt="CoverMeNow ONE dashboard preview"
                className="hero-device-image"
                priority
              />
            </div>
          </div>
        </div>
      </MarketingHero>

      <section className="shell-card shell-stack">
        <header className="section-head shell-stack">
          <p className="section-eyebrow">How It Works</p>
          <h2 className="section-title">Built for fast, structured emergency cover</h2>
        </header>
        <div className="feature-grid feature-grid--three">
          {HOW_IT_WORKS.map((item) => (
            <article key={item.title} className="feature-card shell-stack">
              <div className="feature-card__icon">
                <AssetImage category="icon" id={item.iconId} alt={item.title} className="feature-card__icon-image" />
              </div>
              <h3>{item.title}</h3>
              <p>{item.copy}</p>
            </article>
          ))}
        </div>
      </section>

      <section className="shell-card split-section">
        <div className="split-section__graphic" aria-hidden="true">
          <AssetImage category="graphic" id="gfx_03" alt="" className="split-section__graphic-image" />
        </div>
        <div className="split-section__content">
          <article className="split-card shell-stack">
            <p className="section-eyebrow">Schools</p>
            <h2>Run emergency cover with operational control</h2>
            <p>
              Receive real-time candidate availability, place bookings quickly, and keep clear records from request to completion.
            </p>
            <div>
              <Link className="btn btn--primary" href="/schools">
                Explore Schools
              </Link>
            </div>
          </article>

          <article className="split-card shell-stack">
            <p className="section-eyebrow">Candidates</p>
            <h2>Work in a fair, high-visibility system</h2>
            <p>
              Confirm daily availability, receive matched opportunities faster, and build reliability through structured workflows.
            </p>
            <div>
              <Link className="btn btn--ghost" href="/candidates">
                Explore Candidates
              </Link>
            </div>
          </article>
        </div>
      </section>

      <section className="shell-card trust-section">
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
      </section>
    </div>
  );
}
