<?php

namespace App\Controllers;

use App\Models\SkpdModel;

class Profil extends BaseController
{
    public function index()
    {
        $skpdModel = new SkpdModel();
        $skpd = $skpdModel->find($this->currentSkpdId());

        if ($this->request->getMethod() === 'POST') {
            $skpdModel->update($this->currentSkpdId(), [
                'kontak' => $this->request->getPost('kontak'),
                'email'  => $this->request->getPost('email'),
            ]);
            $this->logAudit('profil', 'update', "Profil SKPD ID: {$this->currentSkpdId()}");
            return redirect()->to('profil')->with('success', 'Profil SKPD berhasil diperbarui.');
        }

        return $this->render('profil/index', [
            'title' => 'Profil SKPD',
            'skpd'  => $skpd,
        ]);
    }

    public function update()
    {
        return $this->index();
    }
}
