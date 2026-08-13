<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success">&#10003; <?php echo htmlspecialchars($this->session->flashdata('success_msg'), ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<!-- Stat Cards -->
<div class="stat-grid">
    <div class="stat-card stat-red">
        <span class="stat-icon">&#128196;</span>
        <div class="stat-label">Total Artikel</div>
        <div class="stat-value"><?php echo $total_articles; ?></div>
    </div>
    <div class="stat-card stat-cyan">
        <span class="stat-icon">&#128193;</span>
        <div class="stat-label">Total Kategori</div>
        <div class="stat-value"><?php echo $total_categories; ?></div>
    </div>
    <div class="stat-card stat-green">
        <span class="stat-icon">&#11088;</span>
        <div class="stat-label">Artikel Terbaru</div>
        <div class="stat-value"><?php echo $total_articles; ?></div>
    </div>
</div>

<!-- Recent Articles -->
<div class="dash-section-title">
    <span class="sec-index" style="color: var(--red); font-family: var(--font-head);">//</span>
    <h2>Artikel Terbaru</h2>
    <span class="line"></span>
</div>

<?php if ($recent_articles): ?>
<table class="dash-table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Penulis</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recent_articles as $article): ?>
        <tr>
            <td class="table-title"><?php echo htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><span class="badge-cat <?php echo $article->category_slug === 'cybersecurity' ? 'cyber' : ''; ?>"><?php echo htmlspecialchars($article->category_name, ENT_QUOTES, 'UTF-8'); ?></span></td>
            <td><?php echo htmlspecialchars($article->author, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo date('d M Y H:i', strtotime($article->publish_date)); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p style="color: var(--text-mute);">Belum ada artikel.</p>
<?php endif; ?>
