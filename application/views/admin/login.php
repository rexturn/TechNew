<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | TechNews</title>
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.svg'); ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>">
</head>
<body class="login-body">
    <div class="login-card">
        <div class="login-head">
            <div class="login-logo">>_</div>
            <h1>TECH<span style="color: var(--cyan);">NEWS</span></h1>
            <p class="login-sub">// Admin Access Console</p>
        </div>

        <?php if ($this->session->flashdata('login_error')): ?>
        <div class="alert alert-error">&#9888; <?php echo htmlspecialchars($this->session->flashdata('login_error'), ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('logout_msg')): ?>
        <div class="alert alert-success">&#10003; <?php echo htmlspecialchars($this->session->flashdata('logout_msg'), ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <?php echo form_open('auth/login'); ?>
            <div class="form-group">
                <label for="username">Username <span class="req">*</span></label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" value="<?php echo set_value('username'); ?>" autocomplete="username">
                <?php echo form_error('username', '<span class="form-error">', '</span>'); ?>
            </div>
            <div class="form-group">
                <label for="password">Password <span class="req">*</span></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" autocomplete="current-password">
                <?php echo form_error('password', '<span class="form-error">', '</span>'); ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">MASUK</button>
        <?php echo form_close(); ?>

        <div class="login-foot">
            <a href="<?php echo site_url(); ?>">&#8592; Kembali ke Beranda</a><br>
        </div>
    </div>
</body>
</html>
