<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>404 - Không tìm thấy trang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="text-center">
        <h1 class="display-1 fw-bold text-danger">404</h1>
        <h2 class="mb-3">Không tìm thấy trang</h2>
        <p class="text-muted mb-4">Trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Về trang chủ</a>
    </div>

</body>
</html>
