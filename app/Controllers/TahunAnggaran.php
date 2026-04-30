<?php

namespace App\Controllers;

use App\Models\TahunAnggaranModel;

class TahunAnggaran extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TahunAnggaranModel();
    }

    public function index()
    {
        return $this->render('tahun_anggaran/index', [
            'title' => 'Tahun Anggaran',
            'data'  => $this->model->orderBy('tahun', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            if ($this->safeInsert($this->model, $data, 'Tahun anggaran sudah ada.')) {
                $this->logAudit('tahun_anggaran', 'create', "Tahun Anggaran: {$data['tahun']}");
                return redirect()->to('tahun-anggaran')->with('success', 'Data berhasil disimpan.');
            }
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
        return $this->render('tahun_anggaran/create', ['title' => 'Tambah Tahun Anggaran', 'isEdit' => false]);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit($id = null)
    {
        $data = $this->model->find($id);
        if (! $data) return redirect()->to('tahun-anggaran')->with('error', 'Data tidak ditemukan.');
        return $this->render('tahun_anggaran/edit', [
            'title' => 'Edit Tahun Anggaran', 'isEdit' => true,
            'data' => $data,
        ]);
    }

    public function update($id = null)
    {
        if ($this->safeUpdate($this->model, $id, $this->request->getPost(), 'Tahun anggaran sudah ada.')) {
            $this->logAudit('tahun_anggaran', 'update', "Tahun Anggaran ID: {$id}");
            return redirect()->to('tahun-anggaran')->with('success', 'Data berhasil diperbarui.');
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function new()
    {
        return $this->create();
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (! $data) return redirect()->to('tahun-anggaran')->with('error', 'Data tidak ditemukan.');
        return $this->render('tahun_anggaran/show', ['title' => 'Detail Tahun Anggaran', 'data' => $data]);
    }

    public function delete($id = null)
    {
        $this->model->update($id, ['status' => 'nonaktif']);
        $this->logAudit('tahun_anggaran', 'delete', "Tahun Anggaran ID: {$id}");
        return redirect()->to('tahun-anggaran')->with('success', 'Data berhasil dinonaktifkan.');
    }
}
