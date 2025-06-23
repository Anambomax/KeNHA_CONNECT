import React from "react";

const ProfileCard = () => {
  const user = JSON.parse(localStorage.getItem("user"));

  const handleLogout = () => {
    localStorage.removeItem("user");
    window.location.href = "/";
  };

  return (
    <div
      style={{
        background: "#fff",
        borderRadius: "12px",
        boxShadow: "0 4px 12px rgba(0, 0, 0, 0.1)",
        padding: "25px",
        textAlign: "center"
      }}
    >
      <h5 style={{ color: "#34495e", marginBottom: "20px" }}>👤 Profile Info</h5>
      <p><strong>{user?.name}</strong></p>
      <p className="mb-1">{user?.email}</p>
      <p className="mb-1">📍 {user?.county}</p>
      <p className="mb-3">📞 {user?.phone}</p>
      <button onClick={handleLogout} className="btn btn-outline-danger w-100">
        🚪 Logout
      </button>
    </div>
  );
};

export default ProfileCard;
