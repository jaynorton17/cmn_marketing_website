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

type AssetCategory = "background" | "graphic" | "icon" | "laptop" | "logo";

export type AssetImageProps = {
  category: AssetCategory;
  id: string;
  alt?: string;
  className?: string;
  priority?: boolean;
};

function resolvePath(category: AssetCategory, id: string): string | null {
  if (category === "logo") {
    if (id !== ASSETS.logo.id) {
      console.warn(`AssetImage expected logo id "${ASSETS.logo.id}" but received "${id}"`);
    }
    return ASSETS.logo.path;
  }

  try {
    if (category === "background") {
      return getBackground(id as BackgroundId)?.path ?? null;
    }
    if (category === "graphic") {
      return getGraphic(id as GraphicId)?.path ?? null;
    }
    if (category === "icon") {
      return getIcon(id as IconId)?.path ?? null;
    }
    return getLaptop(id as LaptopId)?.path ?? null;
  } catch (error) {
    console.warn(`AssetImage failed to resolve ${category}:${id}`, error);
    return null;
  }
}

export default function AssetImage({ category, id, alt, className, priority = false }: AssetImageProps) {
  const resolvedPath = resolvePath(category, id);

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
      className={className}
      onError={() => console.warn(`Missing asset file: ${resolvedPath}`)}
    />
  );
}
