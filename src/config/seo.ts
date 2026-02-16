import type { Metadata } from "next";
import { getGraphic, type GraphicId } from "../assets/assetRegistry";

export const SITE_NAME = "CoverMeNow ONE";
export const DEFAULT_DESCRIPTION = "Real-time availability. Faster bookings. Better cover.";
export const OG_IMAGE_ID: GraphicId = "gfx_03";
export const OG_IMAGE_PATH = getGraphic(OG_IMAGE_ID).path;
export const TWITTER_CARD_TYPE = "summary_large_image";

type BuildPageMetadataParams = {
  title: string;
  description?: string;
  canonicalPath: `/${string}` | "/";
};

export function buildPageMetadata({
  title,
  description,
  canonicalPath,
}: BuildPageMetadataParams): Metadata {
  const resolvedDescription = description ?? title;
  const socialTitle = `${SITE_NAME} | ${title}`;

  return {
    title,
    description: resolvedDescription,
    alternates: {
      canonical: canonicalPath,
    },
    openGraph: {
      type: "website",
      title: socialTitle,
      description: resolvedDescription,
      images: [{ url: OG_IMAGE_PATH }],
    },
    twitter: {
      card: TWITTER_CARD_TYPE,
      title: socialTitle,
      description: resolvedDescription,
      images: [OG_IMAGE_PATH],
    },
  };
}
