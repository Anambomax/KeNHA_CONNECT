import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom'; // ✅ useNavigate added
import '../App.css';

const Login = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const navigate = useNavigate(); // ✅ Initialize navigation

  const handleLogin = (e) => {
    e.preventDefault();

    // 🔐 Replace this with actual authentication later
    if (email && password) {
      // ✅ Simulate successful login and redirect to /home
      console.log('Login success!');
      navigate('/home');
    } else {
      alert("Invalid login credentials");
    }
  };

  return (
    <div className="auth-page">
      <div className="auth-container">
        <h2>Login to KeNHA Connect</h2>
        <form onSubmit={handleLogin}>
          <input
            type="email"
            placeholder="Email"
            required
            onChange={(e) => setEmail(e.target.value)}
          />
          <input
            type="password"
            placeholder="Password"
            required
            onChange={(e) => setPassword(e.target.value)}
          />
          <button type="submit" className="btn primary">Login</button>
        </form>
        <p>Don't have an account? <Link to="/register">Register</Link></p>
      </div>
    </div>
  );
};

export default Login;
