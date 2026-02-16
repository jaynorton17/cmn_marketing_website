# Deployment

## Build Commands

Run from repo root:

```bash
npm run assets:validate
npm run build
```

The `assets:validate` step confirms every registry asset resolves to an existing file under `/public`.

## Runtime Command

Start production server:

```bash
npm run start -- --hostname 0.0.0.0 --port 3000
```

If you need a local-only bind:

```bash
npm run start -- --hostname 127.0.0.1 --port 3010
```

## Output Notes

- `npm run build` currently completes successfully and generates static routes:
  - `/`
  - `/schools`
  - `/candidates`
  - `/services`
  - `/contact-us`
  - `/assets`
- In this Codex sandbox, `npm run start` cannot bind sockets (`listen EPERM`), so runtime boot could not be executed here. This is an environment restriction, not a build failure.
- `npm run lint` is not available in `package.json` (no lint script defined).

## Public Assets

- Next.js serves `/public` at the web root.
- Examples:
  - `public/favicon.png` -> `/favicon.png`
  - `public/images/...` -> `/images/...`
- This repo uses a symlink:
  - `public/images -> ../images`
  so registry image paths under `/images/...` resolve in both dev and production builds.

## Environment Variables

Required for build/runtime:

- None

Optional:

- `NEXT_PUBLIC_SITE_URL`
  - Used for absolute metadata/canonical base in `src/app/layout.tsx`.
  - Defaults to `https://covermenow.co.uk` when unset or invalid.
