<?php

namespace App\Controllers;

use App\Models\SettingsModel;

class Settings extends BaseController
{
    public function index()
    {
        $model = new SettingsModel();
        $settings = [];
        foreach ($model->findAll() as $s) {
            $settings[$s['key']] = $s['value'];
        }

        if ($this->request->getMethod() === 'POST') {
            foreach ($this->request->getPost() as $key => $value) {
                $existing = $model->where('key', $key)->first();
                if ($existing) {
                    $this->safeUpdate($model, $existing['id'], ['value' => $value], 'Data pengaturan sudah ada.');
                } else {
                    $this->safeInsert($model, ['key' => $key, 'value' => $value], 'Data pengaturan sudah ada.');
                }
            }
            $this->logAudit('settings', 'update', 'Settings updated');
            return redirect()->to('settings')->with('success', 'Pengaturan berhasil disimpan.');
        }

        return $this->render('settings/index', [
            'title'    => 'Pengaturan',
            'settings' => $settings,
        ]);
    }

    public function update()
    {
        return $this->index();
    }
}
