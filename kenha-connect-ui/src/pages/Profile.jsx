import React, { useEffect, useState } from 'react';
import Navbar from '../components/Navbar';
import '../App.css';
import axios from 'axios';

const Profile = () => {
  const [user, setUser] = useState(null);

  useEffect(() => {
    const user_id = localStorage.getItem("user_id");
    if (!user_id) return;

    axios.post("http://localhost/PROJECTKeNHA/backend/get_user.php", { user_id })
      .then(res => {
        setUser(res.data);
      })
      .catch(err => {
        console.error("Failed to fetch user:", err);
      });
  }, []);

  if (!user) return <div className="profile-page"><Navbar /><p>Loading...</p></div>;

  return (
    <div className="profile-page">
      <Navbar />
      <div className="profile-container">
        <div className="profile-header">
          <img src="https://via.placeholder.com/120x120.png?text=User" alt="Avatar" className="profile-avatar" />
          <div className="profile-details">
            <h2>{user.name}</h2>
            <p>{user.email}</p>
            <p><strong>County:</strong> {user.county}</p>
            <p><strong>Role:</strong> {user.role}</p>
          </div>
          <div className="profile-actions">
            <button className="btn secondary">Edit Profile</button>
            <button className="btn primary" onClick={() => {
              localStorage.clear();
              window.location.href = "/login";
            }}>Logout</button>
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
