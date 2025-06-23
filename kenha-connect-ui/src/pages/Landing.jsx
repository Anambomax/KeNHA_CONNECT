import React from "react";
import { Link } from "react-router-dom";

const Landing = () => {
  return (
    <div
      style={{
        background: "linear-gradient(to right, #6dd5fa, #2980b9)",
        minHeight: "100vh",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        padding: "20px"
      }}
    >
      <div
        style={{
          backgroundColor: "#fff",
          padding: "40px",
          borderRadius: "12px",
          boxShadow: "0 4px 12px rgba(0,0,0,0.2)",
          textAlign: "center",
          maxWidth: "500px",
          width: "100%"
        }}
      >
        <h1 style={{ color: "#2980b9", marginBottom: "20px" }}>Welcome to KeNHA Connect</h1>
        <p style={{ fontSize: "16px", color: "#333", marginBottom: "30px" }}>
          A smarter way to report, track, and resolve road issues across Kenya.
        </p>

        <Link to="/register" className="btn btn-primary m-2 w-100">Register</Link>
        <Link to="/login" className="btn btn-outline-primary m-2 w-100">Login</Link>
      </div>
    </div>
  );
};

export default Landing;
