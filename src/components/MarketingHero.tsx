import AssetImage from "./AssetImage";
import CTAButton, { type CTAButtonVariant } from "./CTAButton";
import {
  ASSETS,
  type BackgroundId,
  type GraphicId,
  type HeroId,
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
  heroImageId?: HeroId | string;
  heroImageAlt?: string;
  secondaryHeroImageId?: HeroId | string;
  secondaryHeroImageAlt?: string;
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

function isHeroId(value: string | undefined): value is HeroId {
  if (!value) {
    return false;
  }

  return ASSETS.heroes.some((asset) => asset.id === value);
}

export default function MarketingHero({
  backgroundId,
  overlayGraphicId,
  heroImageId,
  heroImageAlt,
  secondaryHeroImageId,
  secondaryHeroImageAlt,
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
  const resolvedHeroImageId = isHeroId(heroImageId) ? heroImageId : null;
  const resolvedSecondaryHeroImageId = isHeroId(secondaryHeroImageId) ? secondaryHeroImageId : null;
  const resolvedLaptopId = isLaptopId(laptopId) ? laptopId : null;
  const hasVisualMedia = Boolean(resolvedHeroImageId || resolvedLaptopId);
  const hasHeroPair = Boolean(resolvedHeroImageId && resolvedSecondaryHeroImageId);
  const usePortalHeroWrapper = Boolean(resolvedHeroImageId);
  const heroDeviceClassName = `${showLogo || usePortalHeroWrapper ? "hero-device-card home-hero__device u-glow-red" : "hero-device-card"}${
    hasHeroPair ? " hero-device-card--pair" : ""
  }`;
  const heroMediaClassName = `hero-device-media hero-media-wrap${showLogo || usePortalHeroWrapper ? " home-hero__device-media" : ""}`;

  return (
    <section className={`hero-shell u-shadow-soft${className ? ` ${className}` : ""}`}>
      <div className="hero-shell__bg" aria-hidden="true">
        <AssetImage
          category="backgrounds"
          id={resolvedBackgroundId}
          alt=""
          decorative
          className="hero-shell__bg-image"
          priority
        />
      </div>

      {resolvedOverlayId ? (
        <div className="hero-shell__graphic" style={{ opacity: 0.1 }} aria-hidden="true">
          <AssetImage category="graphics" id={resolvedOverlayId} alt="" decorative className="hero-shell__graphic-image" />
        </div>
      ) : null}

      <div className="hero-shell__overlay u-glow-red" aria-hidden="true" />

      <div className="hero-shell__content">
        <div className={`hero-layout${hasVisualMedia ? "" : " hero-layout--single"}`}>
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

          {hasVisualMedia ? (
            <div className={heroDeviceClassName}>
              {hasHeroPair && resolvedHeroImageId && resolvedSecondaryHeroImageId ? (
                <div className="hero-device-pair">
                  <div className={heroMediaClassName}>
                    <AssetImage
                      id={resolvedHeroImageId}
                      alt={heroImageAlt ?? `${title} primary hero visual`}
                      className="hero-device-image"
                      priority={showLogo}
                    />
                  </div>
                  <div className={`${heroMediaClassName} hero-device-media--secondary`}>
                    <AssetImage
                      id={resolvedSecondaryHeroImageId}
                      alt={secondaryHeroImageAlt ?? `${title} secondary hero visual`}
                      className="hero-device-image"
                      priority={false}
                    />
                  </div>
                </div>
              ) : (
                <div className={heroMediaClassName}>
                  {resolvedHeroImageId ? (
                    <AssetImage
                      id={resolvedHeroImageId}
                      alt={heroImageAlt ?? `${title} hero visual`}
                      className="hero-device-image"
                      priority={showLogo}
                    />
                  ) : resolvedLaptopId ? (
                    <AssetImage
                      category="laptopui"
                      id={resolvedLaptopId}
                      alt={`${title} dashboard preview`}
                      className="hero-device-image"
                      priority={showLogo}
                    />
                  ) : null}
                </div>
              )}
            </div>
          ) : null}
        </div>
      </div>
    </section>
  );
}
