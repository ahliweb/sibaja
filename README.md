# SIBAJA — Sistem Informasi Barang dan Jasa

Aplikasi web administrasi pengadaan barang dan jasa untuk lingkungan **Sekretariat Daerah Kabupaten Kotawaringin Barat**. Dibangun ulang dari CodeIgniter 3 (2016/2017) ke versi modern.

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | CodeIgniter 4.7 |
| Database | MariaDB 10.11 |
| Container | Docker (PHP 8.2 + Apache + Composer) |
| Frontend | AdminLTE 4 (Bootstrap 5 + jQuery) |
| Tables | DataTables (jQuery plugin) |
| Icons | Font Awesome 6 |
| PDF Export | Dompdf |
| Excel Export | PhpSpreadsheet |
| Language | Bahasa Indonesia |

## Quick Start

```bash
# 1. Clone and start
git clone git@github.com:ahliweb/sibaja.git
cd sibaja
docker compose up -d

# 2. Install dependencies
docker compose exec app composer install

# 3. Run migrations and seed
docker compose exec app php spark migrate
docker compose exec app php spark db:seed AdminSeeder

# 4. Open
open http://localhost:8080
```

### Default Credentials

| Role | Username | Password |
|---|---|---|
| Admin | `admin` | `password` |
| Petugas | `petugas` | `password` |
| SKPD | `disdik` | `password` |

### Services

| Service | URL | Credentials |
|---|---|---|
| Aplikasi | `http://localhost:8080` | — |
| phpMyAdmin | `http://localhost:8081` | root / root |

## Project Structure

```
├── app/
│   ├── Commands/          # CLI: sibaja:reset, sibaja:audit-clean
│   ├── Config/            # Routes, Filters, Database, Security, App
│   ├── Controllers/       # 13 controllers (Auth, Dashboard, CRUD, Laporan)
│   ├── Database/
│   │   ├── Migrations/    # 10 tabel
│   │   └── Seeds/         # AdminSeeder (default users + master data)
│   ├── Filters/           # AuthFilter (role-based access)
│   ├── Helpers/           # sibaja_helper (status, Rupiah)
│   ├── Models/            # 10 model (User, Skpd, Pengajuan, Dokumen, ...)
│   ├── Traits/            # AuditLogger trait
│   └── Views/             # Layouts, Partials, Pages
├── public/                # index.php, CSS, JS, AdminLTE assets
├── writable/              # uploads, cache, logs, sessions
├── docker-compose.yml     # PHP 8.2 + MariaDB + phpMyAdmin
├── Dockerfile             # Custom Apache + PHP + Composer image
├── .env                   # Environment configuration
├── .env.example           # Template without secrets
└── spark                  # CodeIgniter CLI entry point
```

142 PHP source files across the `app/` directory.

## Features

### Authentication
- Login with username/password
- Session-based authentication with role-aware redirects
- Password change (self-service)
- CSRF protection (cookie-based)
- Role-based access control via AuthFilter

### Role-Based Dashboards

| Role | Dashboard Content |
|---|---|
| **Admin** | Total SKPD, Users, Submissions by status; recent submissions; quick actions |
| **Petugas** | Incoming submissions, unverified documents, priorities, monthly completions |
| **User SKPD** | Own submissions (draft → selesai), SKPD identity card, "Tambah Pengajuan" button |

### Master Data (Admin only)
- Data SKPD (kode, nama, kepala, kontak)
- Data User (nama, username, role, SKPD)
- Data Petugas (petugas role users)
- Jenis Pengadaan (Barang, Jasa Konsultansi, Konstruksi, Jasa Lainnya)
- Metode Pengadaan (E-Purchasing, Langsung, Penunjukan, Tender)
- Tahun Anggaran

### Procurement Workflow

```
draft → diajukan → diverifikasi → dalam_proses → selesai
         ↑            ↓
         └── perlu_perbaikan ←──┘
                        ↓
                      ditolak (final)
```

- Auto-generate nomor pengajuan: `PENG-{TAHUN}-{BULAN}-{SKPD}-{SEQ}`
- Draft submissions editable by SKPD user
- Send for review when ready
- Status changes logged with timestamps and notes

### Document Management
- Upload supporting documents per submission
- Verify/revise/reject documents by Petugas/Admin
- Formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (max 10 MB)
- Download with original filename

### Reports
- Filter by tahun, SKPD, status, jenis, metode, date range
- Summary statistics (total, pagu, counts by status)
- Export to PDF (Dompdf)
- Export to Excel (PhpSpreadsheet)
- Print-friendly view

### Audit Log
- Admin-only activity tracking
- Records: login, logout, create, update, delete, upload, verify, status change, export
- Stored: user, role, module, action, description, IP, user agent
- Cleanup command: `php spark sibaja:audit-clean`

### Master Data (Admin only)
- Data SKPD (kode, nama, kepala, kontak)
- Data User (nama, username, role, SKPD)
- Data Petugas (petugas role users)
- Jenis Pengadaan (Barang, Jasa Konsultansi, Konstruksi, Jasa Lainnya)
- Metode Pengadaan (E-Purchasing, Langsung, Penunjukan, Tender)
- Tahun Anggaran

