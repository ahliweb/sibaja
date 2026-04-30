<?php

namespace App\Controllers;

use App\Models\MetodePengadaanModel;

class MetodePengadaan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MetodePengadaanModel();
    }

    public function index()
    {
        return $this->render('metode_pengadaan/index', [
            'title' => 'Metode Pengadaan',
            'data'  => $this->model->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            if ($this->model->insert($data)) {
                $this->logAudit('metode_pengadaan', 'create', "Metode Pengadaan: {$data['nama']}");
                return redirect()->to('metode-pengadaan')->with('success', 'Data berhasil disimpan.');
            }
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
        return $this->render('metode_pengadaan/create', ['title' => 'Tambah Metode Pengadaan', 'isEdit' => false]);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit($id = null)
    {
        $data = $this->model->find($id);
        if (! $data) return redirect()->to('metode-pengadaan')->with('error', 'Data tidak ditemukan.');
        return $this->render('metode_pengadaan/edit', [
            'title' => 'Edit Metode Pengadaan', 'isEdit' => true,
            'data' => $data,
        ]);
    }

    public function update($id = null)
    {
        if ($this->model->update($id, $this->request->getPost())) {
            $this->logAudit('metode_pengadaan', 'update', "Metode Pengadaan ID: {$id}");
            return redirect()->to('metode-pengadaan')->with('success', 'Data berhasil diperbarui.');
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
        if (! $data) return redirect()->to('metode-pengadaan')->with('error', 'Data tidak ditemukan.');
        return $this->render('metode_pengadaan/show', ['title' => 'Detail Metode Pengadaan', 'data' => $data]);
    }

    public function delete($id = null)
    {
        $this->model->update($id, ['status' => 'nonaktif']);
        $this->logAudit('metode_pengadaan', 'delete', "Metode Pengadaan ID: {$id}");
        return redirect()->to('metode-pengadaan')->with('success', 'Data berhasil dinonaktifkan.');
    }
}
