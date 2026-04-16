#!/bin/bash
# generate.sh - Generator Blueprint Otomatis

set -euo pipefail

OUT="draft.md"
ROOT="."

# Prefix patterns (direktori) — match rekursif
EXCLUDE_DIRS=(
  "./vendor"
  "./node_modules"
  "./storage/logs"
  "./storage/framework/cache"
  "./storage/framework/sessions"
  "./storage/framework/views"
  "./bootstrap/cache"
  "./.git"
  "./.github"
  "./public/build"
  "./public/css"
  "./public/js"
  "./public/fonts"
  "./coverage"
  "./docs/api"
  "./.idea"
  "./.vscode"
  "./.fleet"
)

# Exact file patterns (basename atau path lengkap)
EXCLUDE_FILES=(
  "./public/hot"
  "./public/storage"
  "./.env"
  "./.env.example"
  "./.env.backup"
  "./.env.production"
  "./composer.lock"
  "./package-lock.json"
  "./pnpm-lock.yaml"
  "./yarn.lock"
  "./.phpunit.result.cache"
  "./.DS_Store"
  "./Thumbs.db"
  "./public/mix-manifest.json"
  "./$OUT"
  "./generate.sh"
  "./.generate.sh"
  "./.blueprint"
  "./draft.yaml"
  "./draft_skl.md"
  "./tree"
  "./README.md"
  "./.gitignore"
  "./.gitattributes"
  "./database/*.sqlite"
  "./database/*.db"
)

# Extension yang di-skip
EXCLUDE_EXTS=(
  sql log
  png jpg jpeg webp ico gif svg avif
  woff woff2 ttf otf eot
  mp3 mp4 avi mov
  sqlite db
)

lang_for_ext() {
  case "$1" in
    php)        printf "php" ;;
    blade.php)  printf "blade" ;;
    js|mjs|cjs) printf "javascript" ;;
    jsx)        printf "jsx" ;;
    ts)         printf "typescript" ;;
    tsx)        printf "tsx" ;;
    vue)        printf "vue" ;;
    css)        printf "css" ;;
    scss)       printf "scss" ;;
    sass)       printf "sass" ;;
    less)       printf "less" ;;
    json)       printf "json" ;;
    yml|yaml)   printf "yaml" ;;
    xml)        printf "xml" ;;
    env)        printf "bash" ;;
    md|mdx)     printf "markdown" ;;
    sh|bash)    printf "bash" ;;
    sql)        printf "sql" ;;
    txt)        printf "text" ;;
    html)       printf "html" ;;
    Dockerfile) printf "dockerfile" ;;
    Makefile)   printf "makefile" ;;
    *)          printf "" ;;
  esac
}

is_excluded() {
  local f="$1"

  # Cek prefix direktori — match rekursif
  for dir in "${EXCLUDE_DIRS[@]}"; do
    if [[ "$f" == "$dir" || "$f" == "$dir/"* ]]; then
      return 0
    fi
  done

  # Cek exact file / glob
  for pat in "${EXCLUDE_FILES[@]}"; do
    # shellcheck disable=SC2254
    case "$f" in $pat) return 0 ;; esac
  done

  # Cek ekstensi
  local filename ext
  filename="$(basename -- "$f")"
  if [[ "$filename" == *.* ]]; then
    ext="${filename##*.}"
  else
    ext=""
  fi
  for ex in "${EXCLUDE_EXTS[@]}"; do
    [[ "$ext" == "$ex" ]] && return 0
  done

  # Skip file binary
  if file --brief --mime-encoding "$f" 2>/dev/null | grep -q "binary"; then
    return 0
  fi

  return 1
}

get_ext() {
  local filename="$1"
  # blade.php harus dicek duluan
  if [[ "$filename" == *.blade.php ]]; then
    printf "blade.php"
  elif [[ "$filename" == *.* ]]; then
    printf "%s" "${filename##*.}"
  else
    printf "%s" "$filename"
  fi
}

# --- Kumpulkan file ---
declare -a files=()
while IFS= read -r -d '' f; do
  is_excluded "$f" && continue
  files+=("$f")
done < <(find "$ROOT" -type f -print0 | sort -z -V)

if [ "${#files[@]}" -eq 0 ]; then
  echo "Tidak ada file ditemukan untuk diproses."
  exit 0
fi

: > "$OUT"

cat >> "$OUT" << 'EOF'
# Laravel Project Blueprint

EOF

# --- Kelompokkan per top-level direktori ---
declare -A groups=()
for f in "${files[@]}"; do
  p="${f#./}"
  if [[ "$p" == */* ]]; then
    top="${p%%/*}"
  else
    top="ROOT"
  fi
  groups["$top"]+=$'\n'"$f"
done

dir_label() {
  case "$1" in
    app)       printf "Application Core" ;;
    database)  printf "Database" ;;
    resources) printf "Frontend Resources" ;;
    routes)    printf "Routes" ;;
    config)    printf "Configuration" ;;
    public)    printf "Public Assets" ;;
    tests)     printf "Tests" ;;
    ROOT)      printf "Root Files" ;;
    *)         printf "%s" "$1" ;;
  esac
}

dir_desc() {
  case "$1" in
    app)       printf "Contains models, controllers, services, and business logic." ;;
    database)  printf "Migrations, seeders, and factories." ;;
    resources) printf "Views, CSS, JavaScript, and frontend assets." ;;
    routes)    printf "Application routing definitions." ;;
    config)    printf "Application configuration files." ;;
    public)    printf "Publicly accessible files (entry point)." ;;
    tests)     printf "Unit and feature tests." ;;
    ROOT)      printf "Configuration and setup files in project root." ;;
    *)         printf "" ;;
  esac
}

# --- Tulis output ---
while IFS= read -r top; do
  label="$(dir_label "$top")"
  desc="$(dir_desc "$top")"

  if [[ "$top" == "ROOT" ]]; then
    printf "## 📁 Directory: Root Files\n\n" >> "$OUT"
  else
    printf "## 📁 Directory: %s (%s)\n\n" "$top" "$label" >> "$OUT"
  fi
  [[ -n "$desc" ]] && printf "%s\n\n" "$desc" >> "$OUT"

  # Sort file dalam grup
  mapfile -t flist < <(printf '%s\n' "${groups[$top]}" | grep -v '^$' | sort -V)

  for file in "${flist[@]}"; do
    [[ -z "$file" ]] && continue

    filename="$(basename -- "$file")"
    ext="$(get_ext "$filename")"
    lang="$(lang_for_ext "$ext")"

    printf "### 📄 File: \`%s\`\n\n" "$file" >> "$OUT"

    case "$filename" in
      "composer.json")      printf "_PHP dependencies and project metadata._\n\n" >> "$OUT" ;;
      "package.json")       printf "_Node.js dependencies and build scripts._\n\n" >> "$OUT" ;;
      "artisan")            printf "_Laravel command-line interface._\n\n" >> "$OUT" ;;
      "phpunit.xml")        printf "_PHPUnit testing configuration._\n\n" >> "$OUT" ;;
      "vite.config.js")     printf "_Vite build tool configuration._\n\n" >> "$OUT" ;;
      "tailwind.config.js") printf "_Tailwind CSS configuration._\n\n" >> "$OUT" ;;
    esac

    printf '```%s\n' "$lang" >> "$OUT"
    sed 's/\r$//' "$file" >> "$OUT"
    printf '\n```\n\n---\n\n' >> "$OUT"
  done

done < <(printf '%s\n' "${!groups[@]}" | sort -V)

echo "Selesai. File '$OUT' telah dibuat/diupdate."
