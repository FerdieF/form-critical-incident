# Form Critical Incident

Aplikasi Laravel 12 untuk form critical incident karyawan (login pakai NIK SAP, dashboard admin HRD & peserta).

## Menjalankan dengan Docker

Cara paling gampang — pakai Docker Compose (app + MySQL sekaligus):

```bash
docker compose up --build
```

Tunggu sampai migrasi selesai, lalu buka **http://localhost:8000**.

Saat pertama kali jalan, akun awal otomatis dibuat oleh seeder (karena `SEED_DB=true` di `docker-compose.yml`):

| Role  | NIK SAP   | Password      |
|-------|-----------|---------------|
| Admin | `1001001` | `password123` |
| User  | `2002002` | `password123` |

Data MySQL tersimpan di volume `dbdata`, jadi aman walau container di-restart. Untuk reset total (termasuk database):

```bash
docker compose down -v
```

### Pakai Dockerfile saja (tanpa Compose)

Image-nya butuh database MySQL/PostgreSQL yang jalan terpisah:

```bash
docker build -t form-critical-incident .
docker run -p 8000:80 \
  -e DB_CONNECTION=mysql \
  -e DB_HOST=<host-database> \
  -e DB_PORT=3306 \
  -e DB_DATABASE=form_karyawan \
  -e DB_USERNAME=<user> \
  -e DB_PASSWORD=<password> \
  form-critical-incident
```

Catatan:

- Entrypoint otomatis men-generate `APP_KEY` (kalau tidak di-set lewat env), menunggu database siap, lalu menjalankan `php artisan migrate --force`.
- Set `SEED_DB=true` kalau mau seeder akun awal ikut dijalankan.
- Asset frontend (Vite + Tailwind) sudah di-build di dalam image, jadi tidak perlu Node.js di server.

## Struktur Folder

```
app/
├── Http/Controllers/   # AuthController (login), HrdController (alur form asesmen), DashboardController
├── Models/             # Karyawan + relasinya: Keluarga, Pendidikan, PengalamanKerja,
│                       # DetailPekerjaan, Bawahan, KondisiKerja, MinatHarapan,
│                       # UsahaAspirasi, KekuatanKelemahan, CriticalIncident, User
database/
├── migrations/         # Skema tabel, urut sesuai alur pengisian form
├── seeders/            # UserSeeder: akun awal admin & peserta
resources/
├── views/
│   ├── auth/            # Halaman login
│   ├── layouts/         # Layout utama, sidebar, header
│   ├── components/      # Komponen blade yang dipakai berulang (preloader, dsb.)
│   └── pages/
│       ├── admin/        # Halaman khusus HRD (monitoring, tambah peserta)
│       ├── dashboard/    # Dashboard peserta
│       └── form/         # Tahapan form asesmen (identitas, keluarga, pendidikan, dst.)
docker/
└── entrypoint.sh        # Setup APP_KEY, migrasi, dan seeder saat container start
```

Setiap tabel di `database/migrations` merepresentasikan satu tahap form dan terhubung ke `karyawans` lewat `karyawan_id`, mengikuti urutan pengisian: Identitas Diri → Keluarga → Pendidikan → Pekerjaan → Detail Pekerjaan → Kondisi Kerja → Minat & Harapan → Kekuatan & Kelemahan → Critical Incident.

## Menjalankan secara lokal (tanpa Docker)

Butuh PHP >= 8.2, Composer, Node.js, dan MySQL.

```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
# atur kredensial database di .env, lalu:
php artisan migrate --seed
php artisan serve
```
