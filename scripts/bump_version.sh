#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "${SCRIPT_DIR}/.." && pwd)"
STYLE_FILE="${ROOT_DIR}/cmn-marketing/style.css"

fail() {
  echo "ERROR: $1" >&2
  exit 1
}

[[ -f "${STYLE_FILE}" ]] || fail "Missing style file: ${STYLE_FILE}"
[[ -r "${STYLE_FILE}" ]] || fail "Style file is not readable: ${STYLE_FILE}"
[[ -w "${STYLE_FILE}" ]] || fail "Style file is not writable: ${STYLE_FILE}"

current_version="$({
  awk -F': *' '/^[[:space:]]*Version:[[:space:]]*/ {
    gsub(/[[:space:]]+$/, "", $2)
    print $2
    exit
  }' "${STYLE_FILE}"
} || true)"

[[ -n "${current_version}" ]] || fail "Version line not found in ${STYLE_FILE}"
[[ "${current_version}" =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]] || fail "Invalid version format: ${current_version}"

IFS='.' read -r major minor patch <<< "${current_version}"
new_major=$major
new_minor=$minor
new_patch=$((patch + 1))

if (( new_patch >= 10 )); then
  new_patch=0
  new_minor=$((minor + 1))
fi

if (( new_minor >= 10 )); then
  new_minor=0
  new_major=$((major + 1))
fi

new_version="${new_major}.${new_minor}.${new_patch}"

tmp_file="$(mktemp)"
trap 'rm -f "${tmp_file}"' EXIT

if ! awk -v new_version="${new_version}" '
  BEGIN { updated = 0 }
  {
    if (!updated && $0 ~ /^[[:space:]]*Version:[[:space:]]*[0-9]+\.[0-9]+\.[0-9]+[[:space:]]*$/) {
      sub(/Version:[[:space:]]*[0-9]+\.[0-9]+\.[0-9]+[[:space:]]*$/, "Version: " new_version)
      updated = 1
    }
    print
  }
  END {
    if (!updated) {
      exit 2
    }
  }
' "${STYLE_FILE}" > "${tmp_file}"; then
  fail "Unable to update version in ${STYLE_FILE}"
fi

mv "${tmp_file}" "${STYLE_FILE}"
trap - EXIT

echo "${new_version}"
