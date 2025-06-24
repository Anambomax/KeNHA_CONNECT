import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate, Link } from 'react-router-dom';
import '../App.css';

const Login = () => {
  const navigate = useNavigate();

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [msg, setMsg] = useState('');

  const handleLogin = async (e) => {
    e.preventDefault();

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      setMsg("Please enter a valid email address.");
      return;
    }

    if (!email || !password) {
      setMsg("Please fill in all fields.");
      return;
    }

    try {
      const res = await axios.post('http://localhost/PROJECTKeNHA/backend/login.php', {
        email,
        password
      });

      if (res.data.success) {
        // Store user data in localStorage
        localStorage.setItem("user_id", res.data.id);
        localStorage.setItem("user_name", res.data.name);
        localStorage.setItem("user_email", res.data.email);
        localStorage.setItem("user_county", res.data.county);
        localStorage.setItem("user_role", res.data.role);

        navigate('/home');
      } else {
        setMsg(res.data.message || "Login failed.");
      }
    } catch (error) {
      console.error("Login error:", error);
      setMsg("An error occurred. Please try again.");
    }
  };

  return (
    <div className="auth-page">
      <div className="auth-container">
        <h2>Login to KeNHA Connect</h2>

        {msg && <p style={{ color: 'red' }}>{msg}</p>}

        <form onSubmit={handleLogin}>
          <input
            type="email"
            placeholder="Email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />

          <input
            type="password"
            placeholder="Password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />

          <button type="submit" className="btn primary">Login</button>
        </form>

        <p style={{ marginTop: '10px' }}>
          Don't have an account? <Link to="/register">Register</Link>
        </p>
      </div>
    </div>
  );
};

export default Login;
