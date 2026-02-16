"use client";

import Link from "next/link";
import { useEffect, useId, useState } from "react";
import { usePathname } from "next/navigation";
import CTAButton from "../CTAButton";

type SiteHeaderProps = {
  showAssetsLink: boolean;
};

const NAV_ITEMS = [
  { href: "/", label: "Home" },
  { href: "/schools", label: "Schools" },
  { href: "/candidates", label: "Candidates" },
  { href: "/services", label: "Services" },
  { href: "/contact", label: "Contact" },
] as const;

export default function SiteHeader({ showAssetsLink }: SiteHeaderProps) {
  const pathname = usePathname();
  const mobileMenuId = useId();
  const [menuOpen, setMenuOpen] = useState(false);

  useEffect(() => {
    setMenuOpen(false);
  }, [pathname]);

  useEffect(() => {
    function handleEscape(event: KeyboardEvent) {
      if (event.key === "Escape") {
        setMenuOpen(false);
      }
    }

    window.addEventListener("keydown", handleEscape);
    return () => window.removeEventListener("keydown", handleEscape);
  }, []);

  return (
    <header className="site-shell__header u-glass u-shadow-soft">
      <div className="shell-container site-shell__header-inner">
        <Link className="site-shell__brand" href="/">
          CoverMeNow ONE
        </Link>

        <button
          type="button"
          className="site-shell__menu-toggle"
          aria-expanded={menuOpen ? "true" : "false"}
          aria-controls={mobileMenuId}
          onClick={() => setMenuOpen((current) => !current)}
        >
          <span className="site-shell__menu-toggle-label">Menu</span>
          <span className="site-shell__menu-toggle-bars" aria-hidden="true">
            <span />
            <span />
            <span />
          </span>
        </button>

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

      <div id={mobileMenuId} className={`site-shell__mobile-panel${menuOpen ? " is-open" : ""}`}>
        <div className="shell-container site-shell__mobile-panel-inner">
          <nav aria-label="Mobile navigation">
            <ul className="site-shell__mobile-nav">
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

          <div className="site-shell__mobile-ctas">
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
  );
}
