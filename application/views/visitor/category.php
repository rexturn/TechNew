<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="section-head" style="margin-top: 40px;">
        <span class="sec-index">// CAT</span>
        <h2 class="glitch" data-text="<?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></h2>
        <span class="line"></span>
    </div>

    <?php if ($articles): ?>
    <div class="news-grid">
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
    <?php else: ?>
    <div class="search-empty">
        <div class="empty-code">404</div>
        <p>Belum ada artikel pada kategori ini.</p>
    </div>
    <?php endif; ?>
</div>
