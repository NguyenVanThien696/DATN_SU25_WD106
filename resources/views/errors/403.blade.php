<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>403 - Truy cập bị từ chối</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="text-center">
        <h1 class="display-1 fw-bold text-warning">403</h1>
        <h2 class="mb-3">Bạn không có quyền truy cập</h2>
        <p class="text-muted mb-4">Bạn không được cấp quyền truy cập vào trang này.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Về trang chủ</a>
    </div>

</body>
</html>
