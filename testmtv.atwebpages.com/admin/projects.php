<?php
// admin/projects.php
session_start();
require_once '../config/db.php';
require_once '../config/image-processor.php';

check_admin_login();

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$error = ''; $success = '';
$projects = get_table_data('projects');

usort($projects, function($a, $b) { return strtotime($b['created_at']) - strtotime($a['created_at']); });

if($action == 'delete' && $id) {
    $project = get_record('projects', $id);
    if($project && !empty($project['image'])) { @unlink("../uploads/" . $project['image']); }
    delete_record('projects', $id);
    header("Location: projects.php?success=1"); exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape_input($_POST['name'] ?? ''); 
    $location = escape_input($_POST['location'] ?? '');
    $capacity = escape_input($_POST['capacity'] ?? ''); 
    
    // LƯU Ý: Lấy trực tiếp summary và content để giữ thẻ HTML và ảnh Base64
    $summary = $_POST['summary'] ?? '';
    $content = $_POST['content'] ?? '';
    
    $is_featured = isset($_POST['is_featured']) ? true : false;

    // --- KIỂM TRA GIỚI HẠN 3 DỰ ÁN NỔI BẬT ---
    if ($is_featured) {
        $count_featured = 0;
        foreach ($projects as $pj) {
            if ($action == 'edit' && $id == $pj['id']) continue;
            if (isset($pj['is_featured']) && $pj['is_featured'] == true) {
                $count_featured++;
            }
        }
        if ($count_featured >= 3) {
            $error = 'Lỗi: Đã có đủ 3 dự án tiêu biểu ở trang chủ!';
            $is_featured = false;
        }
    }

    if(empty($name) || empty($summary) || empty($content)) { 
        $error = 'Vui lòng điền đầy đủ tên, tóm tắt và nội dung!'; 
    } 
    else if (!$error) {
        $image = '';
        if(!empty($_FILES['image']['name'])) {
            $result = ImageProcessor::process($_FILES['image'], 'project', '../uploads/');
            if($result['success']) { $image = $result['filename']; } else { $error = $result['error']; }
        }

        $data_save = [
            'name' => $name, 
            'location' => $location, 
            'capacity' => $capacity, 
            'summary' => $summary,
            'content' => $content, 
            'is_featured' => $is_featured
        ];

        if($action == 'edit' && $id) {
            $old_project = get_record('projects', $id);
            if(empty($image)) { $data_save['image'] = $old_project['image']; } 
            else {
                $data_save['image'] = $image;
                if(!empty($old_project['image'])) { @unlink("../uploads/" . $old_project['image']); }
            }

            if(!$error) {
                update_record('projects', $id, $data_save);
                $success = 'Cập nhật dự án thành công!';
            }
        } else {
            if(!$error) {
                $data_save['image'] = $image;
                $data_save['created_at'] = date('Y-m-d H:i:s');
                add_record('projects', $data_save);
                $success = 'Thêm dự án thành công!';
            }
        }
        if($success) { $_POST = []; $action = 'list'; $id = null; $projects = get_table_data('projects'); }
    }
}

