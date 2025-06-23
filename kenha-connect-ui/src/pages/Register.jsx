import React, { useState } from "react";

const Register = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    county: "",
    phone: "",
    password: "",
    confirmPassword: ""
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleRegister = async (e) => {
    e.preventDefault();

    if (formData.password !== formData.confirmPassword) {
      alert("Passwords do not match!");
      return;
    }

    try {
      const res = await fetch("http://localhost/PROJECTKeNHA/backend/register.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(formData)
      });

      const data = await res.json();

      if (data.success) {
        alert("Registration successful! Redirecting to login...");
        window.location.href = "/login";
      } else {
        alert("Registration failed: " + data.message);
      }
    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred during registration.");
    }
  };

  return (
    <div className="container mt-5">
      <h2>Register</h2>
      <form onSubmit={handleRegister}>
        <input type="text" name="name" placeholder="Full Name" onChange={handleChange} required /><br />
        <input type="email" name="email" placeholder="Email" onChange={handleChange} required /><br />
        <input type="text" name="county" placeholder="County" onChange={handleChange} required /><br />
        <input type="text" name="phone" placeholder="Phone Number" onChange={handleChange} required /><br />
        <input type="password" name="password" placeholder="Password" onChange={handleChange} required /><br />
        <input type="password" name="confirmPassword" placeholder="Confirm Password" onChange={handleChange} required /><br />
        <button type="submit">Register</button>
      </form>
    </div>
  );
};

export default Register;
