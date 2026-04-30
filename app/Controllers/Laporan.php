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

    private function getFilteredData(): array
    {
        $model = new PengajuanModel();
        $filterStatus = $this->request->getGet('status');
        $filterSkpd = $this->request->getGet('skpd_id');
        $filterTahun = $this->request->getGet('tahun_id');

        if ($filterStatus) $model->where('status', $filterStatus);
        if ($filterSkpd) $model->where('skpd_id', $filterSkpd);
        if ($filterTahun) $model->where('tahun_anggaran_id', $filterTahun);

        return $model->orderBy('created_at', 'DESC')->findAll();
    }

    public function pdf()
    {
        $pengajuan = $this->getFilteredData();
        $this->logAudit('laporan', 'export_pdf', 'Laporan: export PDF');

        $html = '<h2 style="text-align:center">Laporan Pengajuan Barang/Jasa</h2>';
        $html .= '<p style="text-align:center">SIBAJA — Sekretariat Daerah Kabupaten Kotawaringin Barat</p>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;font-size:11px">';
        $html .= '<tr style="background:#eee"><th>No</th><th>Nomor</th><th>Tanggal</th><th>Nama Paket</th><th>Pagu</th><th>Status</th></tr>';

        $totalPagu = 0;
        foreach ($pengajuan as $i => $p) {
            $no = $i + 1;
            $totalPagu += $p['pagu_anggaran'] ?? 0;
            $html .= "<tr><td>{$no}</td><td>{$p['nomor_pengajuan']}</td><td>" . date('d/m/Y', strtotime($p['tanggal'])) . "</td><td>{$p['nama_paket']}</td><td>" . formatRupiah($p['pagu_anggaran'] ?? 0) . "</td><td>" . statusLabel($p['status']) . "</td></tr>";
        }
        $html .= '<tr style="background:#eee"><td colspan="4" align="right"><strong>Total Pagu:</strong></td><td colspan="2"><strong>' . formatRupiah($totalPagu) . '</strong></td></tr>';
        $html .= '</table>';

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-pengajuan.pdf', ['Attachment' => 0]);
        exit;
    }

    public function excel()
    {
        $pengajuan = $this->getFilteredData();
        $this->logAudit('laporan', 'export_excel', 'Laporan: export Excel');

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pengajuan');

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nomor Pengajuan');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Nama Paket');
        $sheet->setCellValue('E1', 'Pagu Anggaran');
        $sheet->setCellValue('F1', 'Status');

        $row = 2;
        foreach ($pengajuan as $i => $p) {
            $sheet->setCellValue("A{$row}", $i + 1);
            $sheet->setCellValue("B{$row}", $p['nomor_pengajuan']);
            $sheet->setCellValue("C{$row}", date('d/m/Y', strtotime($p['tanggal'])));
            $sheet->setCellValue("D{$row}", $p['nama_paket']);
            $sheet->setCellValue("E{$row}", $p['pagu_anggaran'] ?? 0);
            $sheet->setCellValue("F{$row}", statusLabel($p['status']));
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laporan-pengajuan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function printView()
    {
        $pengajuan = $this->getFilteredData();
        $totalPagu = array_sum(array_column($pengajuan, 'pagu_anggaran'));
        $countSelesai = count(array_filter($pengajuan, fn($p) => $p['status'] === 'selesai'));
        $countProses = count(array_filter($pengajuan, fn($p) => in_array($p['status'], ['diverifikasi', 'dalam_proses'])));

        return view('laporan/print', [
            'title'         => 'Cetak Laporan',
            'pengajuan'     => $pengajuan,
            'totalPagu'     => $totalPagu,
            'countSelesai'  => $countSelesai,
            'countProses'   => $countProses,
        ]);
    }
}
