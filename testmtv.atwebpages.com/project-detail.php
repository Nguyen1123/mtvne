<?php
// project-detail.php - Trang chi tiết dự án
session_start();
require_once 'config/db.php';

// 1. Lấy ID từ URL
$id = $_GET['id'] ?? null;
$projects = get_table_data('projects');
$current_project = null;

// 2. Tìm dự án theo ID
if ($id) {
    foreach($projects as $pj) {
        if($pj['id'] == $id) {
            $current_project = $pj;
            break;
        }
    }
}

// 3. Nếu không thấy dự án, quay lại trang danh sách
if(!$current_project) {
    header("Location: /du-an.php");
    exit;
}

$page_title = $current_project['name'];
include 'includes/header.php';
?>

<style>
    /* CSS FIX LỖI TRÀN ẢNH TRÊN ĐIỆN THOẠI */
    .project-main-content {
        line-height: 1.8; 
        color: #334155; 
        font-size: 1.15rem; 
        text-align: justify;
        overflow-wrap: break-word; /* Tự động xuống dòng nếu từ quá dài */
    }

    .project-main-content img {
        max-width: 100% !important; /* Ép ảnh luôn nằm trong khung hình điện thoại */
        height: auto !important;    /* Giữ tỉ lệ ảnh không bị méo */
        border-radius: 8px;
        margin: 25px auto;
        display: block;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .project-main-content h2, .project-main-content h3 {
        color: #1e293b;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    /* Đảm bảo bảng biểu hoặc video (nếu có) cũng không tràn màn hình */
    .project-main-content table, 
    .project-main-content iframe {
        max-width: 100% !important;
        width: 100% !important;
        height: auto !important;
    }
</style>

<section style="padding: 4rem 0; background: #fff;">
    <div class="container" style="max-width: 900px;">
        <div style="margin-bottom: 2rem;">
            <a href="/du-an.php" style="color: #10b981; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách dự án
            </a>
        </div>

        <article>
            <div style="color: #94a3b8; font-size: 0.95rem; margin-bottom: 1rem; display: flex; gap: 20px; flex-wrap: wrap;">
                <span><i class="fas fa-map-marker-alt"></i> Địa điểm: <?php echo htmlspecialchars($current_project['location']); ?></span>
                <span><i class="fas fa-calendar-alt"></i> Ngày đăng: <?php echo date('d/m/Y', strtotime($current_project['created_at'])); ?></span>
            </div>

            <h1 style="font-size: 2.5rem; color: #1e293b; line-height: 1.2; margin-bottom: 2rem; font-weight: 800;">
                <?php echo htmlspecialchars($current_project['name']); ?>
            </h1>

            <?php if(!empty($current_project['image']) && file_exists('uploads/' . $current_project['image'])): ?>
                <div style="margin-bottom: 3rem; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <img src="/uploads/<?php echo htmlspecialchars($current_project['image']); ?>" 
                         alt="<?php echo htmlspecialchars($current_project['name']); ?>" 
                         style="width: 100%; height: auto; display: block;">
                </div>
            <?php endif; ?>

            <div class="project-main-content">
                <?php 
                    // In trực tiếp nội dung từ CKEditor
                    echo $current_project['content']; 
                ?>
            </div>
        </article>

        <div style="margin-top: 5rem; padding: 3rem 2rem; background: #f8fafc; border-radius: 20px; text-align: center; border: 1px solid #e2e8f0;">
            <h3 style="font-size: 1.5rem; color: #1e293b; margin-bottom: 10px; font-weight: 700;">Bạn muốn sở hữu hệ thống năng lượng tương tự?</h3>
            <p style="color: #64748b; margin-bottom: 2rem;">Chúng tôi luôn sẵn sàng khảo sát và tư vấn giải pháp tối ưu nhất cho bạn.</p>
            <a href="/lien-he" class="btn" style="background: #10b981; color: white; padding: 15px 40px; border-radius: 99px; text-decoration: none; font-weight: 700; transition: 0.3s; display: inline-block;">
                NHẬN TƯ VẤN MIỄN PHÍ
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>