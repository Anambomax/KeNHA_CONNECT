import React from 'react';
import { Link } from 'react-router-dom';
import '../App.css';

const Landing = () => {
  return (
    <div className="landing-page">
      <div className="landing-container">
        <h1>Welcome to KeNHA Connect</h1>
        <p>Report road issues. Stay updated. Be part of the change.</p>
        <div className="btn-group">
          <Link to="/login" className="btn primary">Login</Link>
          <Link to="/register" className="btn secondary">Register</Link>
        </div>
      </div>
    </div>
  );
};

export default Landing;
