<?php

namespace App\Controllers;

use App\Models\DokumenModel;
use App\Models\PengajuanModel;
use App\Models\SkpdModel;

class Dokumen extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DokumenModel();
    }

    public function upload($pengajuanId = null)
    {
        $pengajuan = (new PengajuanModel())->find($pengajuanId);
        if (! $pengajuan) return redirect()->back()->with('error', 'Pengajuan tidak ditemukan.');

        $skpd = (new SkpdModel())->find($pengajuan['skpd_id']);
        $dokumen = $this->model->where('pengajuan_id', $pengajuanId)->findAll();

        return $this->render('dokumen/upload', [
            'title'     => 'Upload Dokumen',
            'pengajuan' => $pengajuan,
            'skpd'      => $skpd,
            'dokumen'   => $dokumen,
        ]);
    }

    public function doUpload($pengajuanId = null)
    {
        $file = $this->request->getFile('file_dokumen');
        if (! $file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'image/jpeg', 'image/png'];
        if (! in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak diperbolehkan. Gunakan: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG.');
        }
        if ($file->getSize() > 10485760) {
            return redirect()->back()->with('error', 'Ukuran file melebihi batas maksimal 10 MB.');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/dokumen', $newName);

        $this->model->insert([
            'pengajuan_id'      => $pengajuanId,
            'user_id'           => $this->currentUserId(),
            'jenis_dokumen'     => $this->request->getPost('jenis_dokumen'),
            'nama_file'         => $newName,
            'nama_asli'         => $file->getClientName(),
            'ukuran'            => $file->getSize(),
            'status_verifikasi' => 'belum_diperiksa',
            'uploaded_at'       => date('Y-m-d H:i:s'),
        ]);

        $this->logAudit('dokumen', 'create', "Dokumen untuk Pengajuan ID: {$pengajuanId}");
        return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
    }

    public function download($id = null)
    {
        $dokumen = $this->model->find($id);
        if (! $dokumen) return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');

        $path = WRITEPATH . 'uploads/dokumen/' . $dokumen['nama_file'];
        if (! file_exists($path)) return redirect()->back()->with('error', 'File tidak ditemukan.');

        return $this->response->download($path, null)->setFileName($dokumen['nama_asli']);
    }

    public function delete($id = null)
    {
        $dokumen = $this->model->find($id);
        $pengajuan = (new PengajuanModel())->find($dokumen['pengajuan_id']);
        if (! in_array($pengajuan['status'], ['draft', 'perlu_perbaikan'])) {
            return redirect()->back()->with('error', 'Dokumen tidak dapat dihapus karena pengajuan sudah diproses.');
        }

        $path = WRITEPATH . 'uploads/dokumen/' . $dokumen['nama_file'];
        if (file_exists($path)) unlink($path);

        $this->model->delete($id);
        $this->logAudit('dokumen', 'delete', "Dokumen ID: {$id}");
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    // === Verifikasi (Admin/Petugas) ===
    public function verifyIndex()
    {
        $dokumen = $this->model->getWithPengajuan();
        return $this->render('dokumen/verify', [
            'title'   => 'Verifikasi Dokumen',
            'dokumen' => $dokumen,
        ]);
    }

    public function doVerify($id = null)
    {
        $data = [
            'status_verifikasi' => $this->request->getPost('status_verifikasi'),
            'catatan'           => $this->request->getPost('catatan'),
        ];
        $this->model->update($id, $data);
        $this->logAudit('dokumen', 'update', "Dokumen ID: {$id}");
        return redirect()->back()->with('success', 'Verifikasi dokumen berhasil disimpan.');
    }
}
