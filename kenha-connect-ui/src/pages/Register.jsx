import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

export default function Register() {
  const [form, setForm] = useState({ name: '', email: '', password: '', county: '' });
  const navigate = useNavigate();

  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async e => {
    e.preventDefault();
    const res = await fetch('http://localhost/PROJECTKeNHA/backend/register.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form)
    });
    const data = await res.json();
    if (data.status === 'success') {
      alert('Registration successful!');
      navigate('/login');
    } else {
      alert(data.message || 'Registration failed!');
    }
  };

  return (
    <form onSubmit={handleSubmit} style={{ padding: 20, maxWidth: 400, margin: '0 auto' }}>
      <h2>Register</h2>
      <input name="name" placeholder="Name" onChange={handleChange} required />
      <input name="email" type="email" placeholder="Email" onChange={handleChange} required />
      <input name="password" type="password" placeholder="Password" onChange={handleChange} required />
      <input name="county" placeholder="County" onChange={handleChange} required />
      <button type="submit">Register</button>
    </form>
  );
}
