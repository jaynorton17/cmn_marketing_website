import "./globals.css";
import Link from "next/link";
import type { CSSProperties, ReactNode } from "react";
import type { Metadata } from "next";
import SiteHeader from "../components/layout/SiteHeader";
import { tokenCssVariables } from "../styles/tokens";
import { DEFAULT_DESCRIPTION, OG_IMAGE_PATH, SITE_NAME, TWITTER_CARD_TYPE } from "../config/seo";

const metadataBase = (() => {
  try {
    return new URL(process.env.NEXT_PUBLIC_SITE_URL ?? "https://covermenow.co.uk");
  } catch {
    return new URL("https://covermenow.co.uk");
  }
})();

export const metadata: Metadata = {
  metadataBase,
  title: {
    default: SITE_NAME,
    template: `${SITE_NAME} | %s`,
  },
  description: DEFAULT_DESCRIPTION,
  alternates: {
    canonical: "/",
  },
  openGraph: {
    type: "website",
    siteName: SITE_NAME,
    title: SITE_NAME,
    description: DEFAULT_DESCRIPTION,
    images: [{ url: OG_IMAGE_PATH }],
  },
  twitter: {
    card: TWITTER_CARD_TYPE,
    title: SITE_NAME,
    description: DEFAULT_DESCRIPTION,
    images: [OG_IMAGE_PATH],
  },
  icons: {
    icon: [{ url: "/favicon.png", type: "image/png" }],
    shortcut: [{ url: "/favicon.png", type: "image/png" }],
    apple: [{ url: "/favicon.png", type: "image/png" }],
  },
};

const bodyTokenStyle = tokenCssVariables as unknown as CSSProperties;

export default function RootLayout({ children }: { children: ReactNode }) {
  const year = new Date().getFullYear();

  return (
    <html lang="en">
      <body style={bodyTokenStyle}>
        <a className="skip-link" href="#main-content">
          Skip to content
        </a>

        <SiteHeader />

        <main id="main-content" className="site-shell__main">
          {children}
        </main>

        <footer className="site-shell__footer">
          <div className="shell-container site-shell__footer-inner">
            <p className="site-shell__tagline">CoverMeNow ONE — Real-time education cover.</p>
            <ul className="site-shell__footer-links">
              <li>
                <a href="/privacy">Privacy</a>
              </li>
              <li>
                <a href="/terms">Terms</a>
              </li>
              <li>
                <Link href="/contact-us">Contact</Link>
              </li>
            </ul>
            <p className="site-shell__copyright">© {year} CoverMeNow ONE</p>
          </div>
        </footer>
      </body>
    </html>
  );
}
