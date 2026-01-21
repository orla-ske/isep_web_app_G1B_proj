<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - PetStride</title>
    <!-- 确保路径指向正确的 CSS -->
    <link rel="stylesheet" href="../Style/login.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    </style>
</head>
<body>
<div class="container">
    <div class="background"></div>
    <div class="content">
        <div class="card">
            <div class="welcome">
                <h1>Forgot Password?</h1>
                <p>Enter your email to receive a 6-digit verification code.</p>
            </div>

            <form id="forgot-form">
                <div class="form-group">
                    <label class="label">Email Address</label>
                    <input type="email" name="email" class="input" placeholder="example@email.com" required>
                </div>
                <button type="submit" class="submit-btn">Send Verification Code</button>
                <div class="toggle">
                    <a href="../login.html">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('forgot-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('action', 'forgot_password'); // 对应 AuthController 的逻辑

        // 按钮进入加载状态
        const btn = this.querySelector('button');
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Sending...';

        try {
            // ⚠️ 确保路径正确：指向你的 Controller
            const res = await fetch('../controller/AuthController.php', {
                method: 'POST',
                body: formData
            });

            // 先获取文本，防止 PHP 报错返回 HTML 导致 JSON 解析崩溃
            const text = await res.text();

            let data;
            try {
                data = JSON.parse(text);
            } catch (parseError) {
                console.error('Invalid JSON response:', text);
                alert('Server error: The server returned an invalid response. Check console for details.');
                return; // 停止执行
            }

            if (data.status === 'success') {
                alert(data.message); // "Verification code sent..."

                // ✅ 成功后跳转到重置密码页面 (输入验证码的页面)
                // 并把邮箱传过去，方便用户
                const email = formData.get('email');
                window.location.href = `reset_password.php?email=${encodeURIComponent(email)}`;

            } else {
                alert(data.message || 'An error occurred');
            }

        } catch (err) {
            console.error('Network Error:', err);
            alert('System error. Please check your connection and try again.');
        } finally {
            // 恢复按钮状态
            btn.disabled = false;
            btn.innerText = originalText;
        }
    });
</script>
</body>
</html>
