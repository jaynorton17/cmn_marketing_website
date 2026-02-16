"use client";

import {
  ASSETS,
  getBackground,
  getGraphic,
  getIcon,
  getLaptop,
  type BackgroundId,
  type GraphicId,
  type IconId,
  type LaptopId,
} from "../assets/assetRegistry";

type AssetCategory =
  | "background"
  | "backgrounds"
  | "graphic"
  | "graphics"
  | "icon"
  | "icons"
  | "laptop"
  | "laptopui"
  | "logo";

export type AssetImageProps = {
  category: AssetCategory;
  id: string;
  alt?: string;
  className?: string;
  priority?: boolean;
  width?: number;
  height?: number;
};

function normalizeCategory(category: AssetCategory): "backgrounds" | "graphics" | "icons" | "laptopui" | "logo" {
  if (category === "background" || category === "backgrounds") {
    return "backgrounds";
  }
  if (category === "graphic" || category === "graphics") {
    return "graphics";
  }
  if (category === "icon" || category === "icons") {
    return "icons";
  }
  if (category === "laptop" || category === "laptopui") {
    return "laptopui";
  }
  return "logo";
}

function resolvePath(category: AssetCategory, id: string): string | null {
  const normalizedCategory = normalizeCategory(category);

  if (normalizedCategory === "logo") {
    if (id !== ASSETS.logo.id) {
      console.warn(`AssetImage expected logo id "${ASSETS.logo.id}" but received "${id}"`);
    }
    return ASSETS.logo.path;
  }

  try {
    if (normalizedCategory === "backgrounds") {
      return getBackground(id as BackgroundId)?.path ?? null;
    }
    if (normalizedCategory === "graphics") {
      return getGraphic(id as GraphicId)?.path ?? null;
    }
    if (normalizedCategory === "icons") {
      return getIcon(id as IconId)?.path ?? null;
    }
    return getLaptop(id as LaptopId)?.path ?? null;
  } catch (error) {
    console.warn(`AssetImage failed to resolve ${normalizedCategory}:${id}`, error);
    return null;
  }
}

function resolveIntrinsicSize(
  category: "backgrounds" | "graphics" | "icons" | "laptopui" | "logo",
): { width: number; height: number } {
  switch (category) {
    case "backgrounds":
      return { width: 1920, height: 1080 };
    case "graphics":
      return { width: 1400, height: 900 };
    case "icons":
      return { width: 512, height: 512 };
    case "laptopui":
      return { width: 1600, height: 1000 };
    default:
      return { width: 1200, height: 360 };
  }
}

export default function AssetImage({ category, id, alt, className, priority = false, width, height }: AssetImageProps) {
  const normalizedCategory = normalizeCategory(category);
  const resolvedPath = resolvePath(category, id);
  const intrinsic = resolveIntrinsicSize(normalizedCategory);

  if (!resolvedPath) {
    const fallbackText = `Missing asset: ${category}:${id}`;
    console.warn(fallbackText);

    return (
      <div className={className}>
        <div className="asset-missing-fallback">{fallbackText}</div>
      </div>
    );
  }

  return (
    <img
      src={resolvedPath}
      alt={alt ?? ""}
      loading={priority ? "eager" : "lazy"}
      fetchPriority={priority ? "high" : "auto"}
      decoding="async"
      width={width ?? intrinsic.width}
      height={height ?? intrinsic.height}
      className={className}
      onError={() => console.warn(`Missing asset file: ${resolvedPath}`)}
    />
  );
}
