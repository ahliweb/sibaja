<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Error — SIBAJA</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <style>body{background:#f4f6f9}.error-page{margin:5% auto;max-width:600px}pre{background:#f8f9fa;padding:1rem;border-radius:4px;overflow-x:auto;font-size:12px}</style>
</head>
<body>
<div class="error-page">
  <h2 class="headline text-danger">500</h2>
  <div class="error-content">
    <h3><i class="fas fa-exclamation-circle text-danger"></i> Terjadi Kesalahan</h3>
    <p><?= esc($message ?? 'Terjadi kesalahan pada server. Silakan coba lagi.') ?></p>
    <p><a href="/dashboard" class="btn btn-primary"><i class="fas fa-home"></i> Kembali ke Dashboard</a></p>
    <?php if (isset($exception) && ENVIRONMENT !== 'production'): ?>
    <hr>
    <h6>Detail Teknis (Development Mode)</h6>
    <pre><?= esc($exception->getMessage()) ?><?= "\n\n" ?><?= esc($exception->getTraceAsString()) ?></pre>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
