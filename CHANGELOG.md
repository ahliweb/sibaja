# Changelog

All notable changes to SIBAJA — Sistem Informasi Barang dan Jasa are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [2.0.0] — 2026-04-30

### Added

- **Authentication**: Login with username/password, session-based auth, role-aware redirects, password change (self-service), CSRF protection.
- **Role-Based Dashboards**: Admin (8 stat cards + recent submissions), Petugas (priority queue + document verification), User SKPD (own submissions + SKPD identity).
- **Master Data CRUD** (Admin only): SKPD, Users, Petugas, Jenis Pengadaan, Metode Pengadaan, Tahun Anggaran.
- **Procurement Workflow**: Full state machine (`draft → diajukan → diverifikasi → dalam_proses → selesai/ditolak`), auto-generate nomor pengajuan, status change timeline.
- **Document Management**: Upload (PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG, max 10 MB), verify/revise/reject workflow.
- **Reports**: Filter by tahun/SKPD/status/jenis/metode/date range, summary statistics, export PDF (Dompdf) and Excel (PhpSpreadsheet), print-friendly view.
- **Audit Log**: Admin-only activity tracking (login, logout, CUD, upload, verify, status change, export), cleanup command `php spark sibaja:audit-clean`.
- **Settings**: Key-value configuration via web UI.
- **System Commands**: `sibaja:reset` (migrate:refresh + seed), `sibaja:audit-clean` (purge logs > 90 days).
- **AdminLTE 4 UI**: Responsive layout with sidebar, navbar, breadcrumb, flash messages, DataTables (Indonesian locale), modal confirm, timeline component.
- **Docker Setup**: PHP 8.2 + Apache + MariaDB 10.11 + phpMyAdmin via `docker compose`.

### Changed

- **Framework Upgrade**: Migrated from CodeIgniter 3 (±2016) to CodeIgniter 4.7+ with new Boot class bootstrap.
- **Architecture**: Modern MVC structure with 10 models, 13 controllers, AuthFilter, validation rules, audit logger trait.
- **Config**: Added Paths, Constants, Autoload, Modules, Services, Session, Boot, and 30+ Config files for CI4 v4.7 compatibility.
- **Database**: 10 migration tables with foreign key relationships and seeded default data (admin, petugas, SKPD users, master data).

### Fixed

- **Route Patterns**: Standardized to RESTful `/{id}/edit`, `/{id}/update`, `/{id}/delete`; added explicit GET routes for create actions.
- **Form Actions**: Consolidated create/store into single methods; correct CSRF-protected delete via POST.
- **Validation**: Model-level validation rules with Indonesian error messages; pagu_anggaran sanitization (thousand separators stripped on submit).
- **Exception Handling**: Replaced `safeUpdate` with try-catch blocks; null-checks for DB records and input data.
- **Role Helpers**: Replaced legacy helper methods with session-based checks across views.
- **Views**: Corrected edit route URLs, formatRupiah cast to int for display.

### Security

- CSRF protection (cookie-based) on all POST forms.
- Password hashing with bcrypt (`PASSWORD_DEFAULT`).
- AuthFilter for role-based access control (admin, petugas, skpd).
- Input validation at model layer.

### Documentation

- Comprehensive README with quick start, features, DB schema, routing, role permissions, troubleshooting.
- Prompt specifications for backend and UI/UX in `temp/`.

[2.0.0]: https://github.com/ahliweb/sibaja/releases/tag/v2.0.0
