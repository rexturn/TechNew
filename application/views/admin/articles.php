<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success">&#10003; <?php echo htmlspecialchars($this->session->flashdata('success_msg'), ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="toolbar">
    <div class="tb-title">
        <h2>Daftar Artikel</h2>
    </div>
    <a href="<?php echo site_url('admin/create'); ?>" class="btn btn-primary">+ TAMBAH ARTIKEL</a>
</div>

<?php if ($articles): ?>
<table class="dash-table">
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Penulis</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article): ?>
        <tr>
            <td>
                <div class="thumb-cell">
                    <img src="<?php echo base_url('application/uploads/' . $article->image); ?>" alt="<?php echo htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </td>
            <td class="table-title"><?php echo htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><span class="badge-cat <?php echo $article->category_slug === 'cybersecurity' ? 'cyber' : ''; ?>"><?php echo htmlspecialchars($article->category_name, ENT_QUOTES, 'UTF-8'); ?></span></td>
            <td><?php echo htmlspecialchars($article->author, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo date('d M Y H:i', strtotime($article->publish_date)); ?></td>
            <td>
                <div class="table-actions">
                    <a href="<?php echo site_url('home/detail/' . $article->id); ?>" target="_blank" class="action-btn view">&#128065; Lihat</a>
                    <a href="<?php echo site_url('admin/edit/' . $article->id); ?>" class="action-btn edit">&#9998; Edit</a>
                    <a href="<?php echo site_url('admin/delete/' . $article->id); ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus artikel ini?');">&#10005; Hapus</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<div class="search-empty" style="text-align: center; padding: 50px; background: var(--surface); border: 1px dashed var(--border); border-radius: var(--radius); color: var(--text-mute);">
    <p>Belum ada artikel. Klik tombol tambah untuk membuat artikel baru.</p>
</div>
<?php endif; ?>
