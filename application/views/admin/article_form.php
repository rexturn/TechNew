<?php defined('BASEPATH') OR exit('No direct script access allowed');
$is_edit = isset($article);
$form_action = $is_edit ? 'admin/update/' . $article->id : 'admin/store';
$title_val = $is_edit ? $article->title : set_value('title');
$cat_val   = $is_edit ? $article->category_id : set_value('category_id');
$author_val = $is_edit ? $article->author : set_value('author');
$content_val = $is_edit ? $article->content : set_value('content');
$date_val  = $is_edit ? date('Y-m-d\TH:i', strtotime($article->publish_date)) : set_value('publish_date', date('Y-m-d\TH:i'));
?>

<?php if ($this->session->flashdata('upload_error')): ?>
<div class="alert alert-error">&#9888; <?php echo htmlspecialchars($this->session->flashdata('upload_error'), ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="form-card">
    <h2 style="font-size: 15px; text-transform: uppercase; letter-spacing: 1px; color: #fff; margin-bottom: 20px;">
        <?php echo $is_edit ? '&#9998; Edit Artikel' : '+ Tambah Artikel Baru'; ?>
    </h2>

    <?php echo form_open_multipart($form_action); ?>

        <div class="form-group">
            <label for="title">Judul <span class="req">*</span></label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Judul artikel (min. 10 karakter)" value="<?php echo htmlspecialchars($title_val, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo form_error('title', '<span class="form-error">', '</span>'); ?>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Kategori <span class="req">*</span></label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat->id; ?>" <?php echo set_select('category_id', $cat->id, ($cat_val == $cat->id)); ?>><?php echo htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('category_id', '<span class="form-error">', '</span>'); ?>
            </div>
            <div class="form-group">
                <label for="author">Penulis <span class="req">*</span></label>
                <input type="text" name="author" id="author" class="form-control" placeholder="Nama penulis (min. 3 karakter)" value="<?php echo htmlspecialchars($author_val, ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo form_error('author', '<span class="form-error">', '</span>'); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="publish_date">Tanggal Publikasi <span class="req">*</span></label>
            <input type="datetime-local" name="publish_date" id="publish_date" class="form-control" value="<?php echo htmlspecialchars($date_val, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo form_error('publish_date', '<span class="form-error">', '</span>'); ?>
        </div>

        <div class="form-group">
            <label for="image">Gambar</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <div class="form-hint">Format: JPG, PNG, WebP, GIF. Maksimal 2MB. (Opsional - gunakan gambar default jika kosong)</div>
            <?php if ($is_edit && $article->image): ?>
            <div class="upload-preview show">
                <img src="<?php echo base_url('application/uploads/' . $article->image); ?>" alt="Preview">
            </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Isi Artikel <span class="req">*</span></label>
            <div class="quill-wrap">
                <div id="editor"><?php echo $content_val; ?></div>
            </div>
            <?php echo form_error('content', '<span class="form-error">', '</span>'); ?>
            <!-- Hidden field for Quill content -->
            <textarea name="content" id="content" class="form-control" style="display:none;"><?php echo htmlspecialchars($content_val, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'SIMPAN PERUBAHAN' : 'SIMPAN ARTIKEL'; ?></button>
            <a href="<?php echo site_url('admin/articles'); ?>" class="btn btn-outline">BATAL</a>
        </div>

    <?php echo form_close(); ?>
</div>

<!-- Quill.js CDN -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
(function () {
    var toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'script': 'sub' }, { 'script': 'super' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],
        [{ 'color': [] }, { 'background': [] }],
        ['link'],
        ['clean']
    ];

    var content = document.getElementById('content');
    var editor = new Quill('#editor', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions },
        placeholder: 'Tulis isi artikel di sini... Gunakan toolbar untuk Heading, Bold, Italic, Bullet List, dan Hyperlink.'
    });

    // Load existing content (edit mode)
    if (content.value.trim() !== '') {
        editor.root.innerHTML = content.value;
    }

    // Sync Quill content to hidden textarea on submit
    var form = document.querySelector('.form-card form');
    form.addEventListener('submit', function () {
        content.value = editor.root.innerHTML;
    });
})();
</script>
