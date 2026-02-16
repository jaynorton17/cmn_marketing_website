import Image from "next/image";
import type { CSSProperties } from "react";
import {
  ASSETS,
  getBackground,
  getGraphic,
  getHero,
  getIcon,
  getLaptop,
  type BackgroundId,
  type GraphicId,
  type HeroId,
  type IconId,
  type LaptopId,
} from "../assets/assetRegistry";

type AssetCategory =
  | "background"
  | "backgrounds"
  | "graphic"
  | "graphics"
  | "hero"
  | "heroes"
  | "icon"
  | "icons"
  | "laptop"
  | "laptopui"
  | "logo";

export type AssetImageProps = {
  category?: AssetCategory;
  id: string;
  alt?: string;
  className?: string;
  priority?: boolean;
  width?: number;
  height?: number;
  sizes?: string;
  quality?: number;
  decorative?: boolean;
  style?: CSSProperties;
};

type NormalizedCategory = "backgrounds" | "graphics" | "heroes" | "icons" | "laptopui" | "logo";

function normalizeCategory(category: AssetCategory): NormalizedCategory {
  if (category === "background" || category === "backgrounds") {
    return "backgrounds";
  }
  if (category === "graphic" || category === "graphics") {
    return "graphics";
  }
  if (category === "hero" || category === "heroes") {
    return "heroes";
  }
  if (category === "icon" || category === "icons") {
    return "icons";
  }
  if (category === "laptop" || category === "laptopui") {
    return "laptopui";
  }
  return "logo";
}

function inferCategoryFromId(id: string): NormalizedCategory | null {
  if (id === ASSETS.logo.id) {
    return "logo";
  }
  if (ASSETS.backgrounds.some((asset) => asset.id === id)) {
    return "backgrounds";
  }
  if (ASSETS.graphics.some((asset) => asset.id === id)) {
    return "graphics";
  }
  if (ASSETS.heroes.some((asset) => asset.id === id)) {
    return "heroes";
  }
  if (ASSETS.icons.some((asset) => asset.id === id)) {
    return "icons";
  }
  if (ASSETS.laptopui.some((asset) => asset.id === id)) {
    return "laptopui";
  }

  return null;
}

function resolvePath(category: AssetCategory | undefined, id: string): { category: NormalizedCategory | null; path: string | null } {
  const normalizedCategory = category ? normalizeCategory(category) : inferCategoryFromId(id);
  if (!normalizedCategory) {
    return { category: null, path: null };
  }

  if (normalizedCategory === "logo") {
    // Always resolve logo from a single source of truth.
    return { category: "logo", path: ASSETS.logo.path };
  }

  try {
    if (normalizedCategory === "backgrounds") {
      return { category: "backgrounds", path: getBackground(id as BackgroundId)?.path ?? null };
    }
    if (normalizedCategory === "graphics") {
      return { category: "graphics", path: getGraphic(id as GraphicId)?.path ?? null };
    }
    if (normalizedCategory === "heroes") {
      return { category: "heroes", path: getHero(id as HeroId)?.path ?? null };
    }
    if (normalizedCategory === "icons") {
      return { category: "icons", path: getIcon(id as IconId)?.path ?? null };
    }
    return { category: "laptopui", path: getLaptop(id as LaptopId)?.path ?? null };
  } catch (error) {
    if (process.env.NODE_ENV !== "production") {
      console.warn(`AssetImage failed to resolve ${normalizedCategory}:${id}`, error);
    }
    return { category: normalizedCategory, path: null };
  }
}

function resolveIntrinsicSize(
  category: NormalizedCategory,
): { width: number; height: number } {
  switch (category) {
    case "backgrounds":
      return { width: 1920, height: 1080 };
    case "graphics":
      return { width: 1400, height: 900 };
    case "heroes":
      return { width: 1920, height: 1080 };
    case "icons":
      return { width: 512, height: 512 };
    case "laptopui":
      return { width: 1600, height: 1000 };
    default:
      return { width: 1200, height: 360 };
  }
}

function resolveSizes(category: NormalizedCategory): string {
  switch (category) {
    case "backgrounds":
      return "100vw";
    case "graphics":
      return "(min-width: 1200px) 1200px, (min-width: 1024px) 80vw, 100vw";
    case "heroes":
      return "(min-width: 1200px) 700px, (min-width: 1024px) 56vw, 100vw";
    case "icons":
      return "(min-width: 1200px) 56px, (min-width: 760px) 48px, 40px";
    case "laptopui":
      return "(min-width: 1200px) 620px, (min-width: 1024px) 50vw, 100vw";
    default:
      return "(min-width: 1024px) 180px, 140px";
  }
}

function resolveQuality(category: NormalizedCategory): number {
  if (category === "backgrounds") {
    return 72;
  }
  if (category === "graphics" || category === "heroes") {
    return 74;
  }
  return 78;
}

export default function AssetImage({
  category,
  id,
  alt,
  className,
  priority = false,
  width,
  height,
  sizes,
  quality,
  decorative = false,
  style,
}: AssetImageProps) {
  const resolvedAsset = resolvePath(category, id);
  const normalizedCategory = resolvedAsset.category ?? "graphics";
  const resolvedPath = resolvedAsset.path;
  const intrinsic = resolveIntrinsicSize(normalizedCategory);

  if (!resolvedPath) {
    const fallbackText = `Missing asset: ${category}:${id}`;
    if (process.env.NODE_ENV !== "production") {
      console.warn(fallbackText);
    }

    return (
      <div className={className}>
        <div className="asset-missing-fallback">{fallbackText}</div>
      </div>
    );
  }

  const resolvedAlt = decorative ? "" : (alt ?? "");
  const resolvedSizes = sizes ?? resolveSizes(normalizedCategory);
  const resolvedQuality = quality ?? resolveQuality(normalizedCategory);

  return (
    <Image
      src={resolvedPath}
      alt={resolvedAlt}
      width={width ?? intrinsic.width}
      height={height ?? intrinsic.height}
      sizes={resolvedSizes}
      quality={resolvedQuality}
      priority={priority}
      className={className}
      style={style}
      aria-hidden={decorative ? true : undefined}
    />
  );
}
