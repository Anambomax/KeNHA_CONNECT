import React from 'react';
import { useNavigate } from 'react-router-dom';
import '../styles/UnifiedLayout.css';

export default function Landing() {
  const navigate = useNavigate();

  return (
    <div className="page-wrapper">
      <div className="glass-card">
        <h2>Welcome to KeNHA Connect</h2>
        <p style={{ textAlign: 'center', marginBottom: '25px' }}>
          Report road issues, view updates, and help make our roads safer.
        </p>
        <button onClick={() => navigate('/login')} style={{ marginBottom: '10px' }}>
          Log In
        </button>
        <button onClick={() => navigate('/register')} style={{ backgroundColor: '#38bdf8' }}>
          Create Account
        </button>
      </div>
    </div>
  );
}
