export const colors = {
  bg: "#0b0c10",
  surface: "rgba(22, 24, 30, 0.82)",
  border: "rgba(255, 255, 255, 0.1)",
  text: "#e7e9ee",
  muted: "#a2a8b2",
  redPrimary: "#d02a2a",
  redGlow: "rgba(208, 42, 42, 0.22)",
} as const;

export const radii = {
  sm: "0.5rem",
  md: "0.9rem",
  lg: "1rem",
  xl: "1.15rem",
  pill: "999px",
} as const;

export const shadows = {
  soft: "0 22px 50px rgba(0, 0, 0, 0.42)",
  glass: "0 18px 40px rgba(0, 0, 0, 0.38)",
} as const;

export const spacing = {
  xs: "0.35rem",
  sm: "0.6rem",
  md: "1rem",
  lg: "1.25rem",
  xl: "1.7rem",
} as const;

export const tokenCssVariables = {
  "--token-color-bg": colors.bg,
  "--token-color-surface": colors.surface,
  "--token-color-border": colors.border,
  "--token-color-text": colors.text,
  "--token-color-muted": colors.muted,
  "--token-color-red-primary": colors.redPrimary,
  "--token-color-red-glow": colors.redGlow,
  "--token-radius-sm": radii.sm,
  "--token-radius-md": radii.md,
  "--token-radius-lg": radii.lg,
  "--token-radius-xl": radii.xl,
  "--token-radius-pill": radii.pill,
  "--token-shadow-soft": shadows.soft,
  "--token-shadow-glass": shadows.glass,
  "--token-spacing-xs": spacing.xs,
  "--token-spacing-sm": spacing.sm,
  "--token-spacing-md": spacing.md,
  "--token-spacing-lg": spacing.lg,
  "--token-spacing-xl": spacing.xl,
} as const;
