import React from 'react';
import { Link } from 'react-router-dom';
import '../App.css';

const Navbar = () => {
  const toggleTheme = () => {
    document.body.classList.toggle("dark-theme");
  };

  return (
    <nav className="navbar">
      <div className="navbar-logo">KeNHA Connect</div>
      <ul className="navbar-links">
        <li><Link to="/home">Home</Link></li>
        <li><Link to="/report">Report</Link></li>
        <li><Link to="/profile">Profile</Link></li>
        <li><Link to="/login">Logout</Link></li>
      </ul>
      <button className="btn secondary" onClick={toggleTheme}>🌙</button>
    </nav>
  );
};

export default Navbar;
