import type { Metadata } from "next";
import AssetImage from "../../components/AssetImage";
import Section from "../../components/layout/Section";
import MarketingHero from "../../components/MarketingHero";

export const metadata: Metadata = {
  title: "Services",
  description: "Everything you need to run emergency cover properly.",
};

const SERVICES = [
  {
    title: "Live Availability",
    iconId: "icon_01",
    copy: "Real-time candidate status gives coordinators immediate visibility before urgent shifts begin.",
  },
  {
    title: "Booking Management",
    iconId: "icon_06",
    copy: "From request to confirmation, every booking step is logged in one consistent operating flow.",
  },
  {
    title: "Compliance Tracking",
    iconId: "icon_05",
    copy: "Maintain auditable records for checks and assignment history without fragmented admin processes.",
  },
  {
    title: "Support & Escalations",
    iconId: "icon_07",
    copy: "Dedicated support pathways handle urgent issues quickly, with clear escalation structure when needed.",
  },
] as const;

export default function ServicesPage() {
  return (
    <div className="marketing-page">
      <div className="shell-container page-hero-wrap">
        <MarketingHero
          backgroundId="bg_04"
          laptopId="laptop_01"
          eyebrow="Platform Services"
          title="Services"
          subtitle="Everything you need to run emergency cover properly."
        />
      </div>

      <Section>
        <div className="shell-card u-glass u-shadow-soft shell-stack">
          <header className="section-head shell-stack">
            <p className="section-eyebrow">Core Infrastructure</p>
            <h2 className="section-title">Platform-led service modules</h2>
          </header>
          <div className="feature-grid feature-grid--two">
            {SERVICES.map((item) => (
              <article key={item.title} className="feature-card shell-stack u-glass u-shadow-soft">
                <div className="feature-card__icon">
                  <AssetImage category="icon" id={item.iconId} alt={item.title} className="feature-card__icon-image" />
                </div>
                <h3>{item.title}</h3>
                <p>{item.copy}</p>
              </article>
            ))}
          </div>
        </div>
      </Section>
    </div>
  );
}
