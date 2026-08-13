<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="detail-wrap">
        <!-- MAIN ARTICLE -->
        <article class="detail-main">
            <a href="<?php echo site_url(); ?>" class="back-link">&#8592; Kembali ke Beranda</a>
            <div class="detail-head">
                <span class="card-badge <?php echo $article->category_slug === 'cybersecurity' ? 'cyber' : ''; ?>"><?php echo htmlspecialchars($article->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                <h1 class="glitch" data-text="<?php echo htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8'); ?></h1>
                <div class="card-meta">
                    <span class="meta-author">&#9658; <?php echo htmlspecialchars($article->author, ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="meta-dot"></span>
                    <span class="meta-date"><?php echo date('d M Y H:i', strtotime($article->publish_date)); ?> WIB</span>
                </div>
            </div>

            <div class="detail-feature-img">
                <img src="<?php echo base_url('application/uploads/' . $article->image); ?>" alt="<?php echo htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="article-content">
                <?php echo $article->content; ?>
            </div>
        </article>

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="widget">
                <h3 class="widget-title">// Kategori</h3>
                <ul class="category-list">
                    <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="<?php echo site_url('home/category/' . $cat->slug); ?>">
                            <span><?php echo htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="cat-count"><?php echo isset($cat->article_count) ? $cat->article_count : ''; ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="widget">
                <h3 class="widget-title">// Terkait</h3>
                <?php foreach ($related as $rel): ?>
                <div class="related-item">
                    <a href="<?php echo site_url('home/detail/' . $rel->id); ?>" class="ri-thumb">
                        <img src="<?php echo base_url('application/uploads/' . $rel->image); ?>" alt="">
                    </a>
                    <a href="<?php echo site_url('home/detail/' . $rel->id); ?>" class="ri-title"><?php echo htmlspecialchars($rel->title, ENT_QUOTES, 'UTF-8'); ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>
</div>
