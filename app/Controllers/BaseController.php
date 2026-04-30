<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
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
}
