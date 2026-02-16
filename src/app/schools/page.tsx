import type { Metadata } from "next";
import Link from "next/link";
import AssetImage from "../../components/AssetImage";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = {
  title: "Schools",
  description: "Book emergency cover in minutes with full visibility and control.",
};

export default function SchoolsPage() {
  return (
    <div className="shell-container shell-stack marketing-page">
      <MarketingHero backgroundId="bg_01" overlayGraphicId="gfx_05" overlayGraphicOpacity={0.14}>
        <div className="hero-layout">
          <div className="hero-copy shell-stack">
            <p className="section-eyebrow">Schools</p>
            <h1 className="hero-title">For Schools</h1>
            <p className="hero-lede">Book emergency cover in minutes — with full visibility and control.</p>
            <div className="hero-actions">
              <Link className="btn btn--primary" href="/contact">
                Request a demo
              </Link>
            </div>
          </div>

          <div className="hero-device-card">
            <div className="hero-device-media">
              <AssetImage category="laptop" id="laptop_06" alt="School dashboard view" className="hero-device-image" />
            </div>
          </div>
        </div>
      </MarketingHero>

      <section className="shell-card feature-slab">
        <div className="feature-slab__media">
          <AssetImage category="laptop" id="laptop_11" alt="Live availability engine screenshot" className="feature-slab__media-image" />
        </div>
        <div className="feature-slab__content shell-stack">
          <p className="section-eyebrow">Section 1</p>
          <h2>Live Availability Engine</h2>
          <p>
            See who is ready to work before the school day starts, so urgent cover can be arranged quickly and confidently.
          </p>
        </div>
      </section>

      <section className="shell-card feature-slab feature-slab--reverse">
        <div className="feature-slab__media">
          <AssetImage category="laptop" id="laptop_09" alt="Confirmations and tracking screenshot" className="feature-slab__media-image" />
        </div>
        <div className="feature-slab__content shell-stack">
          <p className="section-eyebrow">Section 2</p>
          <h2>Confirmations &amp; Tracking</h2>
          <p>
            Follow every request and booking status in one timeline, with clear confirmations for operational teams and leadership.
          </p>
        </div>
      </section>

      <section className="shell-card feature-slab">
        <div className="feature-slab__media">
          <AssetImage category="graphic" id="gfx_01" alt="Compliance and peace of mind visual" className="feature-slab__media-image" />
        </div>
        <div className="feature-slab__content shell-stack">
          <p className="section-eyebrow">Section 3</p>
          <h2>Compliance &amp; Peace of Mind</h2>
          <p>
            Keep compliance checks, booking history, and communication records aligned so emergency cover remains secure and auditable.
          </p>
        </div>
      </section>

      <section className="shell-card cta-strip shell-stack">
        <h2>Need structured emergency cover for your school group?</h2>
        <div>
          <Link className="btn btn--primary" href="/contact">
            Request a demo
          </Link>
        </div>
      </section>
    </div>
  );
}
