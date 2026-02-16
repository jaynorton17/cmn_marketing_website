import AssetImage from "./AssetImage";
import CTAButton, { type CTAButtonVariant } from "./CTAButton";
import {
  ASSETS,
  type BackgroundId,
  type GraphicId,
  type LaptopId,
} from "../assets/assetRegistry";

type HeroCta = {
  label: string;
  href: string;
  variant?: CTAButtonVariant;
};

type MarketingHeroProps = {
  backgroundId?: BackgroundId | string;
  overlayGraphicId?: GraphicId | string;
  laptopId?: LaptopId | string;
  title: string;
  subtitle: string;
  primaryCta?: HeroCta;
  secondaryCta?: HeroCta;
  className?: string;
  eyebrow?: string;
  showLogo?: boolean;
};

const FALLBACK_BACKGROUND_ID: BackgroundId = "bg_03";

function isBackgroundId(value: string | undefined): value is BackgroundId {
  if (!value) {
    return false;
  }

  return ASSETS.backgrounds.some((asset) => asset.id === value);
}

function isGraphicId(value: string | undefined): value is GraphicId {
  if (!value) {
    return false;
  }

  return ASSETS.graphics.some((asset) => asset.id === value);
}

function isLaptopId(value: string | undefined): value is LaptopId {
  if (!value) {
    return false;
  }

  return ASSETS.laptopui.some((asset) => asset.id === value);
}

export default function MarketingHero({
  backgroundId,
  overlayGraphicId,
  laptopId,
  title,
  subtitle,
  primaryCta,
  secondaryCta,
  className,
  eyebrow,
  showLogo = false,
}: MarketingHeroProps) {
  const resolvedBackgroundId = isBackgroundId(backgroundId) ? backgroundId : FALLBACK_BACKGROUND_ID;
  const resolvedOverlayId = isGraphicId(overlayGraphicId) ? overlayGraphicId : null;
  const resolvedLaptopId = isLaptopId(laptopId) ? laptopId : null;

  return (
    <section className={`hero-shell${className ? ` ${className}` : ""}`}>
      <div className="hero-shell__bg" aria-hidden="true">
        <AssetImage category="backgrounds" id={resolvedBackgroundId} alt="" className="hero-shell__bg-image" priority />
      </div>

      {resolvedOverlayId ? (
        <div className="hero-shell__graphic" style={{ opacity: 0.1 }} aria-hidden="true">
          <AssetImage category="graphics" id={resolvedOverlayId} alt="" className="hero-shell__graphic-image" />
        </div>
      ) : null}

      <div className="hero-shell__overlay" aria-hidden="true" />

      <div className="hero-shell__content">
        <div className={`hero-layout${resolvedLaptopId ? "" : " hero-layout--single"}`}>
          <div className="hero-copy shell-stack">
            {showLogo ? (
              <div className="home-hero__brand">
                <AssetImage category="logo" id={ASSETS.logo.id} alt="CoverMeNow ONE logo" className="home-hero__logo" />
              </div>
            ) : null}

            {eyebrow ? <p className="section-eyebrow">{eyebrow}</p> : null}

            <h1 className="hero-title">{title}</h1>
            <p className="hero-lede">{subtitle}</p>

            {primaryCta || secondaryCta ? (
              <div className="hero-actions">
                {primaryCta ? (
                  <CTAButton href={primaryCta.href} variant={primaryCta.variant ?? "primary"}>
                    {primaryCta.label}
                  </CTAButton>
                ) : null}
                {secondaryCta ? (
                  <CTAButton href={secondaryCta.href} variant={secondaryCta.variant ?? "secondary"}>
                    {secondaryCta.label}
                  </CTAButton>
                ) : null}
              </div>
            ) : null}
          </div>

          {resolvedLaptopId ? (
            <div className={showLogo ? "home-hero__device" : "hero-device-card"}>
              <div className={`hero-device-media${showLogo ? " home-hero__device-media" : ""}`}>
                <AssetImage category="laptopui" id={resolvedLaptopId} alt={`${title} dashboard preview`} className="hero-device-image" />
              </div>
            </div>
          ) : null}
        </div>
      </div>
    </section>
  );
}
