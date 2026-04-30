<?php

namespace App\Controllers;

use App\Models\AuditLogModel;

class Audit extends BaseController
{
    public function index()
    {
        $model = new AuditLogModel();
        $logs = $model->getWithUser(500);
        return $this->render('audit/index', [
            'title' => 'Audit Log',
            'logs'  => $logs,
        ]);
    }

    public function show($id = null)
    {
        $model = new AuditLogModel();
        $log = $model->find($id);
        return $this->render('audit/show', [
            'title' => 'Detail Audit Log',
            'log'   => $log,
        ]);
    }
}
