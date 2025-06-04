<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        .login-form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: white;
        }

        .welcome-section {
            flex: 1;
            background-color: #f5f6fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .input-password {
    position: relative;
}

       .input-password input {
    padding-right: 40px;
}

.input-password button {
    position: absolute;
    top: 0;
    bottom: 0;
    right: 10px;
    border: none;
    background: transparent;
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.input-password svg {
    width: 20px;
    height: 20px;
    color: #333;
}
.toggle-password {
    position: absolute;
    top: 50%;                  /* đặt giữa chiều cao */
    right: 15px;               /* sát mép phải */
    transform: translateY(-50%); /* căn giữa theo chiều dọc */
    cursor: pointer;
}

    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form-section">
        <div class="w-100" style="max-width: 400px;">
            <h3 class="mb-4 text-center">Đăng nhập tài khoản</h3>

            {{-- Nội dung động từ login.blade.php --}}
            @yield('content')
        </div>
    </div>
    <div class="welcome-section">
        <img src="{{ asset('images/login-illustration.png') }}" alt="Welcome" class="img-fluid mb-4" style="max-width: 400px;">
        <h4 class="text-center fw-bold">Chào mừng đến với hệ thống bán hàng chuyên nghiệp</h4>
        <p class="text-center text-muted">Giá rẻ, uy tín, chất lượng hàng đầu</p>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        const isHidden = input.type === "password";

        input.type = isHidden ? "text" : "password";
        icon.innerHTML = isHidden
            ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z"/>
               </svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.96 9.96 0 012.199-3.568M6.307 6.308A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.087 5.108M3 3l18 18"/>
               </svg>`;
    }
</script>

</body>
</html>
