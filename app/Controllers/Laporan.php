<?php

namespace App\Controllers;

use App\Models\PengajuanModel;
use App\Models\SkpdModel;
use App\Models\JenisPengadaanModel;
use App\Models\MetodePengadaanModel;
use App\Models\TahunAnggaranModel;

class Laporan extends BaseController
{
    public function index()
    {
        $model = new PengajuanModel();
        $filterStatus = $this->request->getGet('status');
        $filterSkpd = $this->request->getGet('skpd_id');
        $filterTahun = $this->request->getGet('tahun_id');

        if ($filterStatus) $model->where('status', $filterStatus);
        if ($filterSkpd) $model->where('skpd_id', $filterSkpd);
        if ($filterTahun) $model->where('tahun_anggaran_id', $filterTahun);

        $pengajuan = $model->orderBy('created_at', 'DESC')->findAll();

        $totalPagu = array_sum(array_column($pengajuan, 'pagu_anggaran'));
        $countSelesai = count(array_filter($pengajuan, fn($p) => $p['status'] === 'selesai'));
        $countProses = count(array_filter($pengajuan, fn($p) => in_array($p['status'], ['diverifikasi', 'dalam_proses'])));
        $countPerbaikan = count(array_filter($pengajuan, fn($p) => $p['status'] === 'perlu_perbaikan'));
        $countDitolak = count(array_filter($pengajuan, fn($p) => $p['status'] === 'ditolak'));

        return $this->render('laporan/index', [
            'title'          => 'Laporan Pengajuan',
            'pengajuan'      => $pengajuan,
            'totalPagu'      => $totalPagu,
            'countSelesai'   => $countSelesai,
            'countProses'    => $countProses,
            'countPerbaikan' => $countPerbaikan,
            'countDitolak'   => $countDitolak,
            'skpdList'       => (new SkpdModel())->where('status', 'aktif')->findAll(),
            'tahunList'      => (new TahunAnggaranModel())->orderBy('tahun', 'DESC')->findAll(),
            'filter'         => $this->request->getGet(),
        ]);
    }

    public function pdf()
    {
        return redirect()->back()->with('info', 'Export PDF akan diimplementasikan dengan library Dompdf.');
    }

    public function excel()
    {
        return redirect()->back()->with('info', 'Export Excel akan diimplementasikan dengan library PhpSpreadsheet.');
    }

    public function printView()
    {
        // For print-friendly view
        return $this->index();
    }
}
