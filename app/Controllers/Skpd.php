<?php

namespace App\Controllers;

class Skpd extends BaseController
{
    public function index()
    {
        $model = new \App\Models\SkpdModel();
        $data = [
            'title' => 'Data SKPD',
            'skpd'  => $model->orderBy('kode_skpd', 'ASC')->findAll(),
        ];
        return $this->render('skpd/index', $data);
    }

    public function new()
    {
        return $this->create();
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $model = new \App\Models\SkpdModel();
            $data = $this->request->getPost();
            if ($this->safeInsert($model, $data, 'Data SKPD sudah ada.')) {
                $this->logAudit('skpd', 'create', "SKPD: {$data['nama_skpd']}");
                return redirect()->to('skpd')->with('success', 'Data SKPD berhasil disimpan.');
            }
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        return $this->render('skpd/create', ['title' => 'Tambah SKPD', 'isEdit' => false]);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit($id = null)
    {
        $model = new \App\Models\SkpdModel();
        $data = $model->find($id);
        if (! $data) return redirect()->to('skpd')->with('error', 'Data tidak ditemukan.');
        return $this->render('skpd/edit', ['title' => 'Edit SKPD', 'isEdit' => true, 'data' => $data]);
    }

    public function update($id = null)
    {
        $model = new \App\Models\SkpdModel();
        try {
            $model->skipValidation(true)->update($id, $this->request->getPost());
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return redirect()->back()->withInput()->with('error', 'Data SKPD sudah ada.');
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan database.');
        }
        $this->logAudit('skpd', 'update', "SKPD ID: {$id}");
        return redirect()->to('skpd')->with('success', 'Data SKPD berhasil diperbarui.');
    }

    public function show($id = null)
    {
        $model = new \App\Models\SkpdModel();
        $data = $model->find($id);
        if (! $data) return redirect()->to('skpd')->with('error', 'Data tidak ditemukan.');
        return $this->render('skpd/show', ['title' => 'Detail SKPD', 'data' => $data]);
    }

    public function delete($id = null)
    {
        $model = new \App\Models\SkpdModel();
        $model->update($id, ['status' => 'nonaktif']);
        $this->logAudit('skpd', 'delete', "SKPD ID: {$id}");
        return redirect()->to('skpd')->with('success', 'Data SKPD berhasil dinonaktifkan.');
    }
}
