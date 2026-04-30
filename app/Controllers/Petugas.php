<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SkpdModel;

class Petugas extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $petugas = $model->where('role', 'petugas')->orderBy('nama', 'ASC')->findAll();
        return $this->render('petugas/index', [
            'title'   => 'Data Petugas',
            'petugas' => $petugas,
        ]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $model = new UserModel();
            $data = $this->request->getPost();
            $data['role'] = 'petugas';
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            if ($model->insert($data)) {
                $this->logAudit('petugas', 'create', "Petugas: {$data['nama']}");
                return redirect()->to('petugas')->with('success', 'Data petugas berhasil disimpan.');
            }
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        return $this->render('petugas/create', ['title' => 'Tambah Petugas', 'isEdit' => false]);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit($id = null)
    {
        $model = new UserModel();
        $data = $model->find($id);
        if (! $data) return redirect()->to('petugas')->with('error', 'Data tidak ditemukan.');
        return $this->render('petugas/edit', [
            'title' => 'Edit Petugas', 'isEdit' => true,
            'data' => $data,
        ]);
    }

    public function update($id = null)
    {
        $model = new UserModel();
        $data = $this->request->getPost();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if ($model->update($id, $data)) {
            $this->logAudit('petugas', 'update', "Petugas ID: {$id}");
            return redirect()->to('petugas')->with('success', 'Data petugas berhasil diperbarui.');
        }
        return redirect()->back()->withInput()->with('errors', $model->errors());
    }

    public function new()
    {
        return $this->create();
    }

    public function show($id = null)
    {
        $model = new UserModel();
        $data = $model->find($id);
        if (! $data) return redirect()->to('petugas')->with('error', 'Data tidak ditemukan.');
        return $this->render('petugas/show', ['title' => 'Detail Petugas', 'data' => $data]);
    }

    public function delete($id = null)
    {
        $model = new UserModel();
        $data = $model->find($id);
        if (! $data) return redirect()->to('petugas')->with('error', 'Data tidak ditemukan.');
        $model->update($id, ['status' => 'nonaktif']);
        $this->logAudit('petugas', 'delete', "Petugas: {$data['nama']}");
        return redirect()->to('petugas')->with('success', 'Petugas berhasil dinonaktifkan.');
    }
}
