#!/bin/sh
set -e

cd /var/www/html

# Pastikan APP_KEY tersedia. Kalau tidak di-set lewat environment,
# buat .env dari .env.example lalu generate key sekali.
if [ -z "$APP_KEY" ]; then
    [ -f .env ] || cp .env.example .env
    if ! grep -q '^APP_KEY=base64' .env; then
        php artisan key:generate --force --no-interaction
    fi
fi

# Tunggu database siap, lalu jalankan migrasi.
tries=0
until php artisan migrate --force --no-interaction; do
    tries=$((tries + 1))
    if [ "$tries" -ge 15 ]; then
        echo "Database tidak bisa dihubungi setelah $tries percobaan, menyerah." >&2
        exit 1
    fi
    echo "Menunggu database... (percobaan $tries)"
    sleep 3
done

# Seed akun awal hanya kalau diminta (SEED_DB=true) dan tabel users masih kosong.
if [ "$SEED_DB" = "true" ]; then
    php artisan db:seed --force --no-interaction || echo "Seeding dilewati (kemungkinan data sudah ada)."
fi

php artisan storage:link 2>/dev/null || true

# Entrypoint jalan sebagai root; pastikan file yang barusan dibuat
# (log, cache) tetap bisa ditulis oleh worker Apache (www-data).
chown -R www-data:www-data storage bootstrap/cache

exec "$@"
