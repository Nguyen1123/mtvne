<?php
// index.php
session_start();
require_once 'config/db.php';

$page_title = 'Trang chủ';
include 'includes/header.php';

// --- LOGIC LẤY SẢN PHẨM NỔI BẬT ---
$all_products = get_table_data('products');
$featured_products_list = array_filter($all_products, function($p) {
    return isset($p['is_featured']) && $p['is_featured'] === true;
});
$products = array_slice($featured_products_list, 0, 3);

// --- LOGIC LẤY DỰ ÁN TIÊU BIỂU ---
$all_projects = get_table_data('projects');
$featured_projects_list = array_filter($all_projects, function($pj) {
    return isset($pj['is_featured']) && $pj['is_featured'] === true;
});
$projects = array_slice($featured_projects_list, 0, 3); 
?>

<style>
    :root {
        --primary-color: #10b981;
        --secondary-color: #059669;
    }

    /* BANNER - CẬP NHẬT ĐỂ CHỮ LUÔN TRẮNG */
    .hero-banner {
        padding: 7rem 0 9rem;
        background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                    url('https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=1920') center/cover;
        color: #ffffff !important; /* Buộc tất cả nội dung trong banner phải màu trắng */
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
    }

    .hero-banner h1 {
        color: #ffffff !important;
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1.2;
        /* Thêm bóng đổ để chữ cực kỳ rõ nét trên điện thoại */
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .hero-banner p {
        color: rgba(255, 255, 255, 0.9) !important;
        text-shadow: 0 1px 5px rgba(0,0,0,0.2);
    }

    /* Resposive cho điện thoại */
    @media (max-width: 768px) {
        .hero-banner {
            padding: 5rem 0 7rem;
        }
        .hero-banner h1 {
            font-size: 1.8rem; /* Thu nhỏ chữ một chút trên mobile cho đẹp */
        }
    }

    /* THẺ CARD */
    .card-item {
        background: white; 
        border-radius: 12px; 
        padding: 1.5rem; 
        text-align: center; 
        display: flex; 
        flex-direction: column; 
        justify-content: space-between;
        border: 1px solid #e2e8f0; 
        transition: 0.3s ease;
        height: 100%;
    }
    .card-item:hover { 
        border-color: var(--primary-color); 
        box-shadow: 0 10px 20px rgba(0,0,0,0.05); 
        transform: translateY(-5px); 
    }

    .image-wrapper {
        display: flex; 
        align-items: center; 
        justify-content: center; 
        height: 200px; 
        margin-bottom: 1rem; 
        background: #ffffff; 
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
    }
    .image-wrapper img {
        max-width: 100%; 
        max-height: 100%; 
        object-fit: contain; 
        transition: 0.5s;
    }
    
    .view-detail-btn {
        display: block; 
        text-align: center; 
        background: #f8fafc; 
        border: 1px solid #cbd5e1; 
        color: #1e293b; 
        padding: 10px; 
        border-radius: 8px; 
        font-weight: 600; 
        text-decoration: none; 
        transition: all 0.3s ease; 
        margin-top: auto;
    }
    .view-detail-btn:hover {
        background: var(--primary-color); 
        color: white; 
        border-color: var(--primary-color);
    }

    .view-more-outline {
        display: inline-block; 
        padding: 12px 30px; 
        border: 2px solid var(--primary-color); 
        color: var(--primary-color);
        border-radius: 8px; 
        font-weight: 600; 
        text-decoration: none; 
        transition: 0.3s;
    }
    .view-more-outline:hover { 
        background: var(--primary-color); 
        color: white; 
    }
</style>

<section class="hero-banner">
    <div class="container">
        <h1>NĂNG LƯỢNG XANH<br>KIẾN TẠO TƯƠNG LAI BỀN VỮNG</h1>
        <p style="margin: 1.5rem auto 2.5rem; opacity: 0.9; max-width: 600px; font-size: 1.1rem;">Chuyên cung cấp, thiết kế và thi công hệ thống điện mặt trời trọn gói</p>
        <a href="/lien-he" class="btn" style="background: var(--primary-color); color:white; padding: 14px 35px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block;">NHẬN BÁO GIÁ NGAY</a>
    </div>
</section>

<div class="container" style="margin-top: -4.5rem; position: relative; z-index: 5;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-bottom: 4px solid var(--primary-color);">
        <div style="text-align: center; border-right: 1px solid #e2e8f0;"><h3>100+</h3><p style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Dự án hoàn thành</p></div>
        <div style="text-align: center; border-right: 1px solid #e2e8f0;"><h3>15 MWp</h3><p style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Tổng công suất</p></div>
        <div style="text-align: center; border-right: 1px solid #e2e8f0;"><h3>99%</h3><p style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Khách hàng hài lòng</p></div>
        <div style="text-align: center;"><h3>24/7</h3><p style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Hỗ trợ kỹ thuật</p></div>
    </div>
</div>

<section class="section" style="background: #f8fafc; padding: 6rem 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.2rem; color: #1e293b; font-weight: 800;">SẢN PHẨM NỔI BẬT</h2>
            <div style="width: 60px; height: 4px; background: var(--primary-color); margin: 15px auto; border-radius: 2px;"></div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            <?php if(!empty($products)): foreach($products as $row): ?>
            <div class="card-item">
                <div>
                    <a href="/product-detail.php?id=<?php echo htmlspecialchars($row['id'] ?? ''); ?>" class="image-wrapper">
                        <?php if(!empty($row['image']) && file_exists("uploads/" . $row['image'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Sản phẩm">
                        <?php else: ?>
                            <i class="fas fa-solar-panel" style="font-size: 4rem; color: #cbd5e1;"></i>
                        <?php endif; ?>
                    </a>
                    <h4 style="margin: 0 0 0.8rem; font-size: 1.15rem; color: #1e293b; height: 45px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.3;"><?php echo htmlspecialchars($row['name']); ?></h4>
                    <p style="color: var(--primary-color); font-weight: 800; font-size: 1.3rem; margin-bottom: 1.2rem;"><?php echo htmlspecialchars($row['price'] ?? 'Liên hệ'); ?></p>
                </div>
                <a href="/product-detail.php?id=<?php echo htmlspecialchars($row['id'] ?? ''); ?>" class="view-detail-btn">Xem chi tiết</a>
            </div>
            <?php endforeach; endif; ?>
        </div>

        <div style="text-align: center; margin-top: 4rem;">
            <a href="/san-pham" class="view-more-outline">Xem Tất Cả Sản Phẩm</a>
        </div>
    </div>
</section>

<section class="section" style="background: #f8fafc; padding: 2rem 0 7rem;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.2rem; color: #1e293b; font-weight: 800;">DỰ ÁN TIÊU BIỂU</h2>
            <div style="width: 60px; height: 4px; background: var(--primary-color); margin: 15px auto; border-radius: 2px;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            <?php if(!empty($projects)): foreach($projects as $row): ?>
            <div class="card-item">
                <div>
                    <a href="/project-detail.php?id=<?php echo htmlspecialchars($row['id'] ?? ''); ?>" class="image-wrapper">
                        <?php if(!empty($row['image']) && file_exists("uploads/" . $row['image'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Dự án">
                        <?php else: ?>
                            <i class="fas fa-bolt" style="font-size: 4rem; color: #cbd5e1;"></i>
                        <?php endif; ?>
                    </a>
                    <h4 style="margin: 0 0 0.8rem; font-size: 1.15rem; color: #1e293b; height: 45px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        <?php echo htmlspecialchars($row['name']); ?>
                    </h4>
                    <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 1.2rem;">
                        <i class="fas fa-map-marker-alt" style="color: #ef4444; margin-right: 5px;"></i> <?php echo htmlspecialchars($row['location']); ?>
                    </p>
                </div>
                <a href="/project-detail.php?id=<?php echo htmlspecialchars($row['id'] ?? ''); ?>" class="view-detail-btn">Xem chi tiết dự án</a>
            </div>
            <?php endforeach; endif; ?>
        </div>

        <div style="text-align: center; margin-top: 4rem;">
            <a href="/du-an" class="view-more-outline">Xem Tất Cả Dự Án</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>