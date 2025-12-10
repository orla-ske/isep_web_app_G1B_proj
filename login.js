/* ===========================
   PetStride Login Page JavaScript
   =========================== */

// Track current mode (login or signup)
let isLogin = true;

/**
 * Toggle between login and signup modes
 */
function toggleMode() {
    isLogin = !isLogin;
    
    // Get all the elements we need to update
    const welcomeTitle = document.getElementById('welcome-title');
    const welcomeSubtitle = document.getElementById('welcome-subtitle');
    const submitBtn = document.getElementById('submit-btn');
    const toggleText = document.getElementById('toggle-text');
    const toggleBtn = document.getElementById('toggle-btn');
    const nameGroup = document.getElementById('name-group');
    const confirmPasswordGroup = document.getElementById('confirm-password-group');
    const forgotPassword = document.getElementById('forgot-password');
    const nameInput = document.getElementById('name-input');
    const confirmPasswordInput = document.getElementById('confirm-password-input');

    if (isLogin) {
        // Switch to Login Mode
        welcomeTitle.textContent = 'Welcome Back!';
        welcomeSubtitle.textContent = 'Sign in to connect with loving pet caregivers';
        submitBtn.textContent = 'Sign In';
        toggleText.textContent = "Don't have an account? ";
        toggleBtn.textContent = 'Sign up';
        
        // Hide signup-specific fields
        nameGroup.classList.add('hidden');
        confirmPasswordGroup.classList.add('hidden');
        forgotPassword.classList.remove('hidden');
        
        // Remove required attribute
        nameInput.removeAttribute('required');
        confirmPasswordInput.removeAttribute('required');
    } else {
        // Switch to Signup Mode
        welcomeTitle.textContent = 'Join PetStride';
        welcomeSubtitle.textContent = 'Start your journey with trusted pet care';
        submitBtn.textContent = 'Create Account';
        toggleText.textContent = 'Already have an account? ';
        toggleBtn.textContent = 'Sign in';
        
        // Show signup-specific fields
        nameGroup.classList.remove('hidden');
        confirmPasswordGroup.classList.remove('hidden');
        forgotPassword.classList.add('hidden');
        
        // Add required attribute
        nameInput.setAttribute('required', '');
        confirmPasswordInput.setAttribute('required', '');
    }
}

/**
 * Toggle password visibility
 */
function togglePassword() {
    const passwordInput = document.getElementById('password-input');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (passwordInput.type === 'password') {
        // Show password
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.93 6.93m7.071 7.071l2.828 2.829M21 21l-3.6-3.6m-3.525-3.525L6.93 6.93"></path>';
    } else {
        // Hide password
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}

/**
 * Handle form submission
 */
    // --- 1. EXISTING UI FUNCTIONS (Keep these exactly as they are) ---

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }

    function toggleSignupPassword() {
        const passwordInput = document.getElementById('signup-password');
        const eyeIcon = document.getElementById('signup-eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }

    function toggleForm() {
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');
        const formTitle = document.getElementById('form-title');
        const formSubtitle = document.getElementById('form-subtitle');
        const toggleText = document.getElementById('toggle-text');
        const toggleBtn = document.getElementById('toggle-btn');
        
        if (loginForm.classList.contains('hidden')) {
            // Show login form
            loginForm.classList.remove('hidden');
            signupForm.classList.add('hidden');
            formTitle.textContent = 'Welcome Back!';
            formSubtitle.textContent = 'Sign in to continue to PetStride';
            toggleText.textContent = "Don't have an account? ";
            toggleBtn.textContent = 'Sign up';
        } else {
            // Show signup form
            loginForm.classList.add('hidden');
            signupForm.classList.remove('hidden');
            formTitle.textContent = 'Create Account';
            formSubtitle.textContent = 'Join the PetStride community';
            toggleText.textContent = 'Already have an account? ';
            toggleBtn.textContent = 'Sign in';
        }
    }

    // --- 2. NEW BACKEND LOGIC (This replaces the old alerts) ---

    // A reusable function to handle sending data to login.php
    async function submitAuthForm(event, formId, actionType) {
        event.preventDefault(); // Stop the page from reloading

        const form = document.getElementById(formId);
        const submitBtn = form.querySelector('.submit-btn');
        const originalText = submitBtn.innerText;

        // 1. Show loading state
        submitBtn.innerText = 'Processing...';
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';

        // 2. Gather data
        const formData = new FormData(form);
        // Manually add the action type (login or signup) so PHP knows what to do
        formData.append('action', actionType);

        try {
            // 3. Send to PHP
            const response = await fetch('login.php', {
                method: 'POST',
                body: formData
            });

            // 4. Handle Response
            const result = await response.json();

            if (result.status === 'success') {
                // Success - Redirect
                window.location.href = 'dashboard.php'; // Change to dashboard.php later
            } else {
                // Error - Show alert
                alert(result.message);
            }

        } catch (error) {
            console.error('Error:', error);
            alert('Something went wrong connecting to the server.');
        } finally {
            // 5. Reset button
            submitBtn.innerText = originalText;
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }
    }

    // Attach the new logic to the forms
    document.getElementById('login-form').addEventListener('submit', function(e) {
        submitAuthForm(e, 'login-form', 'login');
    });

    document.getElementById('signup-form').addEventListener('submit', function(e) {
        submitAuthForm(e, 'signup-form', 'signup');
    });

/**
 * Add smooth scroll behavior
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('PetStride Login Page Loaded Successfully! 🐾');
});

/* ===========================
   PetStride FAQ Page JavaScript
   =========================== */

/**
 * Toggle accordion item open/closed
 * @param {number} index - The index of the accordion item
 */
function toggleAccordion(index) {
    const content = document.getElementById(`content-${index}`);
    const icon = document.getElementById(`icon-${index}`);
    
    // Check if this item is currently open
    const isOpen = content.classList.contains('open');
    
    // Close all accordion items
    const allContents = document.querySelectorAll('.accordion-content');
    const allIcons = document.querySelectorAll('.accordion-icon');
    
    allContents.forEach(item => item.classList.remove('open'));
    allIcons.forEach(item => item.classList.remove('open'));
    
    // If the clicked item was closed, open it
    if (!isOpen) {
        content.classList.add('open');
        icon.classList.add('open');
    }
}

/**
 * Initialize page
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('PetStride FAQ Page Loaded Successfully! 🐾');
    
    // Optional: Open first item by default
    // toggleAccordion(0);
});

/* ===========================
   PetStride Contact Page JavaScript
   =========================== */

/**
 * Handle form submission
 */
document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;
    
    // Log form data (in production, this would send to your backend)
    console.log('Contact form submitted:', {
        name,
        email,
        subject,
        message
    });
    
    // Show success message
    alert('Thank you for your message!\n\nWe\'ll get back to you as soon as possible.\n\nName: ' + name + '\nEmail: ' + email);
    
    // Reset form
    document.getElementById('contact-form').reset();
});

/**
 * Initialize page
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('PetStride Contact Page Loaded Successfully! 🐾');
});

