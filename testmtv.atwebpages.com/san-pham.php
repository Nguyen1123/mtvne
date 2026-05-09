<?php
// products.php
session_start();
require_once 'config/db.php';

$page_title = 'Sản phẩm';
include 'includes/header.php';

// Lấy danh sách sản phẩm
$products = get_table_data('products');
?>

<style>
    /* CSS cho khung hình nền trắng */
    .card-image-wrapper {
        background-color: #ffffff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 220px;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
        padding: 15px;
        position: relative;
    }

    .card-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    /* CSS cho thẻ Card màu trắng */
    .card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        border-color: #10b981;
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        transform: translateY(-5px);
    }

    .card:hover .card-image {
        transform: scale(1.08);
    }

    /* Badge công suất */
    .card-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(16, 185, 129, 0.9);
        color: white;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        z-index: 2;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }
</style>

<section class="section" style="background: #f8fafc; padding: 5rem 0; min-height: 80vh;">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem;">Danh sách sản phẩm</h2>
            <div style="width: 60px; height: 4px; background: #10b981; margin: 0 auto 20px;"></div>
            <p style="color: #64748b; font-size: 1.1rem;">Khám phá bộ sưu tập sản phẩm năng lượng mặt trời chất lượng cao của chúng tôi.</p>
        </div>
        
        <?php if(!empty($products)): ?>
            <div class="grid">
                <?php foreach($products as $product): ?>
                    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div class="card-image-wrapper">
                                <?php if(!empty($product['image']) && file_exists('uploads/' . $product['image'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                         class="card-image" loading="lazy">
                                <?php else: ?>
                                    <div class="card-image-placeholder">
                                        <i class="fas fa-solar-panel" style="font-size: 3rem; color: #cbd5e1;"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if(!empty($product['power'])): ?>
                                    <div class="card-badge"><?php echo htmlspecialchars($product['power']); ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-content" style="padding: 25px;">
                                <h3 style="margin-bottom: 12px; font-size: 1.15rem; line-height: 1.4; height: 45px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: #1e293b; font-weight: 700;">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </h3>
                                
                                <div style="margin-bottom: 5px;">
                                    <span class="price" style="color: #10b981; font-weight: 800; font-size: 1.3rem;">
                                        <?php echo htmlspecialchars($product['price'] ?? 'Liên hệ'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div style="padding: 0 25px 25px;">
                            <a href="/product-detail.php?id=<?php echo htmlspecialchars($product['id'] ?? ''); ?>" 
                               style="display: block; text-align: center; background: #ffffff; border: 1px solid #cbd5e1; color: #1e293b; padding: 12px; border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s ease;"
                               onmouseover="this.style.background='#10b981'; this.style.color='white'; this.style.borderColor='#10b981';"
                               onmouseout="this.style.background='#ffffff'; this.style.color='#1e293b'; this.style.borderColor='#cbd5e1';">
                                Xem chi tiết sản phẩm
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state text-center" style="padding: 5rem 2rem; background: white; border-radius: 20px; border: 1px dashed #cbd5e1;">
                <i class="fas fa-box-open" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1.5rem;"></i>
                <p style="color: #94a3b8; font-size: 1.2rem;">Hiện tại chưa có sản phẩm nào.</p>
                <a href="/" style="color: #10b981; text-decoration: none; font-weight: 600; margin-top: 1rem; display: inline-block;">Quay về trang chủ</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>