# cmn_marketing_website

## Deploy

Deployment configuration lives outside the repo.

- Env file: `~/.cmn_marketing_deploy.env`
- Required keys:
  - `CMN_DEPLOY_HOST`
  - `CMN_DEPLOY_PORT`
  - `CMN_DEPLOY_USER`
  - `CMN_REMOTE_WP_CONTENT`
- Credentials file: `~/.netrc`
  - Required entry format: `machine <host> login <user> password <pass>`

Run deploy from repo root:

```bash
./deploy_marketing.sh
```

Version bump behavior:

- Deploy runs `scripts/bump_version.sh` before upload.
- `cmn-marketing/style.css` `Version:` is bumped by patch (`+0.0.1`) each successful deploy run.
- The deploy appends an audit line to local `deploy.log` with timestamp, version, host/user/remote target, and `SUCCESS` or `FAIL` status.

## Homepage Setup

To use the `CMN Home` page template as the site homepage:

1. In WordPress admin, create a page named `Home`.
2. In the page template selector, choose `CMN Home`.
3. Publish the page.
4. Go to `Settings` -> `Reading`.
5. Set `Your homepage displays` to `A static page`.
6. Set `Homepage` to `Home` and save changes.

## Responsive Dev Checklist

Quick QA pass before deploying responsive updates:

- Pages to check:
  - `/`
  - `/schools`
  - `/candidates`
  - `/services`
  - `/contact`
  - `/assets` (dev route)
- Key viewports:
  - `390x844` (iPhone 12/13/14)
  - `768x1024` (tablet portrait)
  - `1024x768` (tablet landscape / small laptop)
  - `1366x768` (desktop baseline)
  - `1920x1080` (large desktop)
- Header/nav checks:
  - Desktop nav visible at `>=1024px`
  - Mobile hamburger and panel work at `<1024px`
  - CTA buttons remain accessible on all sizes
- Layout checks:
  - No horizontal scrolling at mobile widths
  - Hero text/device stacks cleanly below `1024px` and sits side-by-side at `>=1024px`
  - 3-card sections render `1-up` mobile, `2-up` tablet, `3-up` desktop
- Image checks:
  - No visible layout shift when images load
  - Hero/background imagery keeps readable text contrast and does not crop key content awkwardly
