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

  // Check if the help form exists on the page
  if (helpForm) {
    helpForm.addEventListener("submit", function (event) {
      // Prevent the form from submitting by default
      event.preventDefault();

      // Store each input field in a variable using getElementById
      const nameInput = document.getElementById("name");
      const emailInput = document.getElementById("email");
      const phoneInput = document.getElementById("phone");
      const messageInput = document.getElementById("message");

      // Here we are initializing a variable to track if the form is valid
      let isValid = true;

      // Conditional uses the function validateName to check if the name is valid.
      if (!validateName(nameInput.value)) {
        alert("Name should contain only letters and spaces");
        isValid = false; // If the name is not valid, we set isValid to false
      }

      // Conditional uses the function validatePhone to check if the phone is valid, with 9 or 10 digits
      if (!validatePhone(phoneInput.value)) {
        alert("Phone number must contain 9 or 10 digits");
        isValid = false; // If the phone number is not valid, we set isValid to false
      }

      // Conditional uses a simple check to see if the email is empty
      if (emailInput.value.trim() === "") {
        alert("Email cannot be empty");
        isValid = false; // If the email is empty, we set isValid to false
      }

      // Conditional uses a simple check to see if the message is empty
      if (messageInput.value.trim() === "") {
        alert("Message cannot be empty");
        isValid = false; // If the message is empty, we set isValid to false
      }

      // If all validations pass, show success message and reset form
      if (isValid) {
        alert(
          "Your request has been submitted successfully! We will contact you soon."
        );
        helpForm.reset(); // Reset the form fields to their initial state
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
