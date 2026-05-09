<?php
// includes/header.php
$current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_admin = (strpos($current_page, '/admin/') !== false);

// ĐÃ CẬP NHẬT HÀM CHECK_ACTIVE Ở ĐÂY
function check_active($path, $current_page) {
    // Loại bỏ dấu gạch chéo cuối và đuôi .php của trang hiện tại để so sánh chính xác
    $current = rtrim(str_replace('.php', '', $current_page), '/');
    $target = rtrim($path, '/');
    
    if ($target === '') {
        return ($current === '' || $current === '/index') ? 'active' : '';
    }
    
    return ($current === $target) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ENERGY Mặt Trời Việt' : 'ENERGY Mặt Trời Việt'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .nav-menu a.active { color: #10b981 !important; font-weight: 700; position: relative; }
        .nav-menu a.active::after {
            content: ''; position: absolute; bottom: -5px; left: 0; width: 100%; height: 3px;
            background-color: #10b981; border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php if (!$is_admin): ?>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; position: relative;">
            <div class="navbar-brand">
                <a href="/" class="logo">
                    <img src="/assets/images/logo.png" alt="Logo" class="logo-img">
                    <span class="logo-text">ENERGY Mặt Trời Việt</span>
                </a>
            </div>
            
            <button id="menuToggle" class="menu-toggle" aria-label="Mở menu">
                <i class="fas fa-bars"></i>
            </button>

				<ul id="navMenu" class="nav-menu">
                    <li><a href="/" class="<?php echo check_active('/', $current_page); ?>">Trang chủ</a></li>
                    <li><a href="/san-pham" class="<?php echo check_active('/san-pham', $current_page); ?>">Sản phẩm</a></li>
                    <li><a href="/giai-phap" class="<?php echo check_active('/giai-phap', $current_page); ?>">Giải pháp</a></li>
                    <li><a href="/du-an" class="<?php echo check_active('/du-an', $current_page); ?>">Dự án</a></li>
                    <li><a href="/tin-tuc" class="<?php echo check_active('/tin-tuc', $current_page); ?>">Tin tức</a></li>
                    <li><a href="/lien-he" class="<?php echo check_active('/lien-he', $current_page); ?>">Liên hệ</a></li>
                </ul>
        </div>
    </nav>
    <?php endif; ?>
    <div class="page-content">