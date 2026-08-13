<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <?php if ($hero && count($hero) > 0): $main = $hero[0]; ?>
            <a href="<?php echo site_url('home/detail/' . $main->id); ?>" class="hero-card hero-main-card hero-card-stagger">
                <div class="card-img-wrap">
                    <img src="<?php echo base_url('application/uploads/' . $main->image); ?>" alt="<?php echo htmlspecialchars($main->title, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="card-body">
                    <span class="card-badge <?php echo $main->category_slug === 'cybersecurity' ? 'cyber' : ''; ?>"><?php echo htmlspecialchars($main->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                    <h2 class="glitch" data-text="<?php echo htmlspecialchars($main->title, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($main->title, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="card-meta">
                        <span class="meta-author">&#9658; <?php echo htmlspecialchars($main->author, ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="meta-dot"></span>
                        <span class="meta-date"><?php echo date('d M Y H:i', strtotime($main->publish_date)); ?> WIB</span>
                    </div>
                </div>
            </a>
            <?php endif; ?>

            <div class="hero-side">
                <?php foreach ($featured as $index => $item): ?>
                <?php if ($item->id === $main->id) continue; ?>
                <a href="<?php echo site_url('home/detail/' . $item->id); ?>" class="side-card hero-card-stagger">
                    <span class="card-badge"><?php echo htmlspecialchars($item->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                    <h3 class="side-title"><?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <div class="card-meta">
                        <span class="meta-author"><?php echo htmlspecialchars($item->author, ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="meta-dot"></span>
                        <span class="meta-date"><?php echo date('d M Y', strtotime($item->publish_date)); ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ARTIKEL TERBARU -->
<div class="container">
    <div class="section-head">
        <span class="sec-index">// 02</span>
        <h2>Berita Terbaru</h2>
        <span class="line"></span>
    </div>

    <?php if ($articles): ?>
    <div class="news-grid">
        <?php foreach ($articles as $article): ?>
        <article class="news-card grid-item">
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
        <div class="empty-code">403</div>
        <p>Tidak ada artikel yang ditemukan.</p>
    </div>
    <?php endif; ?>
</div>
