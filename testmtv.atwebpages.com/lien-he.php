<?php
// contact.php
session_start();
require_once 'config/db.php';

$page_title = 'Liên hệ';
include 'includes/header.php';
?>

<section class="section" style="padding: 4rem 0; background-color: #f8fafc;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-size: 2.2rem; color: #1e293b; font-weight: 800;">LIÊN HỆ VỚI CHÚNG TÔI</h2>
            <div style="width: 80px; height: 4px; background: #10b981; margin: 15px auto; border-radius: 2px;"></div>
            <p style="color: #64748b; font-size: 1.1rem;">Hãy để lại thông tin, đội ngũ kỹ sư của ENERGY Mặt Trời Việt sẽ tư vấn giải pháp tối ưu nhất cho bạn.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            
            <div style="background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.4rem; color: #1e293b; margin-bottom: 1.5rem; font-weight: 700;">Thông tin công ty</h3>
                
                <div style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 1.5rem;">
                    <div style="width: 45px; height: 45px; background: #e6f6ef; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <strong style="display: block; color: #1e293b; margin-bottom: 5px;">Địa chỉ văn phòng</strong>
                        <span style="color: #64748b; line-height: 1.5;">231 Đ. 30 Tháng 4, P. Xuân Khánh, Q. Ninh Kiều, Cần Thơ</span>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 1.5rem;">
                    <div style="width: 45px; height: 45px; background: #e6f6ef; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <strong style="display: block; color: #1e293b; margin-bottom: 5px;">Hotline tư vấn (24/7)</strong>
                        <a href="tel:0789686565" style="color: #10b981; text-decoration: none; font-weight: 700; font-size: 1.1rem;">0789 68 65 65</a>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 15px;">
                    <div style="width: 45px; height: 45px; background: #e6f6ef; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <strong style="display: block; color: #1e293b; margin-bottom: 5px;">Email hỗ trợ</strong>
                        <a href="mailto:mattroivietct@gmail.com" style="color: #64748b; text-decoration: none;">mattroivietct@gmail.com</a>
                    </div>
                </div>
            </div>

            <div style="background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.4rem; color: #1e293b; margin-bottom: 1.5rem; font-weight: 700;">Gửi yêu cầu tư vấn</h3>
                
                <div id="formMessage" style="display: none; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;"></div>

                <form id="ajaxContactForm">
                    <div class="form-group" style="margin-bottom: 1.2rem;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">Họ và tên *</label>
                        <input type="text" name="name" required style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; transition: 0.3s;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem;">
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">Số điện thoại *</label>
                            <input type="tel" name="phone" required pattern="(0|\+84)[0-9]{9,10}" title="Vui lòng nhập số điện thoại hợp lệ (VD: 098...)" style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; transition: 0.3s;">
                        </div>
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">Email (Tuỳ chọn)</label>
                            <input type="email" name="email" style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; transition: 0.3s;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">Nội dung cần tư vấn *</label>
                        <textarea name="message" rows="4" required style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; resize: vertical; transition: 0.3s;"></textarea>
                    </div>

                    <button type="submit" id="submitBtn" style="width: 100%; background: #10b981; color: white; border: none; padding: 14px; border-radius: 8px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: 0.3s;">
                        <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> GỬI YÊU CẦU
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</section>

<script>
document.getElementById('ajaxContactForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Chặn việc tự động tải lại trang

    const submitBtn = document.getElementById('submitBtn');
    const formMessage = document.getElementById('formMessage');
    const formData = new FormData(this);
    
    // 1. Chuyển dữ liệu Form thành định dạng JSON để gửi cho API
    const data = {
        name: formData.get('name'),
        phone: formData.get('phone'),
        email: formData.get('email'),
        message: formData.get('message')
    };

    // 2. Thay đổi nút thành trạng thái "Đang gửi"
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i> ĐANG GỬI...';
    submitBtn.style.background = '#94a3b8';
    formMessage.style.display = 'none';

    // 3. Gửi dữ liệu tới file api/message.php
    fetch('/api/message?action=send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        // 4. Nhận kết quả từ API và khôi phục nút bấm
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 8px;"></i> GỬI YÊU CẦU';
        submitBtn.style.background = '#10b981';
        
        formMessage.style.display = 'block';
        
        if(result.success) {
            // Thành công (Màu xanh lá)
            formMessage.style.backgroundColor = '#dcfce7';
            formMessage.style.color = '#166534';
            formMessage.style.borderLeft = '4px solid #16a34a';
            formMessage.innerHTML = '<i class="fas fa-check-circle" style="margin-right: 5px;"></i> ' + result.message;
            this.reset(); // Làm trống các ô nhập liệu
        } else {
            // Lỗi do nhập thiếu / sai chuẩn (Màu đỏ)
            formMessage.style.backgroundColor = '#fee2e2';
            formMessage.style.color = '#991b1b';
            formMessage.style.borderLeft = '4px solid #dc2626';
            formMessage.innerHTML = '<i class="fas fa-exclamation-circle" style="margin-right: 5px;"></i> Lỗi: ' + result.error;
        }
    })
    .catch(error => {
        // Lỗi do mất mạng hoặc sai đường dẫn file API
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 8px;"></i> GỬI YÊU CẦU';
        submitBtn.style.background = '#10b981';
        
        formMessage.style.display = 'block';
        formMessage.style.backgroundColor = '#fee2e2';
        formMessage.style.color = '#991b1b';
        formMessage.style.borderLeft = '4px solid #dc2626';
        formMessage.innerHTML = '<i class="fas fa-exclamation-circle" style="margin-right: 5px;"></i> Đã xảy ra lỗi kết nối. Vui lòng thử lại sau!';
    });
});
</script>

<?php include 'includes/footer.php'; ?>