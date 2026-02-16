import type { Metadata } from "next";
import Image from "next/image";
import { icons } from "../../assets/assetRegistry";
import { buildPageMetadata } from "../../config/seo";
import CTAButton from "../../components/CTAButton";
import Section from "../../components/layout/Section";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = buildPageMetadata({
  title: "Emergency Cover Booking for Schools",
  description: "Emergency Cover Booking for Schools",
  canonicalPath: "/schools",
});

const TRUST_COMPLIANCE_CARDS = [
  {
    iconPath: icons.vettedCandidates,
    title: "Vetted candidates",
    description: "Every visible candidate has completed required checks before they can be booked.",
  },
  {
    iconPath: icons.clearBookingHistory,
    title: "Clear booking history",
    description: "Requests, confirmations, and attendance are tracked in one audit-ready timeline.",
  },
  {
    iconPath: icons.supportEscalation,
    title: "Support + escalation",
    description: "When cover changes quickly, your team has direct support and clear escalation paths.",
  },
] as const;

const SCHOOL_STEPS = [
  {
    title: "Step 1: Log in to the CoverMeNow ONE portal",
    body: "When there is an unexpected absence one morning, log into the CoverMeNow ONE portal. Candidates who have already declared availability the evening before are presented first.",
  },
  {
    title: "Step 2: Review available candidates",
    body: "For each available candidate you’ll see:",
    bullets: ["Distance from the school", "Downloadable CV", "All required safeguarding documentation"],
    footer: "Everything you need is visible before booking.",
  },
  {
    title: "Step 3: Book in as little as 10 minutes",
    body: "Once you select a candidate, you can confirm the booking quickly — often in under 10 minutes — with no back-and-forth calls.",
  },
] as const;

const SCHOOL_BENEFITS = [
  {
    title: "Confirmed Before Morning",
    description:
      "Candidates declare availability the night before. When you log in in the morning, you see who is already confirmed. No chasing. No uncertainty.",
  },
  {
    title: "10-Minute Booking Resolution",
    description:
      "Once a booking request is sent, it must be accepted or declined within 10 minutes. If unresolved, it resets automatically. No limbo bookings. No waiting around.",
  },
  {
    title: "Partner Loyalty Rewards",
    description:
      "Schools on the loyalty programme receive structured invoice discounts and priority engagement benefits.",
  },
] as const;

export default function SchoolsPage() {
  return (
    <div className="marketing-page schools-page">
      <MarketingHero
        className="home-hero"
        backgroundId="bg_01"
        overlayGraphicId="gfx_05"
        heroImageId="hero_booking_history"
        heroImageAlt="Booking history hero"
        eyebrow="For Schools"
        title="Operational control for emergency cover."
        subtitle="See confirmed candidates first thing. Availability is declared the night before — so your morning starts with answers."
        primaryCta={{ label: "Apply to Register", href: "/covermenow-one" }}
        secondaryCta={{ label: "Enter CMN ONE", href: "/covermenow-one" }}
      />

      <Section title="Trust & Compliance" variant="wide">
        <div className="shell-card u-glass u-shadow-soft shell-stack">
          <div className="feature-grid feature-grid--three">
            {TRUST_COMPLIANCE_CARDS.map((card) => (
              <article key={card.title} className="feature-card shell-stack u-glass u-shadow-soft">
                <div className="feature-card__icon">
                  <Image
                    src={card.iconPath}
                    alt={card.title}
                    width={32}
                    height={32}
                    className="feature-card__icon-image w-8 h-8 object-contain opacity-95"
                  />
                </div>
                <h3>{card.title}</h3>
                <p>{card.description}</p>
              </article>
            ))}
          </div>
        </div>
      </Section>

      <Section title="How schools use it" variant="tight">
        <div className="shell-card u-glass u-shadow-soft shell-stack">
          <ol className="shell-stack">
            {SCHOOL_STEPS.map((step) => (
              <li key={step.title} className="shell-stack">
                <strong>{step.title}</strong>
                <p>{step.body}</p>
                {"bullets" in step ? (
                  <ul className="bullet-list">
                    {step.bullets.map((point) => (
                      <li key={`${step.title}-${point}`}>{point}</li>
                    ))}
                  </ul>
                ) : null}
                {"footer" in step ? <p>{step.footer}</p> : null}
              </li>
            ))}
          </ol>
        </div>
      </Section>

      <Section title="School benefits" variant="tight">
        <div className="shell-card u-glass u-shadow-soft shell-stack">
          <div className="feature-grid feature-grid--three">
            {SCHOOL_BENEFITS.map((benefit) => (
              <article key={benefit.title} className="feature-card shell-stack u-glass u-shadow-soft">
                <h3>{benefit.title}</h3>
                <p>{benefit.description}</p>
              </article>
            ))}
          </div>
          <div>
            <CTAButton href="/covermenow-one" variant="primary">
              Apply to Register
            </CTAButton>
          </div>
        </div>
      </Section>

      <Section variant="tight">
        <div className="shell-card u-glass u-shadow-soft u-glow-red schools-cta">
          <h2>Ready to stabilise emergency cover?</h2>
          <div className="schools-cta__actions">
            <CTAButton href="/covermenow-one" variant="primary">
              Apply to Register
            </CTAButton>
            <CTAButton href="/covermenow-one" variant="secondary">
              Apply to Register
            </CTAButton>
          </div>
        </div>
      </Section>
    </div>
  );
}
