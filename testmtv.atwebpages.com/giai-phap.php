<?php
// giai-phap.php - Trang tổng quan các giải pháp
session_start();
require_once 'config/db.php';
$page_title = 'Giải pháp Năng lượng';
include 'includes/header.php';
?>

<style>
    /* Header với hiệu ứng gradient chuyên nghiệp */
    .solution-header {
        background: linear-gradient(rgba(16, 185, 129, 0.9), rgba(5, 150, 105, 0.9)), 
                    url('https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=1200');
        background-size: cover;
        background-position: center;
        padding: 6rem 0;
        color: white;
        text-align: center;
    }

    /* Grid layout cho các thẻ giải pháp */
    .solution-grid-detailed {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2.5rem;
        margin-top: -4rem; /* Đẩy các thẻ đè lên phần header một chút tạo chiều sâu */
        position: relative;
        z-index: 10;
    }

    /* Thiết kế thẻ Card màu trắng nổi bật trên nền xám nhạt */
    .sol-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sol-card:hover {
        transform: translateY(-12px);
        border-color: #10b981;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
    }

    /* Khung ảnh nền trắng tinh cho giải pháp */
    .sol-card-image-wrapper {
        width: 100%;
        height: 240px;
        background: #ffffff;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #f1f5f9;
    }

    .sol-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .sol-card:hover img {
        transform: scale(1.1);
    }

    /* Nội dung bên trong thẻ */
    .sol-card-body {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .sol-card-body h3 {
        color: #1e293b;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .sol-card-body p {
        color: #64748b;
        line-height: 1.7;
        margin-bottom: 2rem;
        font-size: 1rem;
    }

    /* Nút xem chi tiết đồng bộ màu thương hiệu */
    .btn-outline {
        margin-top: auto;
        padding: 12px 24px;
        border: 2px solid #10b981;
        color: #10b981;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 700;
        text-align: center;
        transition: all 0.3s ease;
    }

    .btn-outline:hover {
        background: #10b981;
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
</style>

<section class="solution-header">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: -1px;">
            Giải Pháp Năng Lượng Toàn Diện
        </h1>
        <p style="opacity: 0.95; max-width: 750px; margin: 0 auto; font-size: 1.2rem; font-weight: 300;">
            Chúng tôi cung cấp các hệ thống tối ưu nhất dựa trên nhu cầu thực tế của từng khách hàng, hướng tới tương lai bền vững.
        </p>
    </div>
</section>

<section class="section" style="background: #f8fafc; padding-bottom: 8rem; padding-top: 2rem;">
    <div class="container">
        <div class="solution-grid-detailed">
            
            <div class="sol-card">
                <div class="sol-card-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1613665813446-82a78c468a1d?q=80&w=800" alt="Hộ gia đình">
                </div>
                <div class="sol-card-body">
                    <h3>Hệ Thống Hộ Gia Đình</h3>
                    <p>Tận dụng diện tích mái nhà để tạo ra nguồn điện sạch, giúp giảm đến 90% hóa đơn tiền điện và làm mát không gian sống tự nhiên.</p>
                    <a href="/giai-phap-ho-gia-dinh.php" class="btn-outline">Xem chi tiết giải pháp</a>
                </div>
            </div>

            <div class="sol-card">
                <div class="sol-card-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1592833159155-c62df1b65634?q=80&w=800" alt="Doanh nghiệp">
                </div>
                <div class="sol-card-body">
                    <h3>Giải Pháp Doanh Nghiệp</h3>
                    <p>Cắt giảm chi phí vận hành khổng lồ, nâng cao uy tín thương hiệu xanh (Net Zero) và tối ưu hóa lợi nhuận đầu tư dài hạn cho nhà xưởng.</p>
                    <a href="/giai-phap-doanh-nghiep.php" class="btn-outline">Xem chi tiết giải pháp</a>
                </div>
            </div>

            <div class="sol-card">
                <div class="sol-card-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?q=80&w=800" alt="Hybrid">
                </div>
                <div class="sol-card-body">
                    <h3>Hệ Thống Lưu Trữ Hybrid</h3>
                    <p>Giải pháp tối ưu cho sự ổn định. Đảm bảo nguồn điện liên tục 24/7 cho các thiết bị quan trọng, kể cả khi lưới điện gặp sự cố bất ngờ.</p>
                    <a href="/giai-phap-hybrid.php" class="btn-outline">Xem chi tiết giải pháp</a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>