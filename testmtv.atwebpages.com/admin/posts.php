<?php
// admin/posts.php
session_start();
require_once '../config/db.php';
require_once '../config/image-processor.php';

check_admin_login();

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$error = ''; $success = '';
$posts = get_table_data('posts');

usort($posts, function($a, $b) { return strtotime($b['created_at']) - strtotime($a['created_at']); });

if($action == 'delete' && $id) {
    $post = get_record('posts', $id);
    if($post && !empty($post['image'])) { @unlink("../uploads/" . $post['image']); }
    delete_record('posts', $id);
    header("Location: posts.php?success=1"); exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // SỬA TẠI ĐÂY: Chỉ dùng escape_input cho tiêu đề. 
    // Content và Summary cần giữ nguyên để lưu được thẻ HTML và ảnh Base64.
    $title = escape_input($_POST['title'] ?? ''); 
    $summary = $_POST['summary'] ?? ''; 
    $content = $_POST['content'] ?? ''; 
    
    if(empty($title) || empty($summary) || empty($content)) { 
        $error = 'Vui lòng điền tiêu đề, tóm tắt và nội dung!'; 
    } 
    else {
        $image = '';
        if(!empty($_FILES['image']['name'])) {
            $result = ImageProcessor::process($_FILES['image'], 'post', '../uploads/');
            if($result['success']) { $image = $result['filename']; } else { $error = $result['error']; }
        }

        if($action == 'edit' && $id) {
            $old_post = get_record('posts', $id);
            if(empty($image)) { $image = $old_post['image']; } 
            else if(!empty($old_post['image'])) { @unlink("../uploads/" . $old_post['image']); }

            if(!$error) {
                // Đảm bảo truyền đủ mảng dữ liệu có trường 'summary'
                update_record('posts', $id, [
                    'title' => $title, 
                    'summary' => $summary, 
                    'content' => $content, 
                    'image' => $image
                ]);
                $success = 'Cập nhật bài viết thành công!';
            }
        } else {
            if(!$error) {
                add_record('posts', [
                    'title' => $title, 
                    'summary' => $summary, 
                    'content' => $content, 
                    'image' => $image
                ]);
                $success = 'Thêm bài viết thành công!';
            }
        }
        if($success) { $_POST = []; $action = 'list'; $id = null; $posts = get_table_data('posts'); }
    }
}
$post = null;
if($action == 'edit' && $id) {
    $post = get_record('posts', $id);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tin Tức - ENERGY Mặt Trời Việt</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { background-color: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .admin-header { background: white; padding: 2rem 0; margin-bottom: 2rem; border-bottom: 1px solid #e2e8f0; }
        .admin-header h1 { margin: 0; font-size: 1.5rem; color: #1e293b; }
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .card-content { padding: 1.5rem; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { background-color: #f8fafc; padding: 1rem; text-align: left; font-weight: 600; border-bottom: 2px solid #e2e8f0; }
        .table td { padding: 1rem; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .form-group { margin-bottom: 1.5rem; width: 100%; }
        .form-group label { display: block; margin-bottom: 0.6rem; font-weight: 600; color: #1e293b; }
        .form-group input[type="text"], .form-group textarea {
            display: block; width: 100%; padding: 12px 16px; border: 1.5px solid #cbd5e1; 
            border-radius: 8px; font-family: inherit; font-size: 1rem;
            background-color: #f8fafc; box-sizing: border-box; transition: 0.3s;
        }
        .ck-editor__editable { min-height: 400px; background-color: white !important; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #10b981; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="/" class="logo"><i class="fas fa-sun" style="color: #10b981;"></i> ENERGY Mặt Trời Việt</a>
            </div>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="products.php">Sản phẩm</a></li>
                <li><a href="posts.php" style="color: #10b981; font-weight: 700;">Tin tức</a></li>
                <li><a href="projects.php">Dự án</a></li>
                <li><a href="messages.php"><i class="fas fa-comment-dots"></i> Tin nhắn</a></li>
                <li><a href="logout.php" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 99px;">Đăng xuất</a></li>
            </ul>
        </div>
    </nav>

    <div class="admin-header">
        <div class="container"><h1><i class="fas fa-newspaper" style="color:#10b981;"></i> Quản lý Tin Tức</h1></div>
    </div>

    <div class="page-content">
        <div class="container">
            <?php if($success): ?><div class="alert alert-success"><i class="fas fa-check"></i> <?php echo $success; ?></div><?php endif; ?>
            <?php if($error): ?><div class="alert alert-danger"><i class="fas fa-times"></i> <?php echo $error; ?></div><?php endif; ?>

            <?php if($action == 'add' || $action == 'edit'): ?>
                <div class="card" style="max-width: 900px; margin: 0 auto;">
                    <div class="card-content">
                        <h3 style="margin-top:0; margin-bottom:1.5rem;"><?php echo $action == 'add' ? 'Viết bài mới' : 'Sửa bài viết'; ?></h3>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tiêu đề bài viết *</label>
                                <input type="text" name="title" value="<?php echo htmlspecialchars($post['title'] ?? ''); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Tóm tắt ngắn *</label>
                                <textarea name="summary" rows="3" required><?php echo htmlspecialchars($post['summary'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội dung bài viết *</label>
                                <textarea name="content" id="editor"><?php echo $post['content'] ?? ''; ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Ảnh bìa</label>
                                <input type="file" name="image" accept="image/*">
                            </div>
                            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 12px;">Lưu bài viết</button>
                                <a href="posts.php" class="btn" style="flex: 1; background: #94a3b8; color: white; text-align: center; text-decoration: none; line-height: 25px;">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div style="margin-bottom: 1.5rem;"><a href="?action=add" class="btn btn-primary"><i class="fas fa-plus"></i> Viết bài mới</a></div>
                <div class="card">
                    <table class="table">
                        <thead><tr><th>Ảnh</th><th>Tiêu đề</th><th>Tóm tắt</th><th>Ngày</th><th>Hành động</th></tr></thead>
                        <tbody>
                            <?php if(!empty($posts)): foreach($posts as $row): ?>
                                <tr>
                                    <td><img src="../uploads/<?php echo $row['image']; ?>" style="max-width: 60px;"></td>
                                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                                    <td style="font-size:0.85rem; max-width: 200px;"><?php echo htmlspecialchars(mb_substr($row['summary'] ?? '', 0, 50)) . '...'; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <a href="?action=edit&id=<?php echo $row['id']; ?>" class="btn" style="background:#3b82f6;color:white;"><i class="fas fa-edit"></i></a>
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn" style="background:#ef4444;color:white;" onclick="return confirm('Xóa?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: { uploadUrl: '' },
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'imageUpload', 'undo', 'redo'],
        })
        .then(editor => {
            const imageUploadHandler = (loader) => {
                return {
                    upload: () => loader.file.then(file => new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.onload = () => resolve({ default: reader.result });
                        reader.onerror = error => reject(error);
                        reader.readAsDataURL(file);
                    }))
                };
            };
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return imageUploadHandler(loader);
            };
        })
        .catch(error => { console.error(error); });
</script>
</body>
</html>