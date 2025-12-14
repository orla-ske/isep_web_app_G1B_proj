<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - PetStride</title>
  <!-- 确保路径指向正确的 CSS -->
  <link rel="stylesheet" href="../login.css">
  <style> body { display: flex; align-items: center; justify-content: center; min-height: 100vh; } </style>
</head>
<body>
<div class="container">
  <div class="background"></div>
  <div class="content">
    <div class="card">
      <div class="welcome">
        <h1>Reset Password</h1>
        <p>Enter your email to receive a reset link.</p>
      </div>

      <form id="forgot-form">
        <div class="form-group">
          <label class="label">Email Address</label>
          <input type="email" name="email" class="input" required>
        </div>
        <button type="submit" class="submit-btn">Send Reset Link</button>
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
    formData.append('action', 'forgot_password');

    const btn = this.querySelector('button');
    btn.innerText = 'Sending...';

    try {
      const res = await fetch('../controller/AuthController.php', { method: 'POST', body: formData });
      const data = await res.json();

      if (data.status === 'success') {
        // ⚠️ 模拟发送邮件：直接跳转到重置页
        alert("Simulating Email: Click OK to go to reset page.\n\n" + data.debug_link);
        window.location.href = data.debug_link;
      } else {
        alert(data.message);
      }
    } catch (err) {
      console.error(err);
      alert('System error');
    } finally {
      btn.innerText = 'Send Reset Link';
    }
  });
</script>
</body>
</html>
