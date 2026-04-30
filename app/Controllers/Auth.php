<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('dashboard');
        }
        return view('auth/login', ['title' => 'Login']);
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('username', $username)->first();

        if (! $user) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        if ($user['status'] !== 'aktif') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif. Silakan hubungi admin.');
        }

        if (! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        // Set session
        session()->set([
            'user_id'    => $user['id'],
            'nama'       => $user['nama'],
            'username'   => $user['username'],
            'role'       => $user['role'],
            'skpd_id'    => $user['skpd_id'] ?? null,
            'isLoggedIn' => true,
        ]);

        // Update last login
        $userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

        // Audit log
        $this->logAudit('auth', 'login', "User {$user['username']} login");

        return redirect()->to('dashboard');
    }

    public function logout()
    {
        $username = session()->get('username');
        session()->destroy();
        return redirect()->to('login')->with('success', 'Anda telah logout.');
    }

    public function changePassword()
    {
        return $this->render('auth/change_password', ['title' => 'Ganti Password']);
    }

    public function updatePassword()
    {
        $rules = [
            'password_lama'       => 'required',
            'password_baru'       => 'required|min_length[8]',
            'password_konfirmasi' => 'required|matches[password_baru]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($this->currentUserId());

        if (! password_verify($this->request->getPost('password_lama'), $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai.');
        }

        $userModel->update($this->currentUserId(), [
            'password' => password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT),
        ]);

        session()->destroy();
        return redirect()->to('login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
    }

    private function logAudit(string $modul, string $aksi, string $deskripsi = ''): void
    {
        try {
            $logModel = new \App\Models\AuditLogModel();
            $logModel->insert([
                'user_id'    => $this->currentUserId(),
                'role'       => session()->get('role'),
                'modul'      => $modul,
                'aksi'       => $aksi,
                'deskripsi'  => $deskripsi,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            // silent fail
        }
    }
}
