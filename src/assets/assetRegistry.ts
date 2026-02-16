export const icons = {
  confirmedInAdvance: "/images/icons/confirmed-in-advance.png",
  visibleInstantly: "/images/icons/visible-instantly.png",
  bookedInSeconds: "/images/icons/booked-in-seconds.png",
  vettedCandidates: "/images/icons/vetted-candidates.png",
  clearBookingHistory: "/images/icons/clear-booking-history.png",
  supportEscalation: "/images/icons/support-escalation.png",
} as const;

export const ASSETS = {
  backgrounds: [
    { id: "bg_01", path: "/images/backgrounds/ChatGPT Image Feb 16, 2026, 04_36_14 AM.png" },
    { id: "bg_02", path: "/images/backgrounds/ChatGPT Image Feb 16, 2026, 04_36_15 AM.png" },
    { id: "bg_03", path: "/images/backgrounds/ChatGPT Image Feb 16, 2026, 04_36_16 AM.png" },
    { id: "bg_04", path: "/images/backgrounds/ChatGPT Image Feb 16, 2026, 04_36_17 AM.png" },
    { id: "bg_05", path: "/images/backgrounds/ChatGPT Image Feb 16, 2026, 04_36_18 AM.png" },
  ],
  graphics: [
    { id: "gfx_01", path: "/images/graphics/ChatGPT Image Feb 16, 2026, 04_35_47 AM.png" },
    { id: "gfx_02", path: "/images/graphics/ChatGPT Image Feb 16, 2026, 04_35_48 AM.png" },
    { id: "gfx_03", path: "/images/graphics/ChatGPT Image Feb 16, 2026, 04_35_49 AM.png" },
    { id: "gfx_04", path: "/images/graphics/ChatGPT Image Feb 16, 2026, 04_35_50 AM.png" },
    { id: "gfx_05", path: "/images/graphics/ChatGPT Image Feb 16, 2026, 04_35_53 AM.png" },
    { id: "gfx_06", path: "/images/graphics/ChatGPT Image Feb 16, 2026, 04_35_54 AM.png" },
  ],
  icons: [
    { id: "icon_01", path: icons.confirmedInAdvance },
    { id: "icon_02", path: icons.visibleInstantly },
    { id: "icon_03", path: icons.bookedInSeconds },
    { id: "icon_04", path: icons.clearBookingHistory },
    { id: "icon_05", path: icons.vettedCandidates },
    { id: "icon_06", path: icons.clearBookingHistory },
    { id: "icon_07", path: icons.supportEscalation },
  ],
  laptopui: [
    { id: "laptop_01", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_35_56 AM.png" },
    { id: "laptop_02", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_35_57 AM.png" },
    { id: "laptop_03", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_35_58 AM.png" },
    { id: "laptop_04", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_35_59 AM.png" },
    { id: "laptop_05", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_36_02 AM.png" },
    { id: "laptop_06", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_36_03 AM.png" },
    { id: "laptop_07", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_36_04 AM.png" },
    { id: "laptop_08", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_36_05 AM.png" },
    { id: "laptop_09", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_36_07 AM.png" },
    { id: "laptop_10", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_36_08 AM.png" },
    { id: "laptop_11", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_36_11 AM.png" },
    { id: "laptop_12", path: "/images/laptopui/ChatGPT Image Feb 16, 2026, 04_36_12 AM.png" },
  ],
  // Heroes (Portal-based marketing renders)
  heroes: [
    { id: "hero_availability_confirmation", path: "/images/heroes/hero-availability-confirmation.png" },
    { id: "hero_calendar_planner", path: "/images/heroes/hero-calendar-planner.png" },
    { id: "hero_compliance_documents", path: "/images/heroes/hero-compliance-documents.png" },
    { id: "hero_finance_dashboard", path: "/images/heroes/hero-finance-dashboard.png" },
    { id: "hero_booking_history", path: "/images/heroes/hero-booking-history.png" },
  ],
  logo: {
    id: "logo_main",
    path: "/images/logo/ChatGPT Image Feb 4, 2026, 07_36_30 AM.png",
  },
} as const;

type ArrayItem<T> = T extends readonly (infer U)[] ? U : never;

export type BackgroundId = ArrayItem<typeof ASSETS.backgrounds>["id"];
export type GraphicId = ArrayItem<typeof ASSETS.graphics>["id"];
export type IconId = ArrayItem<typeof ASSETS.icons>["id"];
export type LaptopId = ArrayItem<typeof ASSETS.laptopui>["id"];
export type HeroId = ArrayItem<typeof ASSETS.heroes>["id"];

export function getBackground(id: BackgroundId) {
  return ASSETS.backgrounds.find((x) => x.id === id)!;
}

export function getGraphic(id: GraphicId) {
  return ASSETS.graphics.find((x) => x.id === id)!;
}

export function getIcon(id: IconId) {
  return ASSETS.icons.find((x) => x.id === id)!;
}

export function getLaptop(id: LaptopId) {
  return ASSETS.laptopui.find((x) => x.id === id)!;
}

export function getHero(id: HeroId) {
  return ASSETS.heroes.find((x) => x.id === id)!;
}
