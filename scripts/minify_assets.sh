#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "${SCRIPT_DIR}/.." && pwd)"
CSS_DIR="${ROOT_DIR}/cmn-marketing/assets/css"
JS_DIR="${ROOT_DIR}/cmn-marketing/assets/js"

if [[ ! -d "${CSS_DIR}" ]]; then
  echo "ERROR: CSS directory not found: ${CSS_DIR}" >&2
  exit 1
fi

if [[ ! -d "${JS_DIR}" ]]; then
  echo "ERROR: JS directory not found: ${JS_DIR}" >&2
  exit 1
fi

minify_css() {
  local input_file="$1"
  perl -0777 -pe '
    s:/\*[^*]*\*+([^/*][^*]*\*+)*/::g;
    s/\s+/ /g;
    s/\s*([{}:;,>])\s*/$1/g;
    s/;}/}/g;
    s/^\s+|\s+$//g;
  ' "${input_file}"
}

minify_js() {
  local input_file="$1"
  perl -0777 -pe '
    s:/\*.*?\*/::gs;
    s/\s+/ /g;
    s/\s*([{}();,:])\s*/$1/g;
    s/\s*([=!<>+\-*\/%&|])\s*/$1/g;
    s/^\s+|\s+$//g;
  ' "${input_file}"
}

for css_file in "${CSS_DIR}"/*.css; do
  [[ -f "${css_file}" ]] || continue
  if [[ "${css_file}" == *.min.css ]]; then
    continue
  fi

  output_file="${css_file%.css}.min.css"
  minify_css "${css_file}" > "${output_file}"
done

for js_file in "${JS_DIR}"/*.js; do
  [[ -f "${js_file}" ]] || continue
  if [[ "${js_file}" == *.min.js ]]; then
    continue
  fi

  output_file="${js_file%.js}.min.js"
  minify_js "${js_file}" > "${output_file}"
done

echo "Minified assets generated in ${CSS_DIR} and ${JS_DIR}."
