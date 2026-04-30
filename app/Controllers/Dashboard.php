<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        return match($role) {
            'admin'   => $this->adminDashboard(),
            'petugas' => $this->petugasDashboard(),
            'skpd'    => $this->skpdDashboard(),
            default   => redirect()->to('login'),
        };
    }

    private function adminDashboard()
    {
        $pengajuanModel = new \App\Models\PengajuanModel();
        $skpdModel = new \App\Models\SkpdModel();
        $userModel = new \App\Models\UserModel();

        $data = [
            'title'           => 'Dashboard Admin',
            'total_skpd'      => $skpdModel->where('status', 'aktif')->countAllResults(),
            'total_user'      => $userModel->where('status', 'aktif')->countAllResults(),
            'total_pengajuan'  => $pengajuanModel->countAllResults(),
            'count_diajukan'   => $pengajuanModel->where('status', 'diajukan')->countAllResults(),
            'count_diverifikasi' => $pengajuanModel->where('status', 'diverifikasi')->countAllResults(),
            'count_proses'     => $pengajuanModel->where('status', 'dalam_proses')->countAllResults(),
            'count_selesai'    => $pengajuanModel->where('status', 'selesai')->countAllResults(),
            'count_perbaikan'  => $pengajuanModel->where('status', 'perlu_perbaikan')->countAllResults(),
            'count_ditolak'    => $pengajuanModel->where('status', 'ditolak')->countAllResults(),
            'pengajuan_terbaru' => $pengajuanModel->orderBy('created_at', 'DESC')->limit(10)->findAll(),
        ];

        return $this->render('dashboard/admin', $data);
    }

    private function petugasDashboard()
    {
        $pengajuanModel = new \App\Models\PengajuanModel();
        $dokumenModel = new \App\Models\DokumenModel();

        $data = [
            'title'               => 'Dashboard Petugas',
            'pengajuan_masuk'     => $pengajuanModel->where('status', 'diajukan')->countAllResults(),
            'dokumen_belum'       => $dokumenModel->where('status_verifikasi', 'belum_diperiksa')->countAllResults(),
            'perlu_perbaikan'     => $pengajuanModel->where('status', 'perlu_perbaikan')->countAllResults(),
            'dalam_proses'        => $pengajuanModel->where('status', 'dalam_proses')->countAllResults(),
            'selesai_bulan_ini'   => $pengajuanModel
                ->where('status', 'selesai')
                ->where('MONTH(updated_at)', date('m'))
                ->where('YEAR(updated_at)', date('Y'))
                ->countAllResults(),
            'pengajuan_prioritas' => $pengajuanModel
                ->whereIn('status', ['diajukan', 'perlu_perbaikan'])
                ->orderBy('created_at', 'ASC')
                ->limit(20)
                ->findAll(),
            'dokumen_belum_list'  => $dokumenModel
                ->where('status_verifikasi', 'belum_diperiksa')
                ->orderBy('uploaded_at', 'DESC')
                ->limit(20)
                ->findAll(),
        ];

        return $this->render('dashboard/petugas', $data);
    }

    private function skpdDashboard()
    {
        $pengajuanModel = new \App\Models\PengajuanModel();
        $skpdModel = new \App\Models\SkpdModel();
        $skpdId = $this->currentSkpdId();

        $skpd = $skpdModel->find($skpdId);

        $data = [
            'title'              => 'Dashboard SKPD',
            'skpd'               => $skpd,
            'total_pengajuan'    => $pengajuanModel->where('skpd_id', $skpdId)->countAllResults(),
            'count_draft'        => $pengajuanModel->where('skpd_id', $skpdId)->where('status', 'draft')->countAllResults(),
            'count_diajukan'     => $pengajuanModel->where('skpd_id', $skpdId)->where('status', 'diajukan')->countAllResults(),
            'count_perbaikan'    => $pengajuanModel->where('skpd_id', $skpdId)->where('status', 'perlu_perbaikan')->countAllResults(),
            'count_proses'       => $pengajuanModel->where('skpd_id', $skpdId)->whereIn('status', ['diverifikasi', 'dalam_proses'])->countAllResults(),
            'count_selesai'      => $pengajuanModel->where('skpd_id', $skpdId)->where('status', 'selesai')->countAllResults(),
            'pengajuan_terbaru'  => $pengajuanModel->where('skpd_id', $skpdId)->orderBy('created_at', 'DESC')->limit(10)->findAll(),
        ];

        return $this->render('dashboard/skpd', $data);
    }
}
