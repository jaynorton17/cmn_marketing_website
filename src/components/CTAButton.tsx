import Link from "next/link";
import type { ReactNode } from "react";

export type CTAButtonVariant = "primary" | "secondary" | "ghost";

type CTAButtonProps = {
  href: string;
  children: ReactNode;
  variant?: CTAButtonVariant;
  className?: string;
  newTab?: boolean;
  ariaLabel?: string;
};

function isExternalHref(href: string): boolean {
  return /^(https?:)?\/\//.test(href) || href.startsWith("mailto:") || href.startsWith("tel:");
}

function buildClassName(variant: CTAButtonVariant, className?: string): string {
  return `btn btn--${variant}${className ? ` ${className}` : ""}`;
}

export default function CTAButton({
  href,
  children,
  variant = "primary",
  className,
  newTab = false,
  ariaLabel,
}: CTAButtonProps) {
  const resolvedClassName = buildClassName(variant, className);

  if (isExternalHref(href)) {
    return (
      <a
        href={href}
        className={resolvedClassName}
        target={newTab ? "_blank" : undefined}
        rel={newTab ? "noopener noreferrer" : undefined}
        aria-label={ariaLabel}
      >
        {children}
      </a>
    );
  }

  return (
    <Link href={href} className={resolvedClassName} aria-label={ariaLabel}>
      {children}
    </Link>
  );
}
