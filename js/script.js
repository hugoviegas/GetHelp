/**
 * GetHelp - Main JavaScript File
 * This file contains all the interactive functionality for the GetHelp website
 * Created by: Hugo Viegas - 2024319
 */

// Wait for the DOM to be fully loaded before executing any JavaScript
document.addEventListener("DOMContentLoaded", function () {
  // ===== Form Validation =====
  // This section handles the validation of the contact us form
  const helpForm = document.getElementById("help-form");
  const messageContainer = document.getElementById("message-container");

  function showMessage(message, type) {
    messageContainer.innerHTML = `
      <div class="${type === "error" ? "error-box" : "success-box"}">
        ${message}
      </div>
    `;
    messageContainer.scrollIntoView({ behavior: "smooth" });
  }

  // Check if the help form exists on the page
  if (helpForm) {
    helpForm.addEventListener("submit", function (event) {
      // Prevent the form from submitting by default
      event.preventDefault();
      messageContainer.innerHTML = ""; // Clear previous messages

      // Store each input field in a variable using getElementById
      const nameInput = document.getElementById("name");
      const emailInput = document.getElementById("email");
      const phoneInput = document.getElementById("phone");
      const messageInput = document.getElementById("message");

      // Here we are initializing a variable to track if the form is valid
      let isValid = true;
      let errors = [];

      // Conditional uses the function validateName to check if the name is valid.
      if (!validateName(nameInput.value)) {
        errors.push("Name should contain only letters and spaces");
        isValid = false; // If the name is not valid, we set isValid to false
      }

      // Conditional uses the function validatePhone to check if the phone is valid, with 9 or 10 digits
      if (!validatePhone(phoneInput.value)) {
        errors.push("Phone number must contain 9 or 10 digits");
        isValid = false; // If the phone number is not valid, we set isValid to false
      }

      // Conditional uses a simple check to see if the email is empty
      if (emailInput.value.trim() === "") {
        errors.push("Email cannot be empty");
        isValid = false; // If the email is empty, we set isValid to false
      }

      // Conditional uses a simple check to see if the message is empty
      if (messageInput.value.trim() === "") {
        errors.push("Message cannot be empty");
        isValid = false; // If the message is empty, we set isValid to false
      }

      // If all validations pass, show success message and reset form
      if (!isValid) {
        showMessage(errors.join("<br>"), "error");
      } else {
        showMessage(
          "Your request has been submitted successfully! We will contact you soon.",
          "success"
        );
        helpForm.reset(); // Reset the form fields to their initial state
      }
    });
  }

  // ===== Register Form Validation =====
  const registerForm = document.getElementById("register-form");

  if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
      // The form validation is now handled by validateForm() via onsubmit attribute
    });
  }

  // Validate the entire form before submission
  function validateForm() {
    // Store each input field in a variable
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");
    const captchaInput = document.getElementById("captcha");

    let isValid = true;

    // Validate name (only letters and spaces)
    if (!validateName(nameInput.value)) {
      showValidationError(
        nameInput,
        "Name must contain only letters and spaces"
      );
      isValid = false;
    } else {
      clearValidationError(nameInput);
    }

    // Validate email
    if (!validateEmail(emailInput.value)) {
      showValidationError(emailInput, "Please provide a valid email");
      isValid = false;
    } else {
      clearValidationError(emailInput);
    }

    // Validate phone
    if (!validatePhone(phoneInput.value)) {
      showValidationError(
        phoneInput,
        "Phone number must contain 9 to 10 digits"
      );
      isValid = false;
    } else {
      clearValidationError(phoneInput);
    }

    // Validate password (now checks for uppercase, lowercase, and number)
    if (!validatePassword(passwordInput.value)) {
      showValidationError(
        passwordInput,
        "Password must be at least 6 characters, include uppercase, lowercase, and a number."
      );
      isValid = false;
    } else {
      clearValidationError(passwordInput);
    }

    // Validate password confirmation
    if (passwordInput.value !== confirmPasswordInput.value) {
      showValidationError(confirmPasswordInput, "Passwords do not match");
      isValid = false;
    } else {
      clearValidationError(confirmPasswordInput);
    }

    // Validate captcha
    if (captchaInput.value.trim() === "") {
      showValidationError(captchaInput, "Please enter the verification code");
      isValid = false;
    } else {
      clearValidationError(captchaInput);
    }

    return isValid;
  }

  // ===== Login Form Validation =====
  const loginForm = document.getElementById("login-form");

  if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
      // Store each input field in a variable
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");

      let isValid = true;

      // Validate email
      if (!validateEmail(emailInput.value)) {
        event.preventDefault();
        showValidationError(emailInput, "Please provide a valid email");
        isValid = false;
      } else {
        clearValidationError(emailInput);
      }

      // Validate password
      if (passwordInput.value.trim() === "") {
        event.preventDefault();
        showValidationError(passwordInput, "Please enter your password");
        isValid = false;
      } else {
        clearValidationError(passwordInput);
      }

      return isValid;
    });
  }

  // Function to validate name (only letters and spaces)
  function validateName(name) {
    const nameRegex = /^[A-Za-z\s]+$/; // Regex will match only letters (both uppercase and lowercase) and spaces
    return nameRegex.test(name); // Returns true if valid, false otherwise
  }

  // Function to validate phone number (must be 9 or 10 digits and contain only numbers)
  function validatePhone(phone) {
    const phoneRegex = /^\d{9,10}$/; // Regex will match only numbers with 9 or 10 digits
    return phoneRegex.test(phone); // Returns true if valid, false otherwise
  }

  // Function to validate email
  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // Function to show validation error
  function showValidationError(inputElement, message) {
    // Remove existing error message if any
    clearValidationError(inputElement);

    // Create error message element
    const errorElement = document.createElement("div");
    errorElement.className = "validation-error";
    errorElement.style.color = "var(--danger-color)";
    errorElement.style.fontSize = "0.85rem";
    errorElement.style.marginTop = "5px";
    errorElement.textContent = message;

    // Insert error message after input
    inputElement.parentNode.appendChild(errorElement);

    // Highlight input field
    inputElement.style.borderColor = "var(--danger-color)";
  }

  // Function to clear validation error
  function clearValidationError(inputElement) {
    // Remove error message if exists
    const errorElement =
      inputElement.parentNode.querySelector(".validation-error");
    if (errorElement) {
      errorElement.remove();
    }

    // Reset input field style
    inputElement.style.borderColor = "";
  }

  // ===== Instant Password Validation (Uppercase, Lowercase, Number) =====
  // Get the password input field
  const passwordInput = document.getElementById("password");
  if (passwordInput) {
    // Listen for input and blur events to validate as the user types or leaves the field
    passwordInput.addEventListener("input", validatePasswordLive);
    passwordInput.addEventListener("blur", validatePasswordLive);
  }

  // This function checks if the password meets all requirements
  function validatePasswordLive() {
    const value = passwordInput.value;
    // Check for at least one uppercase, one lowercase, and one number
    const hasUpper = /[A-Z]/.test(value);
    const hasLower = /[a-z]/.test(value);
    const hasNumber = /[0-9]/.test(value);
    let message = "";
    if (value.length < 6) {
      message = "Password must be at least 6 characters.";
    } else if (!hasUpper) {
      message = "Password must have at least one uppercase letter.";
    } else if (!hasLower) {
      message = "Password must have at least one lowercase letter.";
    } else if (!hasNumber) {
      message = "Password must have at least one number.";
    }
    if (message) {
      showValidationError(passwordInput, message);
    } else {
      clearValidationError(passwordInput);
    }
  }

  // ===== Tutorials Page Interactive Elements =====
  // This section handles interactive elements on the tutorials page
  const moduleButtons = document.querySelectorAll(".module-container .btn");

  // Add click event listeners to all module buttons
  if (moduleButtons.length > 0) {
    moduleButtons.forEach(function (button) {
      button.addEventListener("click", function () {
        // Show an alert since we don't have actual module pages
        alert(
          "This feature is coming soon! The module content is under development."
        );
      });
    });
  }

  // ===== Burger Menu Toggle for Sidebar =====
  // Let's get the elements for the burger menu, sidebar, and overlay
  const burger = document.getElementById("burger-menu");
  const mobileMenu = document.getElementById("mobile-menu");
  const mobileOverlay = document.getElementById("mobile-menu-overlay");

  // Only add the event listeners if all elements exist
  if (burger && mobileMenu && mobileOverlay) {
    // This function closes the sidebar menu
    function closeMenu() {
      mobileMenu.classList.remove("open"); // Hide the sidebar
      mobileOverlay.classList.remove("open"); // Hide the overlay
      burger.setAttribute("aria-expanded", "false"); // Accessibility: mark as closed
      mobileMenu.setAttribute("aria-hidden", "true"); // Accessibility: mark as hidden
      document.body.classList.remove("mobile-menu-open"); // Remove body class
    }
    // When we click the burger icon, toggle the sidebar
    burger.addEventListener("click", function () {
      // Toggle the 'open' class to show/hide the sidebar
      const isOpen = mobileMenu.classList.toggle("open");
      // Also toggle the overlay
      mobileOverlay.classList.toggle("open", isOpen);
      // Update accessibility attributes
      burger.setAttribute("aria-expanded", isOpen ? "true" : "false");
      mobileMenu.setAttribute("aria-hidden", isOpen ? "false" : "true");
      // Add or remove a class on the body for possible styling
      document.body.classList.toggle("mobile-menu-open", isOpen);
    });
    // When we click any link inside the sidebar, close the menu
    mobileMenu.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", closeMenu);
    });
    // When we click the overlay (the dark background), close the menu
    mobileOverlay.addEventListener("click", closeMenu);
  }

  // ===== Instant Validation for All Register Fields =====
  if (registerForm) {
    // Get all input fields
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");
    const captchaInput = document.getElementById("captcha");

    // Helper to add instant validation to a field
    function addInstantValidation(input, validateFn, errorMsg) {
      if (!input) return;
      input.addEventListener("input", function () {
        if (!validateFn(input.value)) {
          showValidationError(input, errorMsg(input.value));
        } else {
          clearValidationError(input);
        }
      });
      input.addEventListener("blur", function () {
        if (!validateFn(input.value)) {
          showValidationError(input, errorMsg(input.value));
        } else {
          clearValidationError(input);
        }
      });
    }

    // Name: only letters and spaces
    addInstantValidation(
      nameInput,
      validateName,
      () => "Name must contain only letters and spaces."
    );
    // Email: must be valid
    addInstantValidation(
      emailInput,
      validateEmail,
      () => "Please provide a valid email."
    );
    // Phone: 9 or 10 digits
    addInstantValidation(
      phoneInput,
      validatePhone,
      () => "Phone number must contain 9 to 10 digits."
    );
    // Password: at least 6 chars, upper, lower, number
    addInstantValidation(passwordInput, validatePassword, (v) => {
      if (v.length < 6) return "Password must be at least 6 characters.";
      if (!/[A-Z]/.test(v))
        return "Password must have at least one uppercase letter.";
      if (!/[a-z]/.test(v))
        return "Password must have at least one lowercase letter.";
      if (!/[0-9]/.test(v)) return "Password must have at least one number.";
      return "Password is invalid.";
    });
    // Confirm password: must match password
    if (confirmPasswordInput && passwordInput) {
      function validateConfirmPassword() {
        return (
          confirmPasswordInput.value === passwordInput.value &&
          passwordInput.value.length > 0
        );
      }
      addInstantValidation(
        confirmPasswordInput,
        validateConfirmPassword,
        () => "Passwords do not match."
      );
      // Also update confirm password error when password changes
      passwordInput.addEventListener("input", function () {
        if (confirmPasswordInput.value.length > 0) {
          if (!validateConfirmPassword()) {
            showValidationError(
              confirmPasswordInput,
              "Passwords do not match."
            );
          } else {
            clearValidationError(confirmPasswordInput);
          }
        }
      });
    }
    // Captcha: not empty
    addInstantValidation(
      captchaInput,
      (v) => v.trim() !== "",
      () => "Please enter the verification code."
    );
  }

  // ===== Refresh CAPTCHA Image =====
  var refreshBtn = document.getElementById("refresh-captcha");
  var captchaImg = document.getElementById("captcha-img");
  if (refreshBtn && captchaImg) {
    refreshBtn.addEventListener("click", function (e) {
      e.preventDefault();
      captchaImg.src = "captcha.php?" + Date.now();
    });
  }
});

