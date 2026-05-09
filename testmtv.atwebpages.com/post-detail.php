<?php
// post-detail.php
session_start();
require_once 'config/db.php';

// Lấy ID từ đường dẫn URL
$id = $_GET['id'] ?? null;
$posts = get_table_data('posts');
$current_post = null;

// Tìm bài viết tương ứng với ID
if ($id) {
    foreach($posts as $p) {
        if($p['id'] == $id) {
            $current_post = $p;
            break;
        }
    }
}

// Nếu không tìm thấy bài viết, quay về trang danh sách
if(!$current_post) {
    header("Location: /tin-tuc");
    exit;
}

$page_title = $current_post['title'];
include 'includes/header.php';
?>

<style>
    /* CSS QUAN TRỌNG: Sửa lỗi tràn ảnh trên điện thoại */
    .news-main-content {
        line-height: 1.8; 
        color: #334155; 
        font-size: 1.15rem; 
        text-align: justify;
        overflow-wrap: break-word; /* Tránh tràn chữ */
    }

    .news-main-content img {
        max-width: 100% !important; /* Ép ảnh không vượt quá chiều rộng điện thoại */
        height: auto !important;    /* Giữ tỉ lệ ảnh không bị móp méo */
        display: block;
        margin: 25px auto;          /* Căn giữa và tạo khoảng cách trên dưới */
        border-radius: 8px;
    }

    /* Đảm bảo các video dán vào (nếu có) cũng không bị tràn */
    .news-main-content iframe {
        max-width: 100% !important;
        border-radius: 8px;
    }
</style>

<section style="padding: 4rem 0; background: #fff;">
    <div class="container" style="max-width: 900px;">
        <div style="margin-bottom: 2rem;">
            <a href="/tin-tuc" style="color: #10b981; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-left"></i> Quay lại Tin tức
            </a>
        </div>

        <article>
            <div style="color: #94a3b8; font-size: 0.95rem; margin-bottom: 1rem;">
                <i class="far fa-calendar-alt"></i> Ngày đăng: <?php echo date('d/m/Y', strtotime($current_post['created_at'])); ?>
            </div>

            <h1 style="font-size: 2.5rem; color: #1e293b; line-height: 1.2; margin-bottom: 2rem; font-weight: 800;">
                <?php echo htmlspecialchars($current_post['title']); ?>
            </h1>

            <?php if(!empty($current_post['image']) && file_exists('uploads/' . $current_post['image'])): ?>
                <div style="margin-bottom: 3rem; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <img src="/uploads/<?php echo htmlspecialchars($current_post['image']); ?>" 
                         alt="<?php echo htmlspecialchars($current_post['title']); ?>" 
                         style="width: 100%; height: auto; display: block;">
                </div>
            <?php endif; ?>

            <div class="news-main-content">
                <?php 
                    // Vì nội dung từ CKEditor đã là mã HTML (có sẵn thẻ <p>, <strong>, <img>), 
                    // ta in trực tiếp mà không cần nl2br để tránh bị dư khoảng cách dòng.
                    echo $current_post['content']; 
                ?>
            </div>
        </article>

        <div style="margin-top: 5rem; padding: 2rem; background: #f8fafc; border-radius: 12px; border-left: 5px solid #10b981;">
            <h4 style="margin-bottom: 10px; color: #1e293b;">Bạn cần tư vấn về giải pháp năng lượng?</h4>
            <p style="color: #64748b; margin-bottom: 1.5rem;">Hãy để lại thông tin hoặc gọi ngay cho chúng tôi để được hỗ trợ miễn phí.</p>
            <a href="/lien-he" class="btn" style="background: #10b981; color: white; padding: 10px 25px; border-radius: 8px; text-decoration: none; font-weight: 600;">Liên hệ ngay</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>