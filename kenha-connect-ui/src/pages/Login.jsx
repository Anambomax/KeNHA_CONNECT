import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import '../styles/UnifiedLayout.css';

export default function Login() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    const res = await fetch('http://localhost/PROJECTKeNHA/backend/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password }),
    });
    const data = await res.json();
    if (data.status === 'success') {
      localStorage.setItem('user', JSON.stringify(data.user));
      navigate('/home');
    } else {
      alert(data.message);
    }
  };

  return (
    <div className="page-wrapper">
      <form className="glass-card" onSubmit={handleLogin}>
        <h2>Login</h2>
        <input
          type="email"
          placeholder="Email address"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />
        <input
          type="password"
          placeholder="Enter password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />
        <button type="submit">Log In</button>
      </form>
    </div>
  );
}
