<?php

namespace App\Controllers;

use App\Traits\AuditLogger;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\Exceptions\DataException;

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

    /**
     * Insert data with proper error handling.
     *
     * Model::insert() returns int|false (the primary key on success, false on failure).
     * Per CI4 docs: https://codeigniter.com/user_guide/models/model.html#insert
     */
    protected function safeInsert($model, array $data, string $errorMsg = 'Data sudah ada atau tidak valid.'): bool
    {
        try {
            $result = $model->insert($data);

            if ($result === false) {
                session()->setFlashdata('error', $errorMsg);
                session()->setFlashdata('errors', $model->errors());
                return false;
            }

            return true;
        } catch (DatabaseException | DataException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                session()->setFlashdata('error', $errorMsg);
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan database.');
            }
            session()->setFlashdata('errors', $model->errors());
            return false;
        }
    }

    /**
     * Update data with proper error handling.
     *
     * Model::update() returns true|false.
     * Per CI4 docs: https://codeigniter.com/user_guide/models/model.html#update
     */
    protected function safeUpdate($model, $id, array $data, string $errorMsg = 'Data sudah ada atau tidak valid.'): bool
    {
        try {
            $result = $model->update($id, $data);

            if ($result === false) {
                session()->setFlashdata('error', $errorMsg);
                session()->setFlashdata('errors', $model->errors());
                return false;
            }

            return true;
        } catch (DatabaseException | DataException $e) {
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
