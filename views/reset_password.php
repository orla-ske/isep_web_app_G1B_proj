<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Set New Password - PetStride</title>
  <link rel="stylesheet" href="../Style/login.css">
  <style> body { display: flex; align-items: center; justify-content: center; min-height: 100vh; } </style>
</head>
<body>
<div class="container">
  <div class="background"></div>
  <div class="content">
    <div class="card">
      <div class="welcome">
        <h1>New Password</h1>
        <p>Please enter your new password.</p>
      </div>

      <form id="reset-form">
        <!-- 隐藏字段：Token 从 URL 获取 -->
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">

        <div class="form-group">
          <label class="label">New Password</label>
          <input type="password" name="password" class="input" placeholder="••••••••" required>
        </div>

        <button type="submit" class="submit-btn">Update Password</button>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('reset-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('action', 'reset_password');

    try {
      const res = await fetch('../controller/AuthController.php', { method: 'POST', body: formData });
      const data = await res.json();

      if (data.status === 'success') {
        alert(data.message);
        window.location.href = 'login.html'; // 重置成功回登录页
      } else {
        alert(data.message);
      }
    } catch (err) {
        console.error("🔥 捕获到的错误详情:", err); // 这行能让你在 Console 看到错误！
        console.log("尝试访问的地址:", '../controllers/AuthController.php'); // 打印路径方便检查
        alert('System error: ' + err.message); // 把错误信息弹出来
    }
  });
</script>
</body>
</html>
