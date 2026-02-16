import type { Metadata } from "next";
import MarketingHero from "../../components/MarketingHero";
import ContactForm from "../../components/ContactForm";

export const metadata: Metadata = {
  title: "Contact",
  description: "Let's get your school onboarded.",
};

export default function ContactPage() {
  return (
    <div className="shell-container shell-stack marketing-page">
      <MarketingHero
        backgroundId="bg_05"
        eyebrow="Contact"
        title="Contact"
        subtitle="Let's get your school onboarded."
      />

      <section className="shell-card contact-layout">
        <div className="contact-layout__form">
          <h2>Start the conversation</h2>
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
      </section>
    </div>
  );
}
