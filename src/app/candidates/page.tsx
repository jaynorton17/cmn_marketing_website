import type { Metadata } from "next";
import Link from "next/link";
import AssetImage from "../../components/AssetImage";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = {
  title: "Candidates",
  description: "Confirm daily availability, get booked faster, and build rewards.",
};

export default function CandidatesPage() {
  return (
    <div className="shell-container shell-stack marketing-page">
      <MarketingHero backgroundId="bg_02" overlayGraphicId="gfx_04" overlayGraphicOpacity={0.14}>
        <div className="hero-layout">
          <div className="hero-copy shell-stack">
            <p className="section-eyebrow">Candidates</p>
            <h1 className="hero-title">For Candidates</h1>
            <p className="hero-lede">Confirm daily availability, get booked faster, and build rewards.</p>
            <div className="hero-actions">
              <Link className="btn btn--primary" href="/contact">
                Create your profile
              </Link>
            </div>
          </div>

          <div className="hero-device-card">
            <div className="hero-device-media">
              <AssetImage category="laptop" id="laptop_12" alt="Candidate dashboard preview" className="hero-device-image" />
            </div>
          </div>
        </div>
      </MarketingHero>

      <section className="shell-card feature-slab">
        <div className="feature-slab__media">
          <AssetImage category="laptop" id="laptop_05" alt="Daily availability screenshot" className="feature-slab__media-image" />
        </div>
        <div className="feature-slab__content shell-stack">
          <p className="section-eyebrow">Section 1</p>
          <h2>Daily Availability</h2>
          <p>
            Confirm your availability in seconds so schools can identify and book dependable cover quickly.
          </p>
        </div>
      </section>

      <section className="shell-card feature-slab feature-slab--reverse">
        <div className="feature-slab__media">
          <AssetImage category="laptop" id="laptop_08" alt="Bookings and earnings screenshot" className="feature-slab__media-image" />
        </div>
        <div className="feature-slab__content shell-stack">
          <p className="section-eyebrow">Section 2</p>
          <h2>Bookings &amp; Earnings</h2>
          <p>
            Track confirmed bookings and earnings in a clear timeline that supports stable professional planning.
          </p>
        </div>
      </section>

      <section className="shell-card feature-slab">
        <div className="feature-slab__media">
          <AssetImage category="graphic" id="gfx_06" alt="Rewards and loyalty visual" className="feature-slab__media-image" />
        </div>
        <div className="feature-slab__content shell-stack">
          <p className="section-eyebrow">Section 3</p>
          <h2>Rewards &amp; Loyalty</h2>
          <p>
            Build consistency over time and gain access to structured rewards designed for reliable education professionals.
          </p>
        </div>
      </section>

      <section className="shell-card cta-strip shell-stack">
        <h2>Ready to work in a more disciplined cover system?</h2>
        <div>
          <Link className="btn btn--primary" href="/contact">
            Create your profile
          </Link>
        </div>
      </section>
    </div>
  );
}
