<?php

namespace App\Controllers;

use App\Models\PengajuanModel;
use App\Models\SkpdModel;
use App\Models\JenisPengadaanModel;
use App\Models\MetodePengadaanModel;
use App\Models\TahunAnggaranModel;
use App\Models\DokumenModel;
use App\Models\RiwayatProsesModel;

class Pengajuan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PengajuanModel();
    }

    // === Admin/Petugas: All submissions ===
    public function index()
    {
        $result = $this->model->getWithRelations();
        return $this->render('pengajuan/index', [
            'title'      => 'Semua Pengajuan',
            'pengajuan'  => $result,
        ] + $this->listData());
    }

    public function masuk()
    {
        $this->model->where('pengajuan.status', 'diajukan')->orderBy('pengajuan.created_at', 'ASC');
        $result = $this->model->getWithRelations();
        return $this->render('pengajuan/index', [
            'title' => 'Pengajuan Masuk', 'pengajuan' => $result,
        ] + $this->listData());
    }

    public function diproses()
    {
        $this->model->whereIn('pengajuan.status', ['diverifikasi', 'dalam_proses'])->orderBy('pengajuan.created_at', 'DESC');
        $result = $this->model->getWithRelations();
        return $this->render('pengajuan/index', [
            'title' => 'Pengajuan Diproses', 'pengajuan' => $result,
        ] + $this->listData());
    }

    public function selesai()
    {
        $this->model->where('pengajuan.status', 'selesai')->orderBy('pengajuan.updated_at', 'DESC');
        $result = $this->model->getWithRelations();
        return $this->render('pengajuan/index', [
            'title' => 'Pengajuan Selesai', 'pengajuan' => $result,
        ] + $this->listData());
    }

    public function ditolak()
    {
        $this->model->where('pengajuan.status', 'ditolak')->orderBy('pengajuan.updated_at', 'DESC');
        $result = $this->model->getWithRelations();
        return $this->render('pengajuan/index', [
            'title' => 'Pengajuan Ditolak', 'pengajuan' => $result,
        ] + $this->listData());
    }

    // === User SKPD: My submissions ===
    public function myIndex()
    {
        $skpdId = $this->currentSkpdId();
        $pengajuan = $this->model->where('skpd_id', $skpdId)->orderBy('created_at', 'DESC')->findAll();
        return $this->render('pengajuan/my_index', array_merge($this->listData(), [
            'title' => 'Pengajuan Saya', 'pengajuan' => $pengajuan,
        ]));
    }

    // === Create ===
    public function create()
    {
        return $this->render('pengajuan/create', array_merge($this->listData(), [
            'title' => 'Tambah Pengajuan', 'isEdit' => false, 'data' => [],
        ]));
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['skpd_id'] = $this->currentSkpdId();
        $data['user_id'] = $this->currentUserId();
        $data['status'] = $data['status'] ?? 'draft';
        $data['nomor_pengajuan'] = $this->generateNomor();
        $data['tanggal'] = date('Y-m-d');

        if ($this->model->insert($data)) {
            $id = $this->model->getInsertID();
            // Log to riwayat
            (new RiwayatProsesModel())->insert([
                'pengajuan_id' => $id, 'user_id' => $this->currentUserId(),
                'status_sebelum' => null, 'status_baru' => $data['status'],
                'catatan' => 'Pengajuan dibuat',
            ]);
            $this->logAudit('pengajuan', 'create', "Pengajuan: {$data['nomor_pengajuan']}");
            $msg = $data['status'] === 'draft' ? 'Pengajuan disimpan sebagai draft.' : 'Pengajuan berhasil dikirim.';
            return redirect()->to("pengajuan/{$id}")->with('success', $msg);
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    // === Edit ===
    public function edit($id = null)
    {
        $pengajuan = $this->model->find($id);
        if (! $pengajuan) return redirect()->to('pengajuan/my')->with('error', 'Data tidak ditemukan.');
        if (! in_array($pengajuan['status'], ['draft', 'perlu_perbaikan'])) {
            return redirect()->to("pengajuan/{$id}")->with('error', 'Pengajuan tidak dapat diedit karena sudah diproses.');
        }

        return $this->render('pengajuan/edit', array_merge($this->listData(), [
            'title' => 'Edit Pengajuan', 'isEdit' => true, 'data' => $pengajuan,
        ]));
    }

    public function update($id = null)
    {
        $pengajuan = $this->model->find($id);
        if (! $pengajuan) return redirect()->back()->with('error', 'Pengajuan tidak ditemukan.');
        if (! in_array($pengajuan['status'], ['draft', 'perlu_perbaikan'])) {
            return redirect()->to("pengajuan/{$id}")->with('error', 'Pengajuan tidak dapat diedit.');
        }

        $data = $this->request->getPost();
        $data['status'] = $data['status'] ?? $pengajuan['status'];

        if ($this->model->update($id, $data)) {
            return redirect()->to("pengajuan/{$id}")->with('success', 'Pengajuan berhasil diperbarui.');
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    // === Kirim ===
    public function kirim($id = null)
    {
        $pengajuan = $this->model->find($id);
        if (! $pengajuan || $pengajuan['status'] !== 'draft') {
            return redirect()->back()->with('error', 'Hanya pengajuan draft yang bisa dikirim.');
        }

        $this->model->update($id, ['status' => 'diajukan']);
        $this->logAudit('pengajuan', 'update', "Pengajuan ID: {$id}");
        (new RiwayatProsesModel())->insert([
            'pengajuan_id' => $id, 'user_id' => $this->currentUserId(),
            'status_sebelum' => 'draft', 'status_baru' => 'diajukan',
            'catatan' => 'Pengajuan dikirim oleh User SKPD',
        ]);
        return redirect()->to("pengajuan/{$id}")->with('success', 'Pengajuan berhasil dikirim.');
    }

    // === Detail ===
    public function show($id = null)
    {
        $pengajuan = $this->model->find($id);
        if (! $pengajuan) return redirect()->back()->with('error', 'Pengajuan tidak ditemukan.');

        $skpd = (new SkpdModel())->find($pengajuan['skpd_id']);
        $dokumen = (new DokumenModel())->where('pengajuan_id', $id)->findAll();
        $riwayat = (new RiwayatProsesModel())->where('pengajuan_id', $id)->orderBy('created_at', 'ASC')->findAll();

        return $this->render('pengajuan/show', [
            'title'     => 'Detail Pengajuan',
            'pengajuan' => $pengajuan,
            'skpd'      => $skpd,
            'dokumen'   => $dokumen,
            'riwayat'   => $riwayat,
        ]);
    }

    // === Status Form (Admin/Petugas) ===
    public function statusForm($id = null)
    {
        $pengajuan = $this->model->find($id);
        if (! $pengajuan) return redirect()->to('pengajuan')->with('error', 'Pengajuan tidak ditemukan.');
        return $this->render('pengajuan/status_form', [
            'title' => 'Ubah Status', 'pengajuan' => $pengajuan,
        ]);
    }

    public function updateStatus($id = null)
    {
        $pengajuan = $this->model->find($id);
        if (! $pengajuan) return redirect()->to('pengajuan')->with('error', 'Pengajuan tidak ditemukan.');
        $statusBaru = $this->request->getPost('status_baru');
        $catatan = $this->request->getPost('catatan');

        $this->model->update($id, ['status' => $statusBaru]);
        $this->logAudit('pengajuan', 'update', "Pengajuan ID: {$id}");
        (new RiwayatProsesModel())->insert([
            'pengajuan_id' => $id, 'user_id' => $this->currentUserId(),
            'status_sebelum' => $pengajuan['status'], 'status_baru' => $statusBaru,
            'catatan' => $catatan,
        ]);
        return redirect()->to("pengajuan/{$id}")->with('success', 'Status pengajuan berhasil diubah.');
    }

    // === Helpers ===
    private function generateNomor(): string
    {
        $skpdModel = new SkpdModel();
        $skpd = $skpdModel->find($this->currentSkpdId());
        $kode = $skpd['kode_skpd'] ?? 'XX';
        $prefix = 'PENG-' . date('Y') . '-' . date('m') . '-' . $kode . '-';
        $last = $this->model
            ->like('nomor_pengajuan', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();
        $seq = $last ? (int) substr($last['nomor_pengajuan'], -3) + 1 : 1;
        return $prefix . str_pad((string) $seq, 3, '0', STR_PAD_LEFT);
    }

    private function listData(): array
    {
        return [
            'skpdList'   => (new SkpdModel())->where('status', 'aktif')->findAll(),
            'jenisList'  => (new JenisPengadaanModel())->where('status', 'aktif')->findAll(),
            'metodeList' => (new MetodePengadaanModel())->where('status', 'aktif')->findAll(),
            'tahunList'  => (new TahunAnggaranModel())->orderBy('tahun', 'DESC')->findAll(),
        ];
    }
}
