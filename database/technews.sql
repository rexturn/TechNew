-- =============================================
-- TechNews - Portal Berita Teknologi & Cybersecurity
-- Database Schema + Seed Data
-- =============================================

CREATE DATABASE IF NOT EXISTS technews CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE technews;

-- ------------------------------------------------------------
-- Table: users (Admin accounts)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password default: admin123 (hash bcrypt)
INSERT INTO users (username, password, full_name, email) VALUES
('admin', '$2y$10$GT9/tMGIeabEpuB1rw74OeASg3tIsm6HD6gvsqBfb6Cu1RwcaOgU.', 'Administrator', 'admin@technews.id')
ON DUPLICATE KEY UPDATE username = VALUES(username);

-- ------------------------------------------------------------
-- Table: categories
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  slug VARCHAR(60) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories (name, slug) VALUES
('Artificial Intelligence', 'artificial-intelligence'),
('Cybersecurity', 'cybersecurity'),
('Gadget', 'gadget'),
('Software', 'software'),
('Cloud Computing', 'cloud-computing'),
('Blockchain', 'blockchain'),
('Internet of Things', 'internet-of-things'),
('Game', 'game')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- ------------------------------------------------------------
-- Table: articles
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS articles (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(200) NOT NULL,
  category_id INT(11) UNSIGNED NOT NULL,
  author VARCHAR(100) NOT NULL,
  content LONGTEXT NOT NULL,
  image VARCHAR(255) NOT NULL,
  publish_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_category (category_id),
  KEY idx_publish_date (publish_date),
  CONSTRAINT fk_articles_category FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed articles (cybersecurity & tech content)
INSERT INTO articles (title, category_id, author, content, image, publish_date) VALUES
(
  'Ransomware Baru Menyerang Infrastruktur Kritis: Apa yang Perlu Diketahui',
  (SELECT id FROM categories WHERE slug = 'cybersecurity'),
  'Rizky Pratama',
  '<h2>Ancaman Ransomware Semakin Canggih</h2><p>Kelompok peretas yang dikenal sebagai <strong>Dark Forge</strong> telah meluncurkan kampanye ransomware baru yang menargetkan infrastruktur kritis di Asia Tenggara. Serangan ini menggunakan teknik <em>double extortion</em> - mengenkripsi data sekaligus mengancam membocorkannya ke publik.</p><h3>Modus Operandi</h3><ul><li>Phishing email dengan lampiran dokumen berbahaya</li><li>Eksploitasi kerentanan RDP yang belum di-patch</li><li>Lateral movement menggunakan credential harvesting</li></ul><p>Menurut laporan <a href="#" target="_blank">Cybersecurity Intelligence</a>, serangan meningkat 47% dibanding kuartal sebelumnya.</p><h3>Langkah Mitigasi</h3><p>Organisasi disarankan untuk menerapkan <strong>zero trust architecture</strong>, melakukan backup 3-2-1, dan memperbarui sistem secara berkala. <em>Incident response plan</em> yang teruji sangat krusial untuk meminimalkan dampak.</p>',
  'placeholder-ransomware.jpg',
  '2026-08-05 09:30:00'
),
(
  'Perkembangan AI Generatif dan Dampaknya pada Industri Keamanan Siber',
  (SELECT id FROM categories WHERE slug = 'artificial-intelligence'),
  'Sarah Wijaya',
  '<h2>AI Generatif: Pedang Bermata Dua</h2><p>Kecerdasan buatan generatif telah merevolusi banyak industri, termasuk keamanan siber. Di satu sisi, AI membantu mendeteksi anomali lebih cepat; di sisi lain, AI juga digunakan oleh penyerang untuk membuat malware yang lebih sulit dideteksi.</p><h3>Sisi Positif</h3><ul><li>Deteksi ancaman real-time dengan machine learning</li><li>Automasi analisis log dan event</li><li>Generasi playbook respons insiden otomatis</li></ul><h3>Sisi Negatif</h3><ul><li>Phishing email yang sangat realistis</li><li>Deepfake untuk social engineering</li><li>Malware polymorphic berbasis AI</li></ul><p>Industri perlu beradaptasi dengan menggabungkan <strong>human expertise</strong> dengan <strong>AI-powered tools</strong> untuk pertahanan yang optimal.</p>',
  'placeholder-ai.jpg',
  '2026-08-04 14:00:00'
),
(
  'Review: Smartphone Flagship 2026 dengan Fitur Keamanan Biometrik Terbaru',
  (SELECT id FROM categories WHERE slug = 'gadget'),
  'Budi Santoso',
  '<h2>Keamanan Biometrik Generasi Baru</h2><p>Flagship terbaru dari berbagai vendor kini dilengkapi dengan <strong>in-display fingerprint sensor generasi ke-4</strong> dan <em>3D face recognition</em> yang lebih akurat. Namun, seberapa aman teknologi ini sebenarnya?</p><h3>Keunggulan</h3><ul><li>Sensor sidik jari ultrasonik 3D yang lebih presisi</li><li>Face unlock bekerja di kondisi minim cahaya</li><li>Secure element terpisah untuk data biometrik</li></ul><h3>Kekurangan</h3><ul><li>Harga lebih mahal</li><li>Konsumsi baterai sedikit lebih tinggi</li></ul><p>Untuk penggunaan sehari-hari, kombinasi biometrik + PIN tetap menjadi <strong>standar emas keamanan</strong>.</p>',
  'placeholder-gadget.jpg',
  '2026-08-03 10:15:00'
),
(
  'Mengenal Zero Trust Architecture: Prinsip dan Implementasi Praktis',
  (SELECT id FROM categories WHERE slug = 'cybersecurity'),
  'Rizky Pratama',
  '<h2>Apa itu Zero Trust?</h2><p><strong>Zero Trust Architecture (ZTA)</strong> adalah model keamanan yang mengasumsikan tidak ada entitas yang tepercaya secara otomatis - baik di dalam maupun luar jaringan. Setiap permintaan akses harus diverifikasi.</p><h3>Prinsip Dasar</h3><ul><li>Verifikasi eksplisit setiap permintaan</li><li>Akses dengan hak minimum (least privilege)</li><li>Asumsikan telah terjadi pelanggaran (assume breach)</li></ul><h3>Langkah Implementasi</h3><p>Mulai dengan memetakan aset dan data, terapkan <strong>identity and access management</strong>, aktifkan <em>multi-factor authentication</em>, lalu segmentasi jaringan secara mikro. Implementasi bertahap mengurangi gangguan operasional.</p>',
  'placeholder-zero-trust.jpg',
  '2026-08-02 16:45:00'
),
(
  'Cloud Native Security: Mengamankan Aplikasi di Era Kubernetes',
  (SELECT id FROM categories WHERE slug = 'cloud-computing'),
  'Andi Kurniawan',
  '<h2>Tantangan Keamanan di Lingkungan Cloud Native</h2><p>Migrasi ke arsitektur microservices dan kontainer membawa tantangan keamanan baru. <strong>Kubernetes</strong> sebagai orkestrator standar membutuhkan strategi keamanan berlapis.</p><h3>Strategi Pengamanan</h3><ul><li>Image scanning pada CI/CD pipeline</li><li>Network policy untuk isolasi pod</li><li>Secrets management dengan vault</li><li>Runtime security monitoring</li></ul><p>Automasi keamanan melalui <em>Infrastructure as Code</em> (IaC) adalah kunci untuk menjaga konsistensi kebijakan.</p>',
  'placeholder-cloud.jpg',
  '2026-08-01 11:20:00'
),
(
  'Blockchain dan Keamanan Data: Lebih dari Sekadar Cryptocurrency',
  (SELECT id FROM categories WHERE slug = 'blockchain'),
  'Sarah Wijaya',
  '<h2>Blockchain untuk Keamanan Data</h2><p>Teknologi blockchain menawarkan sifat <strong>immutable</strong> dan <em>desentralisasi</em> yang dapat dimanfaatkan untuk mengamankan integritas data di berbagai sektor.</p><h3>Kasus Penggunaan</h3><ul><li>Verifikasi keaslian dokumen dan sertifikat</li><li>Audit trail yang transparan</li><li>Identitas digital terdesentralisasi (DID)</li></ul><p>Meski menjanjikan, blockchain bukan solusi untuk segala masalah keamanan. Evaluasi kebutuhan secara matang sebelum adopsi.</p>',
  'placeholder-blockchain.jpg',
  '2026-07-30 08:00:00'
),
(
  'Tips Mengamankan Smart Home dari Serangan IoT',
  (SELECT id FROM categories WHERE slug = 'internet-of-things'),
  'Budi Santoso',
  '<h2>Rumah Cerdas, Jaringan Rentan</h2><p>Perangkat IoT di rumah seperti kamera CCTV, smart TV, dan asisten virtual sering menjadi <strong>entry point</strong> bagi peretas. Banyak perangkat dengan default password yang lemah.</p><h3>Langkah Pengamanan</h3><ul><li>Segera ganti password default</li><li>Aktifkan 2FA jika tersedia</li><li>Pisahkan jaringan IoT dengan VLAN</li><li>Update firmware secara rutin</li><li>Nonaktifkan fitur yang tidak digunakan</li></ul><p>Keamanan smart home dimulai dari kebiasaan sederhana yang konsisten.</p>',
  'placeholder-iot.jpg',
  '2026-07-28 19:30:00'
),
(
  'Framework Keamanan OWASP Top 10 2026: Perubahan dan Implikasinya',
  (SELECT id FROM categories WHERE slug = 'software'),
  'Andi Kurniawan',
  '<h2>OWASP Top 10 Terbaru</h2><p>OWASP telah merilis pembaruan daftar risiko keamanan aplikasi web paling kritis. Ada pergeseran signifikan dari fokus teknis ke <strong>design-level risks</strong>.</p><h3>Perubahan Utama</h3><ul><li>Voice control untuk keamanan AI (LLM)</li><li>Meningkatnya posisi insecure design</li><li>Integrasi supply chain security</li></ul><p>Developer perlu memasukkan keamanan sejak tahap desain melalui <em>secure SDLC</em> dan threat modeling.</p>',
  'placeholder-owasp.jpg',
  '2026-07-25 13:10:00'
),
(
  'Membangun Password Manager Sendiri: Proyek untuk Developer',
  (SELECT id FROM categories WHERE slug = 'software'),
  'Rizky Pratama',
  '<h2>Password Manager Kustom</h2><p>Membangun password manager adalah proyek menarik yang mengajarkan banyak hal tentang <strong>kriptografi terapan</strong>.</p><h3>Komponen Kunci</h3><ul><li>Enkripsi AES-256-GCM untuk vault</li><li>Derivasi kunci dengan Argon2</li><li>autentikasi berbasis TOTP</li></ul><p>Pastikan untuk melakukan <em>security review</em> menyeluruh sebelum menggunakan di produksi.</p>',
  'placeholder-password.jpg',
  '2026-07-22 09:00:00'
),
(
  'Masa Depan Edge Computing: Keamanan dan Performa di Tepi Jaringan',
  (SELECT id FROM categories WHERE slug = 'cloud-computing'),
  'Sarah Wijaya',
  '<h2>Edge Computing dan Keamanan</h2><p><strong>Edge computing</strong> membawa komputasi lebih dekat ke sumber data, mengurangi latensi namun menambah permukaan serangan baru.</p><h3>Pertimbangan Keamanan</h3><ul><li>Perangkat edge yang tersebar sulit dipantau</li><li>Koneksi jaringan yang beragam</li><li>Kebutuhan enkripsi data in-transit dan at-rest</li></ul><p>Model keamanan <em>distributed</em> dengan manajemen identitas terpusat adalah pendekatan yang dianjurkan.</p>',
  'placeholder-edge.jpg',
  '2026-07-20 15:40:00'
),
(
  'Analisis Malware: Memahami Anatomi Serangan Siber Modern',
  (SELECT id FROM categories WHERE slug = 'cybersecurity'),
  'Andi Kurniawan',
  '<h2>Menelisik Malware Modern</h2><p>Analisis malware adalah disiplin yang menggabungkan <strong>reversing engineering</strong> dan <em>behavioral analysis</em> untuk memahami cara kerja perangkat lunak berbahaya.</p><h3>Metodologi</h3><ol><li>Static analysis: memeriksa kode tanpa eksekusi</li><li>Dynamic analysis: menjalankan di sandbox</li><li>Memory forensics: analisis RAM saat runtime</li></ol><p>Pemahaman tentang malware membantu tim blue team menyusun <strong>deteksi dan respons</strong> yang lebih efektif.</p>',
  'placeholder-malware.jpg',
  '2026-07-18 10:25:00'
),
(
  'Kriptografi Post-Quantum: Persiapan Menghadapi Komputer Kuantum',
  (SELECT id FROM categories WHERE slug = 'cybersecurity'),
  'Sarah Wijaya',
  '<h2>Ancaman Komputer Kuantum</h2><p>Komputer kuantum di masa depan berpotensi memecahkan algoritma kriptografi klasik seperti <strong>RSA dan ECC</strong> dalam hitungan menit. Ini mendorong pengembangan <em>post-quantum cryptography</em> (PQC).</p><h3>Standar PQC</h3><ul><li>CRYSTALS-Kyber untuk key encapsulation</li><li>CRYSTALS-Dilithium untuk tanda tangan digital</li><li>SPHINCS+ sebagai cadangan</li></ul><p>Organisasi disarankan mulai menginventarisasi aset kriptografi dan merencanakan <strong>crypto agility</strong>.</p>',
  'placeholder-quantum.jpg',
  '2026-07-15 12:00:00'
);