## Database Schema

| Table | Key Fields |
|---|---|
| `skpd` | kode_skpd (unique), nama_skpd, kepala_skpd, nip_kepala, alamat, kontak, email, status |
| `users` | nama, username (unique), password (bcrypt), role (admin/petugas/skpd), skpd_id (FK), status, last_login |
| `jenis_pengadaan` | nama, deskripsi, status |
| `metode_pengadaan` | nama, deskripsi, status |
| `tahun_anggaran` | tahun (unique), status |
| `pengajuan` | nomor_pengajuan (unique), tanggal, skpd_id (FK), user_id (FK), nama_paket, jenis_id (FK), metode_id (FK), pagu_anggaran, sumber_dana, lokasi, uraian, spesifikasi, status, tahun_anggaran_id (FK) |
| `dokumen` | pengajuan_id (FK), user_id (FK), jenis_dokumen, nama_file, nama_asli, ukuran, status_verifikasi, catatan |
| `riwayat_proses` | pengajuan_id (FK), user_id (FK), status_sebelum, status_baru, catatan |
| `audit_log` | user_id, role, modul, aksi, deskripsi, ip_address, user_agent |
| `settings` | key (unique), value |

## CLI Commands

```bash
php spark migrate              # Run migrations
php spark migrate:refresh      # Rollback all + re-migrate
php spark db:seed AdminSeeder  # Seed default data
php spark sibaja:reset         # Refresh + seed (shortcut)
php spark sibaja:audit-clean   # Delete audit logs > 90 days
php spark routes               # List all registered routes
php spark make:migration       # Create new migration
php spark make:controller      # Create new controller
php spark make:model           # Create new model
```

## Routing Convention

The project uses two routing patterns:

### Presenter Routes (CRUD master data)
`$routes->presenter('skpd', ...)` generates:
```
GET  skpd            → index
GET  skpd/new        → new (form)
GET  skpd/show/{id}  → show
GET  skpd/edit/{id}  → edit
POST skpd            → create (insert)
POST skpd/update/{id}→ update
POST skpd/delete/{id}→ delete
```

### Explicit Routes (Pengajuan, Dokumen, Laporan)
```
GET  pengajuan/create           → create (form)
POST pengajuan/store            → store (insert)
GET  pengajuan/{id}             → show
GET  pengajuan/{id}/edit        → edit
POST pengajuan/{id}/kirim       → kirim
GET  pengajuan/{id}/update-status → statusForm
POST pengajuan/{id}/update-status → updateStatus
```

## Role Permissions

| Feature | Admin | Petugas | SKPD |
|---|---|---|---|
| Dashboard | Full stats | Priority view | Own submissions |
| Master Data | CRUD all | — | — |
| All Submissions | View + manage | View + verify | — |
| Create Submission | ✓ | — | ✓ |
| Edit Submission | ✓ | — | Draft only |
| Upload Documents | ✓ | ✓ | Own only |
| Verify Documents | ✓ | ✓ | — |
| Change Status | ✓ | ✓ | — |
| Reports | ✓ | ✓ | — |
| Audit Log | ✓ | — | — |
| Settings | ✓ | — | — |
| Profile | — | — | ✓ |

## Development Notes

### Environment
- Copy `.env.example` to `.env` for local setup
- Set `CI_ENVIRONMENT = development` for debug toolbar
- Set `CI_ENVIRONMENT = production` for production

### Status Badges
| Status | Badge Class | Label |
|---|---|---|
| `draft` | `text-bg-secondary` | Draft |
| `diajukan` | `text-bg-primary` | Diajukan |
| `diverifikasi` | `text-bg-success` | Diverifikasi |
| `perlu_perbaikan` | `text-bg-warning` | Perlu Perbaikan |
| `dalam_proses` | `text-bg-info` | Dalam Proses |
| `selesai` | `text-bg-success` | Selesai |
| `ditolak` | `text-bg-danger` | Ditolak |

### Number Formatting
- `pagu_anggaran` stored as DECIMAL(15,2) in DB
- Displayed via `formatRupiah()` helper: `Rp 1.000.000`
- Form input auto-formats with JS thousand separators, stripped on submit

### Session
- Cookie-based sessions in `writable/session/`
- Session contains: `user_id`, `nama`, `username`, `role`, `skpd_id`, `isLoggedIn`

### CSRF
- Cookie-based (`csrf_cookie_name`)
- No regeneration between requests
- All POST forms use `<?= csrf_field() ?>`

## Troubleshooting

### "Vendor/autoload.php not found"
```bash
docker compose exec app composer install
```

### "No migrations found"
Ensure migration filenames use valid timestamp format: `YYYY-MM-DD-HHIISS_ClassName.php`

### "The action you requested is not allowed" (CSRF error)
Clear browser cookies and re-login. CSRF token must match between form and session.

### "Data tidak ditemukan" on `/create` page
This is a presenter route catch-all issue. Use `/new` instead of `/create` for forms, or let explicit GET routes handle it.

### Database connection refused
Wait for MariaDB health check: `docker compose ps` → db must show "healthy"

## License

MIT — see [LICENSE](LICENSE) file.
