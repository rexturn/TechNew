<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?>TechNews — Cyber Portal</title>
    <meta name="description" content="Portal berita teknologi dan cybersecurity terkini. Ikuti perkembangan AI, keamanan siber, gadget, dan cloud computing.">
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.svg'); ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
    <!-- Top ticker -->
    <div class="ticker-bar">
        <div class="ticker-inner" id="ticker">
            <span><span class="tick-label">LIVE:</span> Ransomware baru menargetkan infrastruktur kritis — baca selengkapnya</span>
            <span><span class="tick-label">ALERT:</span> AI generatif mengubah lanskap keamanan siber 2026</span>
            <span><span class="tick-label">UPDATE:</span> Standar post-quantum cryptography mulai diadopsi</span>
            <span><span class="tick-label">TIPS:</span> Amankan smart home Anda dari serangan IoT</span>
            <span><span class="tick-label">RILIS:</span> OWASP Top 10 2026 kini fokus pada keamanan AI</span>
        </div>
    </div>

    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="header-main">
                <a href="<?php echo site_url(); ?>" class="brand">
                    <span class="brand-logo"><span>>_</span></span>
                    <span class="brand-name">
                        <span class="neon-red">TECH</span><span class="neon-cyan">NEWS</span>
                        <span class="brand-sub">// Cyber Security News</span>
                    </span>
                </a>

                <form class="search-box" action="<?php echo site_url('home/search'); ?>" method="get">
                    <input type="text" name="q" placeholder="Cari berita teknologi..." value="<?php echo isset($keyword) ? htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') : ''; ?>">
                    <button type="submit">SEARCH</button>
                </form>
            </div>

            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="<?php echo site_url(); ?>" class="<?php echo (isset($page_title) && $page_title === 'Beranda') ? 'active' : ''; ?>"><span class="nav-num">01</span>Beranda</a></li>
                    <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="<?php echo site_url('home/category/' . $cat->slug); ?>"
                           class="<?php echo isset($category) && isset($category->slug) && $category->slug === $cat->slug ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
