<?php
// projects.php - Danh sách dự án
session_start();
require_once 'config/db.php';

$page_title = 'Dự án đã thực hiện';
include 'includes/header.php';

// Lấy danh sách dự án
$projects = get_table_data('projects');

// Sắp xếp dự án mới nhất lên đầu
if (!empty($projects)) {
    usort($projects, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
}
?>

<style>
    .project-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        padding: 40px 0;
    }

    .project-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.3s ease;
    }

    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: #10b981;
    }

    /* KHUNG HÌNH HIỆN ĐẦY ĐỦ - ĐÃ ĐỔI SANG NỀN TRẮNG */
    .project-image-box {
        width: 100%;
        height: 230px;
        background: #ffffff; /* CHỈNH NỀN TRẮNG */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
        padding: 10px; /* Thêm khoảng đệm để ảnh không dính viền */
    }

    .project-image-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; 
        transition: transform 0.5s ease;
    }

    .project-card:hover .project-image-box img {
        transform: scale(1.05);
    }

    .project-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .project-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.5rem;
        text-decoration: none;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.8em;
    }

    .project-meta-info {
        font-size: 0.85rem;
        color: #10b981;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .project-meta-info span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .project-summary-text {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    .project-footer {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px dashed #e2e8f0;
    }

    .btn-view-project {
        color: #10b981;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view-project:hover {
        color: #059669;
    }
</style>

<section class="section" style="background: #f8fafc; padding: 5rem 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-size: 2.2rem; color: #1e293b; font-weight: 800;">DỰ ÁN ĐÃ THỰC HIỆN</h2>
            <div style="width: 80px; height: 4px; background: #10b981; margin: 15px auto; border-radius: 2px;"></div>
            <p style="color: #64748b;">Khám phá các công trình năng lượng sạch tiêu biểu bởi ENERGY Mặt Trời Việt</p>
        </div>
        
        <?php if(!empty($projects)): ?>
            <div class="project-grid">
                <?php foreach($projects as $project): ?>
                    <article class="project-card">
                        <div class="project-image-box">
                            <a href="/project-detail.php?id=<?php echo $project['id']; ?>" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                <?php if(!empty($project['image']) && file_exists('uploads/' . $project['image'])): ?>
                                    <img src="/uploads/<?php echo htmlspecialchars($project['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($project['name']); ?>" 
                                         loading="lazy">
                                <?php else: ?>
                                    <i class="fas fa-solar-panel fa-3x" style="color: #cbd5e1;"></i>
                                <?php endif; ?>
                            </a>
                        </div>

                        <div class="project-body">
                            <a href="/project-detail.php?id=<?php echo $project['id']; ?>" class="project-title">
                                <?php echo htmlspecialchars($project['name']); ?>
                            </a>

                            <div class="project-meta-info">
                                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?></span>
                                <span><i class="fas fa-bolt"></i> <?php echo htmlspecialchars($project['capacity'] ?? 'Liên hệ'); ?></span>
                            </div>

                            <div class="project-summary-text">
                                <?php 
                                    $summary = !empty($project['summary']) ? $project['summary'] : (!empty($project['description']) ? $project['description'] : '');
                                    echo htmlspecialchars(strip_tags($summary)); 
                                ?>
                            </div>

                            <div class="project-footer">
                                <a href="/project-detail.php?id=<?php echo $project['id']; ?>" class="btn-view-project">
                                    Xem chi tiết dự án <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="background: white; padding: 4rem; border-radius: 16px; text-align: center; border: 1px solid #e2e8f0;">
                <i class="fas fa-folder-open" style="font-size: 4rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p style="color: #94a3b8; font-size: 1.1rem;">Hiện tại chưa có dự án nào được đăng tải.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>