<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="search-hero">
    <div class="container">
        <h1 class="glitch" data-text="HASIL PENCARIAN">HASIL PENCARIAN</h1>
        <?php if ($keyword): ?>
        <p>Menampilkan hasil untuk <span class="search-term">"<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"</span></p>
        <?php else: ?>
        <p>Masukkan kata kunci melalui kolom pencarian di atas.</p>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <?php if ($keyword && $articles): ?>
    <div class="news-grid" style="margin-top: 30px;">
        <?php foreach ($articles as $article): ?>
        <article class="news-card">
            <a href="<?php echo site_url('home/detail/' . $article->id); ?>" class="thumb">
                <img src="<?php echo base_url('application/uploads/' . $article->image); ?>" alt="<?php echo htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8'); ?>">
                <span class="card-badge <?php echo $article->category_slug === 'cybersecurity' ? 'cyber' : ''; ?>"><?php echo htmlspecialchars($article->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
            </a>
            <div class="card-content">
                <h3><a href="<?php echo site_url('home/detail/' . $article->id); ?>"><?php echo htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8'); ?></a></h3>
                <p class="card-excerpt"><?php echo strip_tags(word_limiter($article->content, 25)); ?></p>
                <div class="card-meta">
                    <span class="meta-author"><?php echo htmlspecialchars($article->author, ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="meta-dot"></span>
                    <span class="meta-date"><?php echo date('d M Y', strtotime($article->publish_date)); ?></span>
                </div>
                <a class="read-more" href="<?php echo site_url('home/detail/' . $article->id); ?>">Baca</a>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php echo $pagination; ?>

    <?php elseif ($keyword): ?>
    <div class="search-empty" style="margin-top: 30px;">
        <div class="empty-code">404</div>
        <p>Tidak ada hasil untuk <span class="search-term">"<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"</span></p>
        <p style="margin-top: 8px; font-size: 13px;">Coba kata kunci lain, misalnya: ransomware, AI, gadget, cloud.</p>
    </div>
    <?php else: ?>
    <div class="search-empty" style="margin-top: 30px;">
        <div class="empty-code">>_</div>
        <p>Gunakan kotak pencarian di header untuk mencari artikel.</p>
    </div>
    <?php endif; ?>
</div>
