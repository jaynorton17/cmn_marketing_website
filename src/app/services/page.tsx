import type { Metadata } from "next";
import Image from "next/image";
import { icons } from "../../assets/assetRegistry";
import { buildPageMetadata } from "../../config/seo";
import CTAButton from "../../components/CTAButton";
import Section from "../../components/layout/Section";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = buildPageMetadata({
  title: "Availability, Compliance, Booking Management",
  description: "Availability, Compliance, Booking Management",
  canonicalPath: "/services",
});

const SERVICES = [
  {
    iconPath: icons.confirmedInAdvance,
    title: "Confirmed in advance",
    description: "Availability is set before the school day starts.",
  },
  {
    iconPath: icons.visibleInstantly,
    title: "Visible instantly",
    description: "Confirmed candidates appear immediately for school teams.",
  },
  {
    iconPath: icons.bookedInSeconds,
    title: "Booked in seconds",
    description: "Requests must be accepted within 10 minutes or they reset.",
  },
  {
    iconPath: icons.vettedCandidates,
    title: "Vetted candidates",
    description: "Only checked and verified candidates are available to book.",
  },
  {
    iconPath: icons.clearBookingHistory,
    title: "Clear booking history",
    description: "Every request and attendance update stays traceable.",
  },
  {
    iconPath: icons.supportEscalation,
    title: "Support + escalation",
    description: "Operational support is available when cover pressure increases.",
  },
] as const;

export default function ServicesPage() {
  return (
    <div className="marketing-page services-page">
      <MarketingHero
        className="home-hero"
        backgroundId="bg_04"
        heroImageId="hero_compliance_documents"
        heroImageAlt="Compliance documents dashboard"
        eyebrow="Platform Services"
        title="Everything emergency cover should have had years ago."
        subtitle="Real-time availability. Instant confirmation. Built-in compliance."
        primaryCta={{ label: "Apply to register", href: "/covermenow-one" }}
        secondaryCta={{ label: "Enter CMN ONE", href: "/covermenow-one" }}
      />

      <Section title="Core Services" variant="wide">
        <div className="shell-card u-glass u-shadow-soft shell-stack">
          <div className="feature-grid feature-grid--two feature-grid--three">
            {SERVICES.map((service) => (
              <article key={service.title} className="feature-card shell-stack u-glass u-shadow-soft">
                <div className="feature-card__icon">
                  <Image
                    src={service.iconPath}
                    alt={service.title}
                    width={32}
                    height={32}
                    className="feature-card__icon-image w-8 h-8 object-contain opacity-95"
                  />
                </div>
                <h3>{service.title}</h3>
                <p>{service.description}</p>
              </article>
            ))}
          </div>
        </div>
      </Section>

      <Section variant="tight">
        <div className="shell-card u-glass u-shadow-soft u-glow-red shell-stack">
          <h2 className="section-title">Need calmer emergency cover operations?</h2>
          <p className="hero-lede">See the full workflow in action and move faster with confidence.</p>
          <div className="compliance-trust__cta-actions">
            <CTAButton href="/covermenow-one" variant="primary">
              Apply to register
            </CTAButton>
            <CTAButton href="/covermenow-one" variant="secondary">
              Enter CMN ONE
            </CTAButton>
          </div>
        </div>
      </Section>
    </div>
  );
}
