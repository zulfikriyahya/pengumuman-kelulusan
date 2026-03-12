#!/bin/bash
set -e

echo ">>> Membuat struktur project Madrasah Universe..."

# ---- ASTRO (frontend) ----
mkdir -p src/pages/admin
mkdir -p src/layouts
mkdir -p src/styles
mkdir -p public/icons

# ---- BACKEND PHP ----
mkdir -p api/config
mkdir -p api/auth
mkdir -p api/siswa
mkdir -p api/pengumuman
mkdir -p api/album
mkdir -p api/guru
mkdir -p api/testimoni

# ---- UPLOAD DIR (di luar public astro, diakses via PHP) ----
mkdir -p uploads/album
mkdir -p uploads/guru
chmod -R 755 uploads

# ---- TOUCH FILES ----

# Astro
touch src/styles/global.css
touch src/layouts/Layout.astro
touch src/pages/index.astro
touch src/pages/admin/index.astro

# Public
touch public/favicon.svg
touch public/manifest.json
touch public/sw.js
touch public/icons/192x192.png
touch public/icons/512x512.png
touch public/template_import_siswa.csv

# Astro config & env
touch astro.config.mjs
touch tsconfig.json
touch package.json
touch .env
touch .env.example

# PHP backend
touch api/.env
touch api/.env.example
touch api/config/db.php
touch api/auth/index.php
touch api/siswa/index.php
touch api/pengumuman/index.php
touch api/album/index.php
touch api/guru/index.php
touch api/testimoni/index.php

# Database
mkdir -p database
touch database/schema.sql
touch database/setup.php

# ---- .gitignore ----
cat > .gitignore << 'EOF'
node_modules/
dist/
.env
api/.env
uploads/
*.log
.DS_Store
.astro/
EOF

# ---- .env.example (Astro) ----
cat > .env.example << 'EOF'
PUBLIC_API_BASE=http://localhost/api
EOF

# ---- api/.env.example ----
cat > api/.env.example << 'EOF'
DB_HOST=localhost
DB_PORT=3306
DB_NAME=madrasah_kelulusan
DB_USER=root
DB_PASS=

ADMIN_USERNAME=admin
ADMIN_PASSWORD=admin123

UPLOAD_DIR=../uploads/
PUBLIC_URL=http://localhost/uploads/

ALLOWED_ORIGIN=http://localhost:4321
EOF

echo ""
echo ">>> Struktur project selesai dibuat."
echo ""
echo "Langkah selanjutnya:"
echo "  1. cp .env.example .env"
echo "  2. cp api/.env.example api/.env  (lalu isi kredensial DB)"
echo "  3. Jalankan database/schema.sql di MySQL"
echo "  4. Jalankan database/setup.php sekali untuk hash password admin, lalu hapus"
echo "  5. npm install && npm run dev"
echo ""
