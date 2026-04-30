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
        return $this->render('jenis_pengadaan/create', ['title' => 'Tambah Jenis Pengadaan', 'isEdit' => false]);
    }

    public function store()
    {
        if ($this->model->insert($this->request->getPost())) {
            return redirect()->to('jenis-pengadaan')->with('success', 'Data berhasil disimpan.');
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        return $this->render('jenis_pengadaan/edit', [
            'title' => 'Edit Jenis Pengadaan', 'isEdit' => true,
            'data' => $this->model->find($id),
        ]);
    }

    public function update($id = null)
    {
        if ($this->model->update($id, $this->request->getPost())) {
            return redirect()->to('jenis-pengadaan')->with('success', 'Data berhasil diperbarui.');
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $this->model->update($id, ['status' => 'nonaktif']);
        return redirect()->to('jenis-pengadaan')->with('success', 'Data berhasil dinonaktifkan.');
    }
}
