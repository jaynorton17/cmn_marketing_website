import "./globals.css";
import Link from "next/link";
import type { CSSProperties, ReactNode } from "react";
import SiteHeader from "../components/layout/SiteHeader";
import { tokenCssVariables } from "../styles/tokens";

export const metadata = {
  title: {
    default: "CoverMeNow ONE",
    template: "%s | CoverMeNow ONE",
  },
  description: "Real-time recruitment infrastructure for education cover.",
};

const bodyTokenStyle = tokenCssVariables as unknown as CSSProperties;

export default function RootLayout({ children }: { children: ReactNode }) {
  const year = new Date().getFullYear();
  const showAssetsLink = process.env.NODE_ENV !== "production";

  return (
    <html lang="en">
      <body style={bodyTokenStyle}>
        <a className="skip-link" href="#main-content">
          Skip to content
        </a>

        <SiteHeader showAssetsLink={showAssetsLink} />

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
                <Link href="/contact">Contact</Link>
              </li>
            </ul>
            <p className="site-shell__copyright">© {year} CoverMeNow ONE</p>
          </div>
        </footer>
      </body>
    </html>
  );
}
