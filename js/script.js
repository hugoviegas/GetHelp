/**
 * GetHelp - Main JavaScript File
 * This file contains all the interactive functionality for the GetHelp website
 * Created by: Hugo Viegas - 2024319
 */

// Wait for the DOM to be fully loaded before executing any JavaScript
document.addEventListener("DOMContentLoaded", function () {
  // ===== Mobile Menu Toggle =====
  // This section handles the mobile menu functionality
  const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
  const navLinks = document.querySelector(".nav-links");

  // Check if the mobile menu button exists on the page
  if (mobileMenuBtn) {
    // Add click event listener to toggle the mobile menu
    mobileMenuBtn.addEventListener("click", function () {
      // Toggle the 'active' class on the navigation links to show/hide them
      navLinks.classList.toggle("active");
      // Toggle the 'active' class on the button to change its appearance
      this.classList.toggle("active");
    });
  }

  // ===== Form Validation =====
  // This section handles the validation of the request help form
  const helpForm = document.getElementById("help-form");

  // Check if the help form exists on the page
  if (helpForm) {
    helpForm.addEventListener("submit", function (event) {
      // Prevent the form from submitting by default
      event.preventDefault();

      // Get form field values
      const nameInput = document.getElementById("name");
      const emailInput = document.getElementById("email");
      const phoneInput = document.getElementById("phone");
      const messageInput = document.getElementById("message");

      // Initialize a variable to track validation status
      let isValid = true;

      // Clear previous error messages
      clearErrors();

      // Validate Name (only letters and spaces allowed)
      if (!validateName(nameInput.value)) {
        showError(nameInput, "Name should contain only letters and spaces");
        isValid = false;
      }

      // Validate Phone (must be numeric and have 9 or 10 digits)
      if (!validatePhone(phoneInput.value)) {
        showError(phoneInput, "Phone number must contain 9 or 10 digits");
        isValid = false;
      }

      // Validate Email (simple check if not empty)
      if (emailInput.value.trim() === "") {
        showError(emailInput, "Email cannot be empty");
        isValid = false;
      }

      // Validate Message (simple check if not empty)
      if (messageInput.value.trim() === "") {
        showError(messageInput, "Message cannot be empty");
        isValid = false;
      }

      // If all validations pass, show success message and reset form
      if (isValid) {
        showSuccessMessage();
        helpForm.reset();
      }
    });
  }

  // Function to validate name (only letters and spaces)
  function validateName(name) {
    // Using regex to check if name contains only letters and spaces
    const nameRegex = /^[A-Za-z\s]+$/;
    return nameRegex.test(name);
  }

  // Function to validate phone number (must be 9 or 10 digits)
  function validatePhone(phone) {
    // Remove any non-digit characters
    const digits = phone.replace(/\D/g, "");
    // Check if the resulting string has exactly 9 or 10 digits
    return digits.length === 9 || digits.length === 10;
  }

  // Function to display error message for a specific input
  function showError(inputElement, message) {
    // Create error message element
    const errorDiv = document.createElement("div");
    errorDiv.className = "error-message";
    errorDiv.textContent = message;

    // Insert error message after the input element
    inputElement.parentNode.insertBefore(errorDiv, inputElement.nextSibling);

    // Add error class to the input
    inputElement.classList.add("error-input");
  }

  // Function to clear all error messages
  function clearErrors() {
    // Remove all error message elements
    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach(function (error) {
      error.remove();
    });

    // Remove error class from all inputs
    const inputs = document.querySelectorAll(".error-input");
    inputs.forEach(function (input) {
      input.classList.remove("error-input");
    });
  }

  // Function to show success message after form submission
  function showSuccessMessage() {
    // Create success message container
    const successDiv = document.createElement("div");
    successDiv.className = "success-message";
    successDiv.textContent =
      "Your request has been submitted successfully! We will contact you soon.";

    // Insert success message before the form
    helpForm.parentNode.insertBefore(successDiv, helpForm);

    // Remove success message after 5 seconds
    setTimeout(function () {
      successDiv.remove();
    }, 5000);
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
});
