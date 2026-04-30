<?php

if (! function_exists('statusClass')) {
    function statusClass(string $status): string
    {
        return match ($status) {
            'draft'           => 'secondary',
            'diajukan'        => 'primary',
            'diverifikasi'    => 'success',
            'perlu_perbaikan' => 'warning',
            'dalam_proses'    => 'info',
            'selesai'         => 'success',
            'ditolak'         => 'danger',
            'belum_diperiksa' => 'secondary',
            'lengkap'         => 'success',
            'aktif'           => 'success',
            'nonaktif'        => 'secondary',
            default           => 'light',
        };
    }
}

if (! function_exists('statusLabel')) {
    function statusLabel(string $status): string
    {
        return match ($status) {
            'draft'           => 'Draft',
            'diajukan'        => 'Diajukan',
            'diverifikasi'    => 'Diverifikasi',
            'perlu_perbaikan' => 'Perlu Perbaikan',
            'dalam_proses'    => 'Dalam Proses',
            'selesai'         => 'Selesai',
            'ditolak'         => 'Ditolak',
            'belum_diperiksa' => 'Belum Diperiksa',
            'lengkap'         => 'Lengkap',
            'aktif'           => 'Aktif',
            'nonaktif'        => 'Nonaktif',
            default           => ucfirst($status),
        };
    }
}

if (! function_exists('statusLabelDokumen')) {
    function statusLabelDokumen(string $status): string
    {
        return match ($status) {
            'belum_diperiksa' => 'Belum Diperiksa',
            'lengkap'         => 'Lengkap',
            'perlu_perbaikan' => 'Perlu Perbaikan',
            'ditolak'         => 'Ditolak',
            default           => ucfirst($status),
        };
    }
}

if (! function_exists('statusIcon')) {
    function statusIcon(string $status): string
    {
        return match ($status) {
            'draft'           => 'fa-pencil-alt',
            'diajukan'        => 'fa-paper-plane',
            'diverifikasi'    => 'fa-check-circle',
            'perlu_perbaikan' => 'fa-exclamation-triangle',
            'dalam_proses'    => 'fa-spinner',
            'selesai'         => 'fa-check-double',
            'ditolak'         => 'fa-times-circle',
            'belum_diperiksa' => 'fa-clock',
            'lengkap'         => 'fa-check-circle',
            default           => 'fa-circle',
        };
    }
}

if (! function_exists('formatRupiah')) {
    function formatRupiah($angka): string
    {
        $angka = is_string($angka) ? str_replace('.', '', $angka) : $angka;
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}