/**
 * CAPTCHA Refresh Function
 *
 * This function asynchronously fetches a new CAPTCHA code from the server
 * and updates the display on the current page without reloading.
 * It also clears the input field and sets focus to it for better user experience.
 */
function refreshCaptcha() {
  // Make a request to captcha.php to get a new CAPTCHA code
  fetch("captcha.php")
    .then((response) => {
      // Check if the response was successful
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then((data) => {
      // Update the CAPTCHA display with the new code
      document.querySelector(".captcha-code").textContent = data;

      // Clear the input field
      document.getElementById("captcha").value = "";

      // Focus on the input field for better UX
      document.getElementById("captcha").focus();
    })
    .catch((error) => {
      // Log any errors to the console
      console.error("Error refreshing CAPTCHA:", error);

      // Optionally display an error message to the user
      alert(
        "Failed to refresh verification code. Please try again or reload the page."
      );
    });
}

// --- Cookie Consent Bar with PHP logic ---
function showCookieConsentBar() {
  if (document.getElementById("cookie-consent-bar")) return;
  const bar = document.createElement("div");
  bar.id = "cookie-consent-bar";
  bar.innerHTML = `
    <span>
      We use cookies to improve your experience. By using our site, you agree to our
      <a href="privacy.php" style="color:#fff;text-decoration:underline;">Privacy Policy</a>.
    </span>
    <button class="btn primary" id="cookie-accept-btn">Accept</button>
  `;
  document.body.appendChild(bar);
  document.getElementById("cookie-accept-btn").onclick = function () {
    fetch("cookies/setcookies.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "consent=accept",
    }).then(() => {
      bar.remove();
    });
  };
}

function checkCookieConsent() {
  fetch("cookies/get_cookies.php")
    .then((r) => r.json())
    .then((data) => {
      if (!data || !data.cookieConsent || data.cookieConsent !== "accepted") {
        showCookieConsentBar();
      }
    });
}

document.addEventListener("DOMContentLoaded", checkCookieConsent);

// Add this function for password validation so it can be used by instant validation and form validation
function validatePassword(value) {
  // At least 6 characters, one uppercase, one lowercase, one number
  return (
    value.length >= 6 &&
    /[A-Z]/.test(value) &&
    /[a-z]/.test(value) &&
    /[0-9]/.test(value)
  );
}
