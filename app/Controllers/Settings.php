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

        if ($this->request->getMethod() === 'post') {
            foreach ($this->request->getPost() as $key => $value) {
                $existing = $model->where('key', $key)->first();
                if ($existing) {
                    $model->update($existing['id'], ['value' => $value]);
                } else {
                    $model->insert(['key' => $key, 'value' => $value]);
                }
            }
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
