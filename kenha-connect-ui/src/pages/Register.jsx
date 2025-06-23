import React, { useState } from "react";
import { useNavigate } from "react-router-dom";

const Register = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    county: "",
    phone: "",
    password: "",
    confirmPassword: ""
  });

  const handleChange = (e) => {
    setFormData({...formData, [e.target.name]: e.target.value});
  };

  const handleRegister = async (e) => {
    e.preventDefault();

    if (formData.password !== formData.confirmPassword) {
      alert("Passwords do not match!");
      return;
    }

    try {
      const response = await fetch("http://localhost/PROJECTKeNHA/backend/register.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (data.success) {
        alert("Registration successful! Please login.");
        navigate("/login"); // ✅ redirect to login
      } else {
        alert("Registration failed: " + data.message);
      }
    } catch (error) {
      console.error("Registration error:", error);
      alert("An error occurred during registration.");
    }
  };

  return (
    <div
      style={{
        background: "linear-gradient(to right, #6dd5fa, #2980b9)",
        minHeight: "100vh",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        padding: "20px"
      }}
    >
      <form
        onSubmit={handleRegister}
        style={{
          backgroundColor: "#fff",
          padding: "30px",
          borderRadius: "12px",
          boxShadow: "0 4px 12px rgba(0,0,0,0.2)",
          width: "100%",
          maxWidth: "450px"
        }}
      >
        <h2 style={{ textAlign: "center", color: "#2980b9", marginBottom: "20px" }}>
          KeNHA Connect - Register
        </h2>

        <input type="text" name="name" placeholder="Full Name" className="form-control mb-3" value={formData.name} onChange={handleChange} required />
        <input type="email" name="email" placeholder="Email" className="form-control mb-3" value={formData.email} onChange={handleChange} required />
        
        <select name="county" className="form-control mb-3" value={formData.county} onChange={handleChange} required>
          <option value="">Select County</option>
          <option value="Nairobi">Nairobi</option>
          <option value="Mombasa">Mombasa</option>
          <option value="Kisumu">Kisumu</option>
          <option value="Nakuru">Nakuru</option>
        </select>

        <input type="tel" name="phone" placeholder="Phone Number" className="form-control mb-3" value={formData.phone} onChange={handleChange} required />
        <input type="password" name="password" placeholder="Password" className="form-control mb-3" value={formData.password} onChange={handleChange} required />
        <input type="password" name="confirmPassword" placeholder="Confirm Password" className="form-control mb-4" value={formData.confirmPassword} onChange={handleChange} required />
        
        <button type="submit" className="btn btn-primary w-100">Register</button>

        <p className="text-center mt-3">
          Already have an account? <a href="/login">Login here</a>
        </p>
      </form>
    </div>
  );
};

export default Register;
