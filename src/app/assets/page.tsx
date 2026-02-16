"use client";

import { useMemo, useState } from "react";
import { ASSETS } from "../../assets/assetRegistry";
import type { ReactNode } from "react";
import AssetImage from "../../components/AssetImage";

type AssetItem = {
  id: string;
  path: string;
};

type CategoryKey = "all" | "logo" | "backgrounds" | "graphics" | "icons" | "laptopui";

type SectionConfig = {
  key: Exclude<CategoryKey, "all">;
  label: string;
  previewClassName: string;
  imageCategory: "background" | "graphic" | "icon" | "laptop" | "logo";
  wrapperClassName?: string;
  items: readonly AssetItem[];
};

const SECTION_CONFIG: SectionConfig[] = [
  {
    key: "backgrounds",
    label: "Backgrounds",
    previewClassName: "asset-preview--background",
    imageCategory: "background",
    wrapperClassName: "shell-stack",
    items: ASSETS.backgrounds,
  },
  {
    key: "graphics",
    label: "Graphics",
    previewClassName: "asset-preview--graphic",
    imageCategory: "graphic",
    wrapperClassName: "asset-grid asset-grid--graphics",
    items: ASSETS.graphics,
  },
  {
    key: "icons",
    label: "Icons",
    previewClassName: "asset-preview--icon",
    imageCategory: "icon",
    wrapperClassName: "asset-grid asset-grid--icons",
    items: ASSETS.icons,
  },
  {
    key: "laptopui",
    label: "Laptop UI",
    previewClassName: "asset-preview--laptop",
    imageCategory: "laptop",
    wrapperClassName: "asset-grid asset-grid--laptop",
    items: ASSETS.laptopui,
  },
  {
    key: "logo",
    label: "Logo",
    previewClassName: "asset-preview--logo",
    imageCategory: "logo",
    wrapperClassName: "shell-stack",
    items: [ASSETS.logo],
  },
];

async function copyText(value: string): Promise<boolean> {
  if (typeof window === "undefined") {
    return false;
  }

  if (navigator.clipboard && typeof navigator.clipboard.writeText === "function") {
    await navigator.clipboard.writeText(value);
    return true;
  }

  const input = document.createElement("textarea");
  input.value = value;
  input.setAttribute("readonly", "readonly");
  input.style.position = "absolute";
  input.style.left = "-9999px";
  document.body.appendChild(input);
  input.select();

  let copied = false;
  try {
    copied = document.execCommand("copy");
  } finally {
    document.body.removeChild(input);
  }

  return copied;
}

function AssetMeta({ id, path, onCopyId, copied }: AssetItem & { onCopyId: (id: string) => void; copied: boolean }) {
  return (
    <div className="asset-meta shell-stack">
      <p className="asset-meta__id">
        <strong>ID:</strong> <code>{id}</code>
      </p>
      <p className="asset-meta__path">
        <strong>Path:</strong> <code>{path}</code>
      </p>
      <div className="asset-meta__actions">
        <button className="asset-copy" type="button" onClick={() => onCopyId(id)}>
          {copied ? "Copied" : "Copy ID"}
        </button>
      </div>
    </div>
  );
}

function AssetSection({
  title,
  children,
  count,
}: {
  title: string;
  children: ReactNode;
  count: number;
}) {
  const sectionId = `section-${title.toLowerCase().replace(/\s+/g, "-")}`;

  return (
    <section className="shell-card shell-stack" aria-labelledby={sectionId}>
      <h2 id={sectionId} className="asset-section__title">
        {title} <span className="asset-section__count">({count})</span>
      </h2>
      {children}
    </section>
  );
}

export default function AssetsPage() {
  const [category, setCategory] = useState<CategoryKey>("all");
  const [search, setSearch] = useState("");
  const [copiedId, setCopiedId] = useState<string | null>(null);

  const normalizedSearch = search.trim().toLowerCase();

  const visibleSections = useMemo(() => {
    return SECTION_CONFIG.map((section) => {
      const filteredItems = section.items.filter((asset) => {
        if (normalizedSearch.length === 0) {
          return true;
        }
        return asset.id.toLowerCase().includes(normalizedSearch);
      });

      return {
        ...section,
        items: filteredItems,
      };
    }).filter((section) => {
      if (category !== "all" && section.key !== category) {
        return false;
      }
      return section.items.length > 0;
    });
  }, [category, normalizedSearch]);

  const visibleAssetCount = visibleSections.reduce((total, section) => total + section.items.length, 0);

  async function handleCopyId(id: string) {
    try {
      const copied = await copyText(id);
      if (!copied) {
        return;
      }

      setCopiedId(id);
      window.setTimeout(() => {
        setCopiedId((current) => (current === id ? null : current));
      }, 900);
    } catch (error) {
      console.warn("Failed to copy asset ID", error);
    }
  }

  return (
    <div className="shell-container shell-stack asset-page">
      <header className="shell-stack asset-page__header">
        <p className="section-eyebrow">Registry</p>
        <h1 className="asset-page__title">Asset Preview</h1>
        <p className="asset-page__lede">
          Internal validation page for asset ID-to-path mapping from <code>ASSETS</code>.
        </p>
      </header>

      <section className="shell-card shell-stack asset-toolbar" aria-label="Asset filters">
        <div className="asset-toolbar__field shell-stack">
          <label htmlFor="asset-category">Category</label>
          <select id="asset-category" value={category} onChange={(event) => setCategory(event.target.value as CategoryKey)}>
            <option value="all">All categories</option>
            <option value="backgrounds">Backgrounds</option>
            <option value="graphics">Graphics</option>
            <option value="icons">Icons</option>
            <option value="laptopui">Laptop UI</option>
            <option value="logo">Logo</option>
          </select>
        </div>

        <div className="asset-toolbar__field shell-stack">
          <label htmlFor="asset-search">Search by ID</label>
          <input
            id="asset-search"
            type="search"
            value={search}
            onChange={(event) => setSearch(event.target.value)}
            placeholder="e.g. bg_03, icon_04"
          />
        </div>

        <p className="asset-toolbar__count">Showing {visibleAssetCount} asset{visibleAssetCount === 1 ? "" : "s"}</p>
      </section>

      {visibleSections.length === 0 ? (
        <section className="shell-card shell-stack">
          <h2 className="asset-section__title">No results</h2>
          <p className="asset-page__lede">No assets match this filter.</p>
        </section>
      ) : null}

      {visibleSections.map((section) => (
        <AssetSection key={section.key} title={section.label} count={section.items.length}>
          <div className={section.wrapperClassName}>
            {section.items.map((asset) => (
              <article key={asset.id} className={`asset-item shell-stack${section.key === "backgrounds" ? " asset-item--background" : ""}`}>
                <div className={`asset-preview ${section.previewClassName}`}>
                  <AssetImage category={section.imageCategory} id={asset.id} alt={asset.id} className="asset-preview__img" />
                </div>
                <AssetMeta id={asset.id} path={asset.path} onCopyId={handleCopyId} copied={copiedId === asset.id} />
              </article>
            ))}
          </div>
        </AssetSection>
      ))}
    </div>
  );
}
