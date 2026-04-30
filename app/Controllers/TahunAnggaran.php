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
        return $this->render('tahun_anggaran/create', ['title' => 'Tambah Tahun Anggaran', 'isEdit' => false]);
    }

    public function store()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            $this->logAudit('tahun_anggaran', 'create', "Tahun Anggaran: {$data['tahun']}");
            return redirect()->to('tahun-anggaran')->with('success', 'Data berhasil disimpan.');
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        return $this->render('tahun_anggaran/edit', [
            'title' => 'Edit Tahun Anggaran', 'isEdit' => true,
            'data' => $this->model->find($id),
        ]);
    }

    public function update($id = null)
    {
        if ($this->model->update($id, $this->request->getPost())) {
            $this->logAudit('tahun_anggaran', 'update', "Tahun Anggaran ID: {$id}");
            return redirect()->to('tahun-anggaran')->with('success', 'Data berhasil diperbarui.');
        }
        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $this->model->update($id, ['status' => 'nonaktif']);
        $this->logAudit('tahun_anggaran', 'delete', "Tahun Anggaran ID: {$id}");
        return redirect()->to('tahun-anggaran')->with('success', 'Data berhasil dinonaktifkan.');
    }
}
