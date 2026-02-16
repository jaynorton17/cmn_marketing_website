import type { ReactNode } from "react";
import AssetImage from "./AssetImage";
import type { BackgroundId, GraphicId } from "../assets/assetRegistry";

type MarketingHeroProps = {
  backgroundId: BackgroundId;
  overlayGraphicId?: GraphicId;
  overlayGraphicOpacity?: number;
  children: ReactNode;
  className?: string;
};

export default function MarketingHero({
  backgroundId,
  overlayGraphicId,
  overlayGraphicOpacity = 0.2,
  children,
  className,
}: MarketingHeroProps) {
  return (
    <section className={`hero-shell${className ? ` ${className}` : ""}`}>
      <div className="hero-shell__bg" aria-hidden="true">
        <AssetImage category="background" id={backgroundId} alt="" className="hero-shell__bg-image" priority />
      </div>

      {overlayGraphicId ? (
        <div className="hero-shell__graphic" style={{ opacity: overlayGraphicOpacity }} aria-hidden="true">
          <AssetImage category="graphic" id={overlayGraphicId} alt="" className="hero-shell__graphic-image" />
        </div>
      ) : null}

      <div className="hero-shell__overlay" aria-hidden="true" />
      <div className="hero-shell__content">{children}</div>
    </section>
  );
}
