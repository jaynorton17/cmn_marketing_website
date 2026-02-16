import type { Metadata } from "next";
import Image from "next/image";
import { icons } from "../assets/assetRegistry";
import CTAButton from "../components/CTAButton";
import Section from "../components/layout/Section";
import MarketingHero from "../components/MarketingHero";
import { buildPageMetadata, DEFAULT_DESCRIPTION, SITE_NAME } from "../config/seo";

export const metadata: Metadata = {
  ...buildPageMetadata({
    title: "Recruitment. Rebuilt for Education.",
    description: DEFAULT_DESCRIPTION,
    canonicalPath: "/",
  }),
  title: `${SITE_NAME} | Recruitment. Rebuilt for Education.`,
};

const HOW_IT_WORKS = [
  {
    iconPath: icons.confirmedInAdvance,
    title: "Confirmed in advance",
    copy: "Candidates confirm availability the night before, so you see them first in the morning.",
  },
  {
    iconPath: icons.visibleInstantly,
    title: "Visible instantly",
    copy: "Confirmed candidates rise to the top the moment they’re available.",
  },
  {
    iconPath: icons.bookedInSeconds,
    title: "Booked in seconds",
    copy: "Requests must be accepted within 10 minutes — otherwise it resets.",
  },
] as const;

export default function HomePage() {
  return (
    <div className="marketing-page">
      <MarketingHero
        className="home-hero"
        backgroundId="bg_03"
        overlayGraphicId="gfx_02"
        heroImageId="hero_availability_confirmation"
        heroImageAlt="Availability confirmation hero"
        showLogo
        title="Emergency cover. Without the chaos."
        subtitle="See who’s confirmed for tomorrow before the morning starts. Book instantly. No calls. No chasing."
        primaryCta={{ label: "Apply to register", href: "/covermenow-one" }}
        secondaryCta={{ label: "Enter CMN ONE", href: "/covermenow-one" }}
      />

      <Section title="How it works" id="how-it-works" variant="wide">
        <div className="shell-card u-glass u-shadow-soft shell-stack home-how">
          <div className="feature-grid feature-grid--three">
            {HOW_IT_WORKS.map((item) => (
              <article key={item.title} className="feature-card shell-stack u-glass u-shadow-soft">
                <div className="feature-card__icon">
                  <Image
                    src={item.iconPath}
                    alt={item.title}
                    width={32}
                    height={32}
                    className="feature-card__icon-image w-8 h-8 object-contain opacity-95"
                  />
                </div>
                <h3>{item.title}</h3>
                <p>{item.copy}</p>
              </article>
            ))}
          </div>
        </div>
      </Section>

      <Section variant="tight">
        <div className="shell-card u-glass u-shadow-soft shell-stack">
          <h2 className="section-title">Trusted cover with clarity built in.</h2>
          <ul className="bullet-list">
            <li>Vetted candidates</li>
            <li>Clear booking history</li>
            <li>Support + escalation</li>
          </ul>
          <div>
            <CTAButton href="/services" variant="secondary">
              See services
            </CTAButton>
          </div>
        </div>
      </Section>
    </div>
  );
}
