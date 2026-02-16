#!/usr/bin/env bash
set -eEuo pipefail

ENV_FILE="${HOME}/.cmn_marketing_deploy.env"
NETRC_FILE="${HOME}/.netrc"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOCAL_THEME_DIR="${SCRIPT_DIR}/cmn-marketing"
FUNCTIONS_FILE="${LOCAL_THEME_DIR}/functions.php"
BUMP_SCRIPT="${SCRIPT_DIR}/scripts/bump_version.sh"
LOG_FILE="${SCRIPT_DIR}/deploy.log"

DEPLOY_STATUS="FAIL"
FAIL_REASON="Unspecified failure"
DEPLOY_VERSION="unknown"
LOG_HOST="unknown"
LOG_USER="unknown"
LOG_REMOTE="unknown"

timestamp_utc() {
  date -u +"%Y-%m-%dT%H:%M:%SZ"
}

sanitize_reason() {
  local reason="$1"
  reason="${reason//$'\n'/ }"
  reason="${reason//|/ }"
  echo "${reason}"
}

append_log() {
  local status="$1"
  local reason="${2:-}"
  local line=""

  line="$(timestamp_utc) | version=${DEPLOY_VERSION} | host=${LOG_HOST} | user=${LOG_USER} | remote=${LOG_REMOTE} | status=${status}"

  if [[ "${status}" == "FAIL" && -n "${reason}" ]]; then
    line="${line} | reason=$(sanitize_reason "${reason}")"
  fi

  printf '%s\n' "${line}" >> "${LOG_FILE}"
}

on_error() {
  if [[ "${FAIL_REASON}" == "Unspecified failure" ]]; then
    FAIL_REASON="Command failed: ${BASH_COMMAND}"
  fi
}

on_exit() {
  local exit_code=$?
  set +e

  if [[ ${exit_code} -eq 0 && "${DEPLOY_STATUS}" == "SUCCESS" ]]; then
    append_log "SUCCESS" || true
  else
    if [[ -z "${FAIL_REASON}" ]]; then
      FAIL_REASON="Exit code ${exit_code}"
    fi
    append_log "FAIL" "${FAIL_REASON}" || true
  fi
}

trap on_error ERR
trap on_exit EXIT

fail() {
  FAIL_REASON="$1"
  echo "ERROR: ${FAIL_REASON}" >&2
  exit 1
}

load_env_file() {
  [[ -f "${ENV_FILE}" ]] || fail "Missing deploy config: ${ENV_FILE}"
  [[ -r "${ENV_FILE}" ]] || fail "Deploy config is not readable: ${ENV_FILE}"

  # shellcheck disable=SC1090
  source "${ENV_FILE}"

  local required_vars=(
    "CMN_DEPLOY_HOST"
    "CMN_DEPLOY_PORT"
    "CMN_DEPLOY_USER"
    "CMN_REMOTE_WP_CONTENT"
  )

  local var_name=""
  for var_name in "${required_vars[@]}"; do
    [[ -n "${!var_name:-}" ]] || fail "Required variable ${var_name} missing in ${ENV_FILE}"
  done

  [[ "${CMN_DEPLOY_PORT}" =~ ^[0-9]+$ ]] || fail "CMN_DEPLOY_PORT must be numeric"
}

validate_paths() {
  [[ -d "${LOCAL_THEME_DIR}" ]] || fail "Local theme directory not found: ${LOCAL_THEME_DIR}"
  [[ -f "${FUNCTIONS_FILE}" ]] || fail "Missing functions.php: ${FUNCTIONS_FILE}"
  [[ -x "${BUMP_SCRIPT}" ]] || fail "Missing executable version bump script: ${BUMP_SCRIPT}"
  [[ -f "${NETRC_FILE}" ]] || fail "Missing netrc file: ${NETRC_FILE}"
  [[ -r "${NETRC_FILE}" ]] || fail "netrc file is not readable: ${NETRC_FILE}"
}

validate_dependencies() {
  command -v awk >/dev/null 2>&1 || fail "awk is required but not installed"
  command -v ssh >/dev/null 2>&1 || fail "ssh is required but not installed"
  command -v rsync >/dev/null 2>&1 || fail "rsync is required but not installed"
  command -v sshpass >/dev/null 2>&1 || fail "sshpass is required but not installed"
}

ensure_cache_busting_config() {
  if ! grep -Fq "wp_get_theme()->get('Version')" "${FUNCTIONS_FILE}"; then
    fail "functions.php must use wp_get_theme()->get('Version') for asset versions"
  fi
}

read_netrc_password() {
  local host="$1"
  local user="$2"

  local token=""
  local expect=""
  local current_machine=""
  local current_login=""
  local current_password=""

  while IFS= read -r token; do
    case "${token}" in
      machine|login|password)
        expect="${token}"
        continue
        ;;
      *)
        case "${expect}" in
          machine)
            current_machine="${token}"
            current_login=""
            current_password=""
            ;;
          login)
            current_login="${token}"
            ;;
          password)
            current_password="${token}"
            ;;
        esac
        expect=""
        ;;
    esac

    if [[ "${current_machine}" == "${host}" && "${current_login}" == "${user}" && -n "${current_password}" ]]; then
      printf '%s' "${current_password}"
      return 0
    fi
  done < <(
    awk '
      /^[[:space:]]*#/ { next }
      {
        for (i = 1; i <= NF; i++) {
          if ($i ~ /^#/) {
            break
          }
          print $i
        }
      }
    ' "${NETRC_FILE}"
  )

  return 1
}

load_env_file
LOG_HOST="${CMN_DEPLOY_HOST}"
LOG_USER="${CMN_DEPLOY_USER}"
remote_wp_content="${CMN_REMOTE_WP_CONTENT%/}"
LOG_REMOTE="${remote_wp_content}/themes/cmn-marketing"

validate_paths
validate_dependencies
ensure_cache_busting_config

remote_target="${CMN_DEPLOY_USER}@${CMN_DEPLOY_HOST}"

if ! netrc_password="$(read_netrc_password "${CMN_DEPLOY_HOST}" "${CMN_DEPLOY_USER}")"; then
  fail "No matching machine/login/password entry in ${NETRC_FILE} for host '${CMN_DEPLOY_HOST}' and user '${CMN_DEPLOY_USER}'"
fi

if ! DEPLOY_VERSION="$("${BUMP_SCRIPT}")"; then
  fail "Version bump failed"
fi

[[ "${DEPLOY_VERSION}" =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]] || fail "Invalid bumped version returned: ${DEPLOY_VERSION}"

echo "Deploying cmn-marketing version ${DEPLOY_VERSION}"
echo "Local:  ${LOCAL_THEME_DIR}/"
echo "Remote: ${remote_target}:${LOG_REMOTE}/"

(
  export SSHPASS="${netrc_password}"

  sshpass -e ssh \
    -o StrictHostKeyChecking=accept-new \
    -o PreferredAuthentications=password \
    -o PubkeyAuthentication=no \
    -p "${CMN_DEPLOY_PORT}" \
    "${remote_target}" \
    "mkdir -p '${LOG_REMOTE}'"

  sshpass -e rsync -az --delete \
    -e "ssh -o StrictHostKeyChecking=accept-new -o PreferredAuthentications=password -o PubkeyAuthentication=no -p ${CMN_DEPLOY_PORT}" \
    "${LOCAL_THEME_DIR}/" \
    "${remote_target}:${LOG_REMOTE}/"
)

DEPLOY_STATUS="SUCCESS"
FAIL_REASON=""

echo "Deploy complete"
