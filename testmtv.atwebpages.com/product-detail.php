<?php
// product-detail.php
session_start();
require_once 'config/db.php';

// Nhận ID sản phẩm khi người dùng bấm vào nút Xem chi tiết
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$product_id) {
    header("Location: /san-pham.php");
    exit;
}

// Lấy thông tin sản phẩm từ CSDL
$products = get_table_data('products');
$current_product = null;

foreach ($products as $p) {
    if ($p['id'] == $product_id) {
        $current_product = $p;
        break;
    }
}

if (!$current_product) {
    header("Location: /products.php");
    exit;
}

$page_title = $current_product['name'];
include 'includes/header.php';
?>

<style>
    /* Nút quay lại kiểu hiện đại */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
        transition: 0.3s;
        font-size: 0.95rem;
    }
    .btn-back:hover {
        color: #10b981;
        transform: translateX(-5px);
    }

    /* Khung hình nền trắng */
    .product-image-container {
        flex: 1; 
        min-width: 300px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        background: #ffffff; 
        border-radius: 12px; 
        padding: 1.5rem;
        border: 1px solid #f1f5f9;
    }

    .product-image-container img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 8px;
        object-fit: contain;
    }

    .product-description {
        color: #475569; 
        line-height: 1.8; 
        font-size: 1.05rem;
        text-align: justify;
        overflow-wrap: break-word;
    }

    @media (max-width: 768px) {
        .product-detail-flex {
            gap: 1.5rem !important;
            padding: 1.5rem !important;
        }
        .product-image-container {
            min-width: 100%;
        }
    }
</style>

<section style="padding: 4rem 0; background-color: #f8fafc;">
    <div class="container">
        
        <a href="/san-pham.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách sản phẩm
        </a>

        <div class="product-detail-flex" style="display: flex; flex-wrap: wrap; gap: 3rem; background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            
            <div class="product-image-container">
                <?php if(!empty($current_product['image']) && file_exists('uploads/' . $current_product['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($current_product['image']); ?>" alt="Ảnh sản phẩm">
                <?php else: ?>
                    <i class="fas fa-solar-panel" style="font-size: 8rem; color: #cbd5e1;"></i>
                <?php endif; ?>
            </div>

            <div style="flex: 1.5; min-width: 300px;">
                <h1 style="font-size: 2rem; color: #1e293b; font-weight: 800; margin-bottom: 1rem; line-height: 1.3;">
                    <?php echo htmlspecialchars($current_product['name']); ?>
                </h1>
                
                <div style="font-size: 1.8rem; color: #10b981; font-weight: 800; margin-bottom: 1.5rem;">
                    <?php echo htmlspecialchars($current_product['price'] ?? 'Liên hệ để nhận báo giá'); ?>
                </div>
                
                <div style="background: #f8fafc; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #10b981;">
                    <strong><i class="fas fa-bolt" style="color: #eab308; margin-right: 8px;"></i> Công suất:</strong> 
                    <?php echo htmlspecialchars($current_product['power'] ?? 'Đang cập nhật'); ?>
                </div>

                <h3 style="font-size: 1.2rem; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem; font-weight: 700;">Mô tả chi tiết</h3>
                
                <div class="product-description">
                    <?php 
                        echo nl2br(htmlspecialchars($current_product['description'])); 
                    ?>
                </div>

                <a href="/lien-he" style="display: inline-block; background: #10b981; color: white; padding: 14px 35px; border-radius: 8px; font-weight: 700; text-decoration: none; margin-top: 2rem; transition: 0.3s; text-align: center;">
                    <i class="fas fa-phone-alt" style="margin-right: 8px;"></i> LIÊN HỆ ĐẶT HÀNG
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>