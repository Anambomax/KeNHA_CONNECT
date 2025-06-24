import React from 'react';
import Navbar from '../components/Navbar';
import '../App.css';

const user = {
  name: "Jane Mwangi",
  email: "jane@example.com",
  county: "Nairobi",
  role: "Citizen",
  avatar: "https://via.placeholder.com/120x120.png?text=JM"
};

const Profile = () => {
  return (
    <div className="profile-page">
      <Navbar />
      <div className="profile-container">
        <div className="profile-header">
          <img src={user.avatar} alt="Profile" className="profile-avatar" />
          <div className="profile-details">
            <h2>{user.name}</h2>
            <p>{user.email}</p>
            <p><strong>County:</strong> {user.county}</p>
            <p><strong>Role:</strong> {user.role}</p>
          </div>
          <div className="profile-actions">
            <button className="btn secondary">Edit Profile</button>
            <button className="btn primary" style={{ marginTop: '10px' }}>Logout</button>
          </div>
        </div>
        <hr />
        <h3 className="section-heading">Your Reported Incidents</h3>
        <p className="muted">Coming soon...</p>
      </div>
    </div>
  );
};

export default Profile;
