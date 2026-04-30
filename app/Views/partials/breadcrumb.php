<?php
$segments = service('uri')->getSegments();
$breadcrumb = [['label' => 'Beranda', 'url' => base_url('dashboard')]];
$url = '';
$ignoreSegments = ['index', 'create', 'edit', 'show', 'my', 'masuk', 'diproses', 'selesai', 'ditolak', 'upload', 'verify'];

foreach ($segments as $i => $segment) {
    if (is_numeric($segment) || in_array($segment, $ignoreSegments)) {
        continue;
    }
    $url .= '/' . $segment;
    $label = ucwords(str_replace(['-', '_'], ' ', $segment));
    $isLast = ($i === count($segments) - 1);
    $breadcrumb[] = ['label' => $label, 'url' => $isLast ? null : base_url(ltrim($url, '/'))];
}
?>
<div class="row">
  <div class="col-sm-6">
    <h3 class="mb-0"><?= esc($title ?? 'SIBAJA') ?></h3>
  </div>
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
      <?php foreach ($breadcrumb as $item): ?>
        <?php if (isset($item['url'])): ?>
          <li class="breadcrumb-item"><a href="<?= $item['url'] ?>"><?= esc($item['label']) ?></a></li>
        <?php else: ?>
          <li class="breadcrumb-item active" aria-current="page"><?= esc($item['label']) ?></li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ol>
  </div>
</div>
