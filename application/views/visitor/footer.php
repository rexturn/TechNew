<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="<?php echo site_url(); ?>" class="brand">
                        <span class="brand-logo"><span>>_</span></span>
                        <span class="brand-name">
                            <span class="neon-red">TECH</span><span class="neon-cyan">NEWS</span>
                            <span class="brand-sub">// Cyber Security News</span>
                        </span>
                    </a>
                    <p class="footer-about">
                        Portal berita teknologi & cybersecurity. Menghadirkan informasi terkini tentang
                        keamanan siber, AI, gadget, cloud computing, dan perkembangan digital lainnya.
                        <em>Stay paranoid. Stay protected.</em>
                    </p>
                </div>
                <div class="footer-col">
                    <h4>Kategori</h4>
                    <ul>
                        <?php foreach (array_slice($categories, 0, 6) as $cat): ?>
                        <li><a href="<?php echo site_url('home/category/' . $cat->slug); ?>"><?php echo htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8'); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Akses</h4>
                    <ul>
                        <li><a href="<?php echo site_url(); ?>">Beranda</a></li>
                        <li><a href="<?php echo site_url('home/search'); ?>">Pencarian</a></li>
                        <li><a href="<?php echo site_url('auth'); ?>">Login Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; <?php echo date('Y'); ?> TechNews Cyber Portal. All rights reserved.</span>
                <span class="sys-status">&#9679; SYSTEM ONLINE — SECURE CHANNEL</span>
            </div>
        </div>
    </footer>
</body>
</html>
