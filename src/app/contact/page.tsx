import type { Metadata } from "next";
import { buildPageMetadata } from "../../config/seo";
import MarketingHero from "../../components/MarketingHero";
import ContactForm from "../../components/ContactForm";
import Section from "../../components/layout/Section";

export const metadata: Metadata = buildPageMetadata({
  title: "Apply to register",
  description: "Apply to register",
  canonicalPath: "/contact-us",
});

export default function ContactPage() {
  return (
    <div className="marketing-page contact-page">
      <MarketingHero
        className="home-hero contact-hero"
        backgroundId="bg_05"
        heroImageId="hero_compliance_documents"
        heroImageAlt="CMN ONE platform view"
        eyebrow="Contact"
        title="Let’s remove the chaos."
        subtitle="Tell us about your school and we’ll guide you through onboarding."
      />

      <Section>
        <div className="shell-card u-glass u-shadow-soft contact-layout">
          <div className="contact-layout__form">
            <h2>Complete the form and we’ll send registration details.</h2>
            <ContactForm />
          </div>

          <aside className="contact-layout__info shell-stack" aria-label="Contact details">
            <h2>Contact details</h2>
            <p>
              <strong>Email:</strong> hello@covermenow.co.uk
            </p>
            <p>
              We help schools and candidate communities operate emergency cover with speed, visibility, and consistent support.
            </p>
          </aside>
        </div>
      </Section>
    </div>
  );
}
