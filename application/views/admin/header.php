<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?>TechNews Admin</title>
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.svg'); ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>">
</head>
<body>
    <div class="admin-wrap">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <span class="brand-logo">>_</span>
                <span class="brand-name">TECH<span class="neon-red">NEWS</span><br><span class="neon-cyan" style="font-size: 10px; letter-spacing: 2px;">ADMIN CONSOLE</span></span>
            </div>

            <ul class="sidebar-nav">
                <li>
                    <a href="<?php echo site_url('admin/dashboard'); ?>" class="<?php echo ($active_page === 'dashboard') ? 'active' : ''; ?>">
                        <span class="nav-icon">[01]</span> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('admin/articles'); ?>" class="<?php echo ($active_page === 'articles') ? 'active' : ''; ?>">
                        <span class="nav-icon">[02]</span> Manage Artikel
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('admin/create'); ?>" class="<?php echo ($active_page === 'articles' && isset($is_form)) ? 'active' : ''; ?>">
                        <span class="nav-icon">[03]</span> Tambah Artikel
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url(); ?>" target="_blank">
                        <span class="nav-icon">[04]</span> Lihat Website
                    </a>
                </li>
            </ul>

            <div class="sidebar-user">
                <div class="su-name">&#9658; <?php echo htmlspecialchars($this->session->userdata('admin_name'), ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="su-role">&#9679; ADMIN ONLINE</div>
                <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-danger btn-sm btn-block">LOGOUT</a>
            </div>
        </aside>

        <!-- Main area -->
        <div class="admin-main">
            <div class="admin-topbar">
                <h1><?php echo isset($page_title) ? htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') : ''; ?></h1>
                <div class="topbar-right">
                    <span class="topbar-user">
                        <span class="tu-name"><?php echo htmlspecialchars($this->session->userdata('admin_username'), ENT_QUOTES, 'UTF-8'); ?></span>
                        &middot; <?php echo date('d M Y H:i'); ?>
                    </span>
                    <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-danger btn-sm">LOGOUT</a>
                </div>
            </div>

            <div class="admin-content">
