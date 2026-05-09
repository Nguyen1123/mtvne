<?php
// tin-tuc.php
session_start();
require_once 'config/db.php';

$page_title = 'Tin tức Năng lượng';
include 'includes/header.php';

$posts = get_table_data('posts');
if (!empty($posts)) {
    usort($posts, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
}
?>

<style>
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        padding: 20px 0;
    }

    .news-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.1);
        border-color: #10b981;
    }

    /* KHUNG HÌNH TỰ ĐỘNG - NỀN MÀU TRẮNG */
    .news-image-container {
        width: 100%;
        height: 200px;
        background: #ffffff; /* ĐÃ ĐỔI SANG MÀU TRẮNG */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
        padding: 10px; /* Thêm chút padding để ảnh không dính sát viền */
    }

    .news-image-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; 
        transition: transform 0.5s ease;
    }

    .news-card:hover .news-image-container img {
        transform: scale(1.05);
    }

    .news-content {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .news-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 3.2em;
    }

    .news-excerpt {
        color: #64748b;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    .news-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f1f5f9;
        font-size: 0.85rem;
    }

    .news-date { color: #94a3b8; }
    .read-more { color: #10b981; font-weight: 600; text-decoration: none; }
</style>

<section style="padding: 3rem 0; background: #f1f5f9;">
    <div class="container">
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 2rem; color: #1e293b; font-weight: 800;">Bản tin Solar Việt</h2>
            <div style="width: 60px; height: 4px; background: #10b981; margin: 10px 0 15px; border-radius: 2px;"></div>
            <p style="color: #64748b;">Kiến thức và cập nhật mới nhất về năng lượng mặt trời</p>
        </div>

        <?php if(!empty($posts)): ?>
            <div class="news-grid">
                <?php foreach($posts as $post): ?>
                    <article class="news-card">
                        <div class="news-image-container">
                            <?php if(!empty($post['image']) && file_exists('uploads/'.$post['image'])): ?>
                                <img src="/uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Tin tức">
                            <?php else: ?>
                                <i class="fas fa-image fa-3x" style="color: #e2e8f0;"></i>
                            <?php endif; ?>
                        </div>

                        <div class="news-content">
                            <a href="/post-detail.php?id=<?php echo $post['id']; ?>" class="news-title">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>

                            <div class="news-excerpt">
                                <?php 
                                    $excerpt = !empty($post['summary']) ? $post['summary'] : strip_tags($post['content']);
                                    echo htmlspecialchars($excerpt); 
                                ?>
                            </div>

                            <div class="news-footer">
                                <span class="news-date">
                                    <i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                                </span>
                                <a href="/post-detail.php?id=<?php echo $post['id']; ?>" class="read-more">
                                    Đọc tiếp <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="background: white; padding: 3rem; border-radius: 12px; text-align: center; border: 1px solid #e2e8f0;">
                <p style="color: #94a3b8;">Hệ thống đang cập nhật tin tức...</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>