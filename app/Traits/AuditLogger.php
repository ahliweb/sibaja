<?php

namespace App\Traits;

trait AuditLogger
{
    protected function logAudit(string $modul, string $aksi, string $deskripsi = ''): void
    {
        try {
            $logModel = new \App\Models\AuditLogModel();
            $logModel->insert([
                'user_id'    => session()->get('user_id'),
                'role'       => session()->get('role'),
                'modul'      => $modul,
                'aksi'       => $aksi,
                'deskripsi'  => $deskripsi,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Audit log failed: ' . $e->getMessage());
        }
    }
}
