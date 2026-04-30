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

    public function create()
    {
        return $this->render('skpd/create', ['title' => 'Tambah SKPD', 'isEdit' => false]);
    }

    public function store()
    {
        $model = new \App\Models\SkpdModel();
        $data = $this->request->getPost();
        if ($model->insert($data)) {
            $this->logAudit('skpd', 'create', "SKPD: {$data['nama_skpd']}");
            return redirect()->to('skpd')->with('success', 'Data SKPD berhasil disimpan.');
        }
        return redirect()->back()->withInput()->with('errors', $model->errors());
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
        if ($model->update($id, $this->request->getPost())) {
            $this->logAudit('skpd', 'update', "SKPD ID: {$id}");
            return redirect()->to('skpd')->with('success', 'Data SKPD berhasil diperbarui.');
        }
        return redirect()->back()->withInput()->with('errors', $model->errors());
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
