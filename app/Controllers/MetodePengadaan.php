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
        return $this->render('metode_pengadaan/create', ['title' => 'Tambah Metode Pengadaan', 'isEdit' => false]);
    }

    public function store()
    {
        if ($this->model->insert($this->request->getPost())) {
            return redirect()->to('metode-pengadaan')->with('success', 'Data berhasil disimpan.');
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        return $this->render('metode_pengadaan/edit', [
            'title' => 'Edit Metode Pengadaan', 'isEdit' => true,
            'data' => $this->model->find($id),
        ]);
    }

    public function update($id = null)
    {
        if ($this->model->update($id, $this->request->getPost())) {
            return redirect()->to('metode-pengadaan')->with('success', 'Data berhasil diperbarui.');
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $this->model->update($id, ['status' => 'nonaktif']);
        return redirect()->to('metode-pengadaan')->with('success', 'Data berhasil dinonaktifkan.');
    }
}
