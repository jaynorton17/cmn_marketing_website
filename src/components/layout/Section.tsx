import type { ReactNode } from "react";

type SectionVariant = "default" | "tight" | "wide";

type SectionProps = {
  title?: string;
  subtitle?: string;
  children: ReactNode;
  variant?: SectionVariant;
  id?: string;
};

export default function Section({
  title,
  subtitle,
  children,
  variant = "default",
  id,
}: SectionProps) {
  const hasHeader = Boolean(title || subtitle);

  return (
    <section id={id} className={`section-rhythm section-rhythm--${variant}`}>
      <div className="shell-container section-rhythm__inner">
        {hasHeader ? (
          <header className="section-rhythm__header shell-stack">
            {title ? <h2 className="section-title">{title}</h2> : null}
            {subtitle ? <p className="hero-lede">{subtitle}</p> : null}
          </header>
        ) : null}
        {children}
      </div>
    </section>
  );
}
