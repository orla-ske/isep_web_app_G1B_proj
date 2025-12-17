<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - PetStride</title>
  <!-- 确保路径指向正确的 CSS -->
  <link rel="stylesheet" href="../Style/login.css">
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
  const originalText = btn.innerText;
  btn.disabled = true;
  btn.innerText = 'Sending...';

  try {
    const res = await fetch('../controller/AuthController.php', { 
      method: 'POST', 
      body: formData 
    });

    // Get the raw text first
    const text = await res.text();
    
    // Try to parse as JSON
    let data;
    try {
      data = JSON.parse(text);
    } catch (parseError) {
      console.error('Invalid JSON response:', text);
      alert('Server error: Invalid response format. Check console for details.');
      return;
    }

    if (data.status === 'success') {
      alert(data.message);
      
      // ⚠️ DEVELOPMENT ONLY: Auto-redirect to reset page
      if (data.debug_link) {
        const goToReset = confirm('DEBUG MODE: Go directly to reset page?');
        if (goToReset) {
          window.location.href = data.debug_link;
        }
      }
      
    } else {
      alert(data.message || 'An error occurred');
      if (data.error_detail) {
        console.error('Error details:', data.error_detail);
      }
    }
    
  } catch (err) {
    console.error('Error:', err);
    alert('System error. Please try again later.');
  } finally {
    btn.disabled = false;
    btn.innerText = originalText;
  }
});
</script>
</body>
</html>
