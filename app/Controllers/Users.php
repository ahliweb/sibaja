<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index()
    {
        $model = new \App\Models\UserModel();
        $skpdModel = new \App\Models\SkpdModel();
        $users = $model->orderBy('created_at', 'DESC')->findAll();
        $skpdNames = [];
        foreach ($users as &$u) {
            if ($u['skpd_id']) {
                $s = $skpdModel->find($u['skpd_id']);
                $u['nama_skpd'] = $s['nama_skpd'] ?? '-';
            } else {
                $u['nama_skpd'] = '-';
            }
        }
        return $this->render('users/index', ['title' => 'Data User', 'users' => $users]);
    }

    public function new()
    {
        return $this->create();
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $model = new \App\Models\UserModel();
            $data = $this->request->getPost();
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            if ($model->insert($data)) {
                $this->logAudit('user', 'create', "User: {$data['nama']}");
                return redirect()->to('users')->with('success', 'Data user berhasil disimpan.');
            }
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $skpdModel = new \App\Models\SkpdModel();
        return $this->render('users/create', [
            'title' => 'Tambah User', 'isEdit' => false,
            'skpdList' => $skpdModel->where('status', 'aktif')->findAll(),
        ]);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit($id = null)
    {
        $model = new \App\Models\UserModel();
        $skpdModel = new \App\Models\SkpdModel();
        $data = $model->find($id);
        if (! $data) return redirect()->to('users')->with('error', 'Data tidak ditemukan.');
        return $this->render('users/edit', [
            'title' => 'Edit User', 'isEdit' => true,
            'data' => $data,
            'skpdList' => $skpdModel->where('status', 'aktif')->findAll(),
        ]);
    }

    public function update($id = null)
    {
        $model = new \App\Models\UserModel();
        $data = $this->request->getPost();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if ($model->update($id, $data)) {
            $this->logAudit('user', 'update', "User ID: {$id}");
            return redirect()->to('users')->with('success', 'Data user berhasil diperbarui.');
        }
        return redirect()->back()->withInput()->with('errors', $model->errors());
    }

    public function show($id = null)
    {
        $model = new \App\Models\UserModel();
        $skpdModel = new \App\Models\SkpdModel();
        $user = $model->find($id);
        if (! $user) return redirect()->to('users')->with('error', 'Data tidak ditemukan.');
        if ($user['skpd_id']) {
            $s = $skpdModel->find($user['skpd_id']);
            $user['nama_skpd'] = $s['nama_skpd'] ?? '-';
        }
        return $this->render('users/show', ['title' => 'Detail User', 'data' => $user]);
    }

    public function delete($id = null)
    {
        $model = new \App\Models\UserModel();
        $model->update($id, ['status' => 'nonaktif']);
        $this->logAudit('user', 'delete', "User ID: {$id}");
        return redirect()->to('users')->with('success', 'User berhasil dinonaktifkan.');
    }
}
