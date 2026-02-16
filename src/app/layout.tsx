import "./globals.css";
import Link from "next/link";
import type { CSSProperties, ReactNode } from "react";
import CTAButton from "../components/CTAButton";
import { tokenCssVariables } from "../styles/tokens";

export const metadata = {
  title: {
    default: "CoverMeNow ONE",
    template: "%s | CoverMeNow ONE",
  },
  description: "Real-time recruitment infrastructure for education cover.",
};

const NAV_ITEMS = [
  { href: "/", label: "Home" },
  { href: "/schools", label: "Schools" },
  { href: "/candidates", label: "Candidates" },
  { href: "/services", label: "Services" },
  { href: "/contact", label: "Contact" },
] as const;

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

        <header className="site-shell__header u-glass u-shadow-soft">
          <div className="shell-container site-shell__header-inner">
            <Link className="site-shell__brand" href="/">
              CoverMeNow ONE
            </Link>

            <div className="site-shell__header-right">
              <nav aria-label="Global navigation">
                <ul className="site-shell__nav">
                  {NAV_ITEMS.map((item) => (
                    <li key={item.href}>
                      <Link href={item.href}>{item.label}</Link>
                    </li>
                  ))}
                  {showAssetsLink ? (
                    <li>
                      <Link href="/assets">Assets</Link>
                    </li>
                  ) : null}
                </ul>
              </nav>

              <div className="site-shell__header-ctas">
                <CTAButton href="/contact-us" variant="secondary">
                  Book a Demo
                </CTAButton>
                <CTAButton href="/covermenow-one" variant="primary">
                  Enter CMN ONE
                </CTAButton>
              </div>
            </div>
          </div>
        </header>

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
