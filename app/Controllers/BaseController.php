<?php

namespace App\Controllers;

use App\Traits\AuditLogger;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;

class BaseController extends Controller
{
    use AuditLogger;

    protected $helpers = ['sibaja', 'form', 'session', 'url', 'html'];

    protected function isAdmin(): bool
    {
        return session()->get('role') === 'admin';
    }

    protected function isPetugas(): bool
    {
        return session()->get('role') === 'petugas';
    }

    protected function isSkpd(): bool
    {
        return session()->get('role') === 'skpd';
    }

    protected function currentUserId(): ?int
    {
        return session()->get('user_id');
    }

    protected function currentSkpdId(): ?int
    {
        return session()->get('skpd_id');
    }

    protected function render(string $view, array $data = []): string
    {
        return view($view, array_merge($data, [
            'user' => [
                'id'    => session()->get('user_id'),
                'nama'  => session()->get('nama'),
                'role'  => session()->get('role'),
                'skpd_id' => session()->get('skpd_id'),
            ],
        ]));
    }

    protected function safeInsert($model, array $data, string $errorMsg = 'Data sudah ada atau tidak valid.'): bool
    {
        try {
            return $model->insert($data);
        } catch (DatabaseException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                session()->setFlashdata('error', $errorMsg);
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan database.');
            }
            session()->setFlashdata('errors', $model->errors());
            return false;
        }
    }

    protected function safeUpdate($model, $id, array $data, string $errorMsg = 'Data sudah ada atau tidak valid.'): bool
    {
        try {
            return $model->update($id, $data);
        } catch (DatabaseException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                session()->setFlashdata('error', $errorMsg);
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan database.');
            }
            session()->setFlashdata('errors', $model->errors());
            return false;
        }
    }
}