$project = null;
if($action == 'edit' && $id) {
    $project = get_record('projects', $id);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dự Án - Admin</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { background-color: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .admin-header { background: white; padding: 2rem 0; margin-bottom: 2rem; border-bottom: 1px solid #e2e8f0; }
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden; }
        .card-content { padding: 1.5rem; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { background-color: #f8fafc; padding: 1rem; text-align: left; font-weight: 600; border-bottom: 2px solid #e2e8f0; }
        .table td { padding: 1rem; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .form-group { margin-bottom: 1.5rem; width: 100%; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1e293b; }
        .form-group input[type="text"], .form-group textarea {
            display: block; width: 100%; padding: 12px 16px; border: 1.5px solid #cbd5e1; 
            border-radius: 8px; font-family: inherit; font-size: 1rem; box-sizing: border-box;
        }
        .ck-editor__editable { min-height: 400px; background-color: white !important; }
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
                <li><a href="posts.php">Tin tức</a></li>
                <li><a href="projects.php" style="color: #10b981; font-weight: 700;">Dự án</a></li>
                <li><a href="logout.php" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 99px;">Đăng xuất</a></li>
            </ul>
        </div>
    </nav>

    <div class="admin-header">
        <div class="container"><h1><i class="fas fa-solar-panel" style="color:#10b981;"></i> Quản lý Dự Án</h1></div>
    </div>

    <div class="page-content">
        <div class="container">
            <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
            <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

            <?php if($action == 'add' || $action == 'edit'): ?>
                <div class="card" style="max-width: 900px; margin: 0 auto;">
                    <div class="card-content">
                        <h3><?php echo $action == 'add' ? 'Thêm dự án mới' : 'Sửa dự án'; ?></h3>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên dự án *</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($project['name'] ?? ''); ?>" required>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div class="form-group"><label>Địa điểm</label><input type="text" name="location" value="<?php echo htmlspecialchars($project['location'] ?? ''); ?>"></div>
                                <div class="form-group"><label>Công suất</label><input type="text" name="capacity" value="<?php echo htmlspecialchars($project['capacity'] ?? ''); ?>"></div>
                            </div>

                            <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #e0f2fe; border-radius: 8px;">
                                <input type="checkbox" name="is_featured" id="is_featured" style="width: 20px; height: 20px;" <?php echo (isset($project['is_featured']) && $project['is_featured']) ? 'checked' : ''; ?>>
                                <label for="is_featured" style="margin: 0; color: #0369a1;">Hiển thị dự án này tiêu biểu ở Trang Chủ (Tối đa 3)</label>
                            </div>

                            <div class="form-group">
                                <label>Tóm tắt ngắn (Hiện ở danh sách dự án) *</label>
                                <textarea name="summary" rows="3" required><?php echo htmlspecialchars($project['summary'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội dung chi tiết (Có thể chèn hình vào giữa) *</label>
                                <textarea name="content" id="editor"><?php echo $project['content'] ?? ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Ảnh bìa đại diện</label>
                                <input type="file" name="image" accept="image/*">
                            </div>

                            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                <button type="submit" class="btn btn-primary" style="flex: 1;">Lưu Dự Án</button>
                                <a href="projects.php" class="btn" style="flex: 1; background: #94a3b8; color: white; text-align: center; text-decoration: none; line-height: 25px;">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div style="margin-bottom: 1.5rem;"><a href="?action=add" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm dự án</a></div>
                <div class="card">
                    <table class="table">
                        <thead><tr><th>Ảnh</th><th>Tên dự án</th><th>Địa điểm</th><th>Tiêu biểu</th><th>Hành động</th></tr></thead>
                        <tbody>
                            <?php if(!empty($projects)): foreach($projects as $row): ?>
                                <tr>
                                    <td><img src="../uploads/<?php echo $row['image']; ?>" style="max-width: 60px; border-radius: 4px;"></td>
                                    <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                                    <td><?php echo (isset($row['is_featured']) && $row['is_featured']) ? '<span style="color:#0ea5e9;">★ Tiêu biểu</span>' : '-'; ?></td>
                                    <td>
                                        <a href="?action=edit&id=<?php echo $row['id']; ?>" class="btn" style="background:#3b82f6;color:white;padding:6px 12px;font-size:0.85rem; border-radius:6px;"><i class="fas fa-edit"></i></a>
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn" style="background:#ef4444;color:white;padding:6px 12px;font-size:0.85rem; border-radius:6px;" onclick="return confirm('Xóa dự án này?');"><i class="fas fa-trash"></i></a>
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
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return {
                    upload: () => loader.file.then(file => new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.onload = () => resolve({ default: reader.result });
                        reader.onerror = error => reject(error);
                        reader.readAsDataURL(file);
                    }))
                };
            };
        })
        .catch(error => { console.error(error); });
</script>
</body>
</html>