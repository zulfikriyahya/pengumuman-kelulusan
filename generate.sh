#!/bin/bash

# ⚙️ Konfigurasi
OUTPUT="draft.md"

# Daftar pola/nama yang harus dikecualikan (untuk 'tree' dan 'find')
EXCLUDE_PATHS=(
  "node_modules"
  ".vscode"
  ".astro"
  ".git"
)

EXCLUDE_NAMES=(
  "draft.md"
  "generate.sh"
  "package-lock.json"
  "README.md"
  "tree.txt"
  ".gitignore"
  "pnpm-lock.yaml"
  "pnpm-workspace.yaml"
  "todo.md"
  ".env-example"
)

# 🧹 Bersihkan file output
> "$OUTPUT"

## 🌲 Bagian Project Files (Tree Structure)
# Gunakan daftar EXCLUDE_PATHS dan EXCLUDE_NAMES yang digabung untuk 'tree -I'
TREE_EXCLUDES=$(
  IFS="|"
  echo "${EXCLUDE_PATHS[*]}|\
${EXCLUDE_NAMES[*]}"
)

echo "# Project Files" >> "$OUTPUT"
echo "" >> "$OUTPUT"
# tree -I: Abaikan file yang cocok dengan pola regex (gunakan IFS "|" untuk memisahkan)
tree -I "$TREE_EXCLUDES" >> "$OUTPUT"
echo "" >> "$OUTPUT"

## 📄 Bagian File Contents
echo "# File Contents" >> "$OUTPUT"
echo "" >> "$OUTPUT"

# Fungsi untuk menentukan bahasa berdasarkan ekstensi
get_lang() {
  case "$1" in
    html | astro) echo "html" ;;
    js | mjs | gs) echo "javascript" ;; # Menggunakan 'javascript' untuk konsistensi di Markdown
    ts | tsx) echo "typescript" ;;
    json) echo "json" ;;
    css) echo "css" ;;
    md | mdx) echo "markdown" ;;
    sh) echo "bash" ;;
    *) echo "" ;;
  esac
}

# 🔍 Loop file dengan aman menggunakan find
# find . -type f: Cari hanya file biasa
# Kriteria pengecualian:
# ! -path "./{PATH}/*": Mengecualikan direktori
# ! -name "{NAME}": Mengecualikan nama file
while IFS= read -r -d '' file; do
  ext="${file##*.}"
  lang=$(get_lang "$ext")

  # 🖼️ Abaikan file biner/media
  case "$ext" in
    png | jpg | jpeg | gif | svg | mp3 | wav | ogg | mp4 | mkv | avi | pdf)
      # dilewati
      ;;
    *)
      {
        echo "## $file"
        echo ""
        echo "\`\`\`$lang"
        cat "$file"
        echo ""
        echo "\`\`\`"
        echo "---"
        echo ""
      } >> "$OUTPUT"
      ;;
  esac
done < <(find . -type f \
  ! -path "./${EXCLUDE_PATHS[0]}/*" \
  ! -path "./${EXCLUDE_PATHS[1]}/*" \
  ! -path "./${EXCLUDE_PATHS[2]}/*" \
  ! -path "./${EXCLUDE_PATHS[3]}/*" \
  ! -name "${EXCLUDE_NAMES[0]}" \
  ! -name "${EXCLUDE_NAMES[1]}" \
  ! -name "${EXCLUDE_NAMES[2]}" \
  ! -name "${EXCLUDE_NAMES[3]}" \
  ! -name "${EXCLUDE_NAMES[4]}" \
  ! -name "${EXCLUDE_NAMES[5]}" \
  ! -name "${EXCLUDE_NAMES[6]}" \
  -print0)

echo "Output berhasil dibuat di $OUTPUT"
