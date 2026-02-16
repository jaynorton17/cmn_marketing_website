import type { Metadata } from "next";
import Image from "next/image";
import { icons } from "../../assets/assetRegistry";
import { buildPageMetadata } from "../../config/seo";
import CTAButton from "../../components/CTAButton";
import Section from "../../components/layout/Section";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = buildPageMetadata({
  title: "Daily Availability & Rewards for Candidates",
  description: "Daily Availability & Rewards for Candidates",
  canonicalPath: "/candidates",
});

const HOW_IT_WORKS = [
  {
    iconPath: icons.confirmedInAdvance,
    title: "Confirmed in advance",
    description: "Confirm availability the night before — you appear first.",
  },
  {
    iconPath: icons.visibleInstantly,
    title: "Visible instantly",
    description: "Once confirmed, you’re shown immediately to schools needing cover.",
  },
  {
    iconPath: icons.bookedInSeconds,
    title: "Booked in seconds",
    description: "Requests must be accepted within 10 minutes or they reset.",
  },
] as const;

const REWARD_BLOCKS = [
  {
    title: "Weekly Pay — Structured & Reliable",
    intro: "Work Friday to Thursday. Paid the following Friday. No waiting on school confirmations.",
    points: ["You complete the shift.", "The system logs it.", "Payroll runs automatically."],
    smallPrint:
      "Bookings not confirmed by schools by 5pm Thursday are auto-approved for payroll purposes only. Schools retain dispute rights under platform policy.",
  },
  {
    title: "Bronze Status — Earned at 30 Completed Shifts",
    points: [
      "One-off loyalty bonus",
      "Bonus equals your average daily pay from your last 30 completed shifts",
      "Official Bronze status recognition",
    ],
    closing: "Your first milestone. Structured. Transparent. Rewarded.",
    smallPrint:
      "Bonus is calculated from completed and approved shifts only. Cancelled or disputed shifts are excluded.",
  },
  {
    title: "Silver Status — Long-Term Professional Recognition",
    points: [
      "Higher structured reward multiplier",
      "Priority profile visibility",
      "Recognised long-term service",
    ],
    closing: "This is sustained professionalism recognised properly.",
    smallPrint:
      "Active service is measured from your first completed shift. Continuous engagement required.",
  },
  {
    title: "Gold Status — Senior Professional Tier",
    points: [
      "Enhanced tier multiplier",
      "Long-term loyalty acknowledgement",
      "Elevated standing within the CMN network",
    ],
    closing: "This is where consistency becomes career-level recognition.",
    smallPrint: "Tier progression is based on completed shifts and service duration.",
  },
  {
    title: "Elite Status — Top-Tier Recognition",
    points: [
      "1.5× loyalty bonus on every future 30-shift milestone",
      "Senior professional standing",
      "Highest structured reward tier",
    ],
    closing: "Elite status isn’t temporary. It’s earned reputation.",
    smallPrint:
      "Elite multiplier applies only to milestone bonuses (not weekly pay). Milestones must be completed in full 30-shift blocks.",
  },
  {
    title: "Transparent Conduct Framework",
    points: [
      "Structured no-show process",
      "Fair probation pathway",
      "Logged compliance history",
      "Fully auditable decisions",
    ],
    closing: "Clear rules. Logged actions. No hidden decisions.",
  },
  {
    title: "Learning Centre Access",
    points: [
      "Ongoing professional development",
      "Quizzes & proficiency checks",
      "CPD-style progression support",
    ],
    closing: "We reward reliability. We also invest in growth.",
    smallPrint: "Access subject to active profile and compliance completion.",
  },
] as const;

export default function CandidatesPage() {
  return (
    <div className="marketing-page candidates-page">
      <MarketingHero
        className="home-hero"
        backgroundId="bg_02"
        overlayGraphicId="gfx_04"
        heroImageId="hero_calendar_planner"
        heroImageAlt="Availability planner hero"
        eyebrow="For Candidates"
        title="Be visible earlier. Get booked faster."
        subtitle="Confirm once, stay visible, and build a stronger booking pipeline."
        primaryCta={{ label: "Register as a Candidate", href: "/covermenow-one" }}
        secondaryCta={{ label: "Enter CMN ONE", href: "/covermenow-one" }}
      />

      <Section title="How it works for candidates" variant="wide">
        <div className="shell-card u-glass u-shadow-soft shell-stack">
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
                <p>{item.description}</p>
              </article>
            ))}
          </div>
        </div>
      </Section>

      <Section title="Professional Rewards. Structured Growth. Fair Recognition." variant="tight">
        <div className="shell-card u-glass u-shadow-soft shell-stack">
          <p className="hero-lede">This isn’t gig work. It’s structured progression.</p>

          <div className="shell-stack">
            {REWARD_BLOCKS.map((block) => (
              <article key={block.title} className="feature-card shell-stack u-glass u-shadow-soft">
                <h3>{block.title}</h3>
                {"intro" in block ? <p>{block.intro}</p> : null}
                <ul className="bullet-list">
                  {block.points.map((point) => (
                    <li key={`${block.title}-${point}`}>{point}</li>
                  ))}
                </ul>
                {"closing" in block ? <p>{block.closing}</p> : null}
                {"smallPrint" in block ? (
                  <div className="shell-stack">
                    <p className="section-eyebrow">Small print</p>
                    <p>{block.smallPrint}</p>
                  </div>
                ) : null}
              </article>
            ))}
          </div>
        </div>
      </Section>

      <Section variant="tight">
        <div className="shell-card u-glass u-shadow-soft u-glow-red shell-stack">
          <h2 className="section-title">This isn’t agency chaos.</h2>
          <p className="hero-lede">It’s structured progression backed by technology.</p>
        </div>
      </Section>

      <Section variant="tight">
        <div className="shell-card u-glass u-shadow-soft u-glow-red candidates-cta">
          <h2>Ready to build structured progression?</h2>
          <div className="candidates-cta__actions">
            <CTAButton href="/covermenow-one" variant="primary">
              Register as a Candidate
            </CTAButton>
          </div>
        </div>
      </Section>
    </div>
  );
}
