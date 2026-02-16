import type { Metadata } from "next";
import { buildPageMetadata } from "../../config/seo";
import CTAButton from "../../components/CTAButton";
import Section from "../../components/layout/Section";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = buildPageMetadata({
  title: "Why we built CMN ONE",
  description: "A shift in how emergency recruitment works.",
  canonicalPath: "/about",
});

const ABOUT_SECTIONS = [
  {
    heading: "The problem",
    body: "Morning phone calls. Uncertainty. Repeated chasing. Emergency cover has relied on manual processes for too long.",
  },
  {
    heading: "The shift",
    body: "When candidates confirm availability first, schools gain clarity before the day begins.",
  },
  {
    heading: "The standard",
    body: "Compliance, tracking, and accountability should be built in — not managed separately.",
  },
] as const;

export default function AboutPage() {
  return (
    <div className="marketing-page">
      <MarketingHero
        className="home-hero"
        backgroundId="bg_03"
        overlayGraphicId="gfx_03"
        eyebrow="About CMN ONE"
        title="Why we built CMN ONE."
        subtitle="Emergency recruitment doesn&apos;t need to be chaotic."
      />

      <Section>
        <div className="shell-card u-glass u-shadow-soft shell-stack">
          {ABOUT_SECTIONS.map((section) => (
            <div key={section.heading} className="shell-stack">
              <h2 className="section-title">{section.heading}</h2>
              <p className="hero-lede">{section.body}</p>
            </div>
          ))}

          <p className="hero-lede">
            This isn&apos;t supply recruitment.
            <br />
            It&apos;s emergency cover, rebuilt.
          </p>

          <div>
            <CTAButton href="/covermenow-one" variant="primary">
              Apply to register
            </CTAButton>
          </div>
        </div>
      </Section>
    </div>
  );
}
