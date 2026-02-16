#!/usr/bin/env bash
set -euo pipefail

SECRETS="${HOME}/.cmn_marketing_deploy.env"
if [ ! -f "$SECRETS" ]; then
  echo "Missing secrets file: $SECRETS"
  exit 1
fi

# shellcheck disable=SC1090
source "$SECRETS"

: "${CMN_DEPLOY_HOST:?Missing CMN_DEPLOY_HOST}"
: "${CMN_DEPLOY_PORT:?Missing CMN_DEPLOY_PORT}"
: "${CMN_DEPLOY_USER:?Missing CMN_DEPLOY_USER}"
: "${CMN_DEPLOY_PASS:?Missing CMN_DEPLOY_PASS}"
: "${CMN_REMOTE_WP_CONTENT:?Missing CMN_REMOTE_WP_CONTENT}"

THEME_LOCAL="$(pwd)/cmn-marketing"
THEME_REMOTE="${CMN_REMOTE_WP_CONTENT}/themes/cmn-marketing"

if [ ! -d "$THEME_LOCAL" ]; then
  echo "Missing local theme folder: $THEME_LOCAL"
  exit 1
fi

# IMPORTANT: this uses sshpass (password-based). OK for temporary creds, but keep secrets file locked to 600.
if ! command -v sshpass >/dev/null 2>&1; then
  echo "sshpass not installed. Install it or use manual sftp."
  echo "Ubuntu/Debian: sudo apt-get update && sudo apt-get install -y sshpass"
  exit 1
fi

echo "Deploying theme via SFTP to ${CMN_DEPLOY_USER}@${CMN_DEPLOY_HOST}:${THEME_REMOTE}"

sshpass -p "$CMN_DEPLOY_PASS" sftp -oPort="$CMN_DEPLOY_PORT" -oStrictHostKeyChecking=accept-new "$CMN_DEPLOY_USER@$CMN_DEPLOY_HOST" <<SFTP
mkdir $THEME_REMOTE
cd $THEME_REMOTE
SFTP

# Upload (mirror) using rsync-over-ssh if SSH shell works; otherwise fallback is not reliable with pure sftp.
# Try rsync first:
if sshpass -p "$CMN_DEPLOY_PASS" ssh -p "$CMN_DEPLOY_PORT" -oStrictHostKeyChecking=accept-new "$CMN_DEPLOY_USER@$CMN_DEPLOY_HOST" "echo ok" >/dev/null 2>&1; then
  rsync -az --delete -e "sshpass -p '$CMN_DEPLOY_PASS' ssh -p ${CMN_DEPLOY_PORT} -oStrictHostKeyChecking=accept-new" \
    "${THEME_LOCAL}/" "${CMN_DEPLOY_USER}@${CMN_DEPLOY_HOST}:${THEME_REMOTE}/"
  echo "Done (rsync)."
  exit 0
fi

echo "SSH shell test failed; host may be SFTP-only. Use a manual upload or enable SSH shell access."
exit 1
