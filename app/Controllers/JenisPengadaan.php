<?php

namespace App\Controllers;

use App\Models\JenisPengadaanModel;

class JenisPengadaan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new JenisPengadaanModel();
    }

    public function index()
    {
        return $this->render('jenis_pengadaan/index', [
            'title' => 'Jenis Pengadaan',
            'data'  => $this->model->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            if ($this->model->insert($data)) {
                $this->logAudit('jenis_pengadaan', 'create', "Jenis Pengadaan: {$data['nama']}");
                return redirect()->to('jenis-pengadaan')->with('success', 'Data berhasil disimpan.');
            }
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
        return $this->render('jenis_pengadaan/create', ['title' => 'Tambah Jenis Pengadaan', 'isEdit' => false]);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit($id = null)
    {
        $data = $this->model->find($id);
        if (! $data) return redirect()->to('jenis-pengadaan')->with('error', 'Data tidak ditemukan.');
        return $this->render('jenis_pengadaan/edit', [
            'title' => 'Edit Jenis Pengadaan', 'isEdit' => true,
            'data' => $data,
        ]);
    }

    public function update($id = null)
    {
        if ($this->model->update($id, $this->request->getPost())) {
            $this->logAudit('jenis_pengadaan', 'update', "Jenis Pengadaan ID: {$id}");
            return redirect()->to('jenis-pengadaan')->with('success', 'Data berhasil diperbarui.');
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
        if (! $data) return redirect()->to('jenis-pengadaan')->with('error', 'Data tidak ditemukan.');
        return $this->render('jenis_pengadaan/show', ['title' => 'Detail Jenis Pengadaan', 'data' => $data]);
    }

    public function delete($id = null)
    {
        $this->model->update($id, ['status' => 'nonaktif']);
        $this->logAudit('jenis_pengadaan', 'delete', "Jenis Pengadaan ID: {$id}");
        return redirect()->to('jenis-pengadaan')->with('success', 'Data berhasil dinonaktifkan.');
    }
}
