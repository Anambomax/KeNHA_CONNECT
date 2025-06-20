import { useState } from 'react';
import { Link } from 'react-router-dom';

export default function Login() {
  const [form, setForm] = useState({ email: '', password: '' });
  const [error, setError] = useState('');

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!form.email || !form.password) {
      setError("Both fields are required.");
    } else {
      setError('');
      console.log("Logging in with:", form);
      // TODO: Add backend login call
    }
  };

  return (
    <div
      style={{
        background: "linear-gradient(to right, #0f2027, #203a43, #2c5364)", // SAME as register & landing
        minHeight: "100vh",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        padding: "30px",
        color: "#fff"
      }}
    >
      <div
        style={{
          background: "rgba(255, 255, 255, 0.1)", // Glassy form
          backdropFilter: "blur(10px)",
          padding: "40px",
          borderRadius: "12px",
          width: "100%",
          maxWidth: "500px",
          boxShadow: "0 0 15px rgba(0,0,0,0.3)"
        }}
      >
        <h2 style={{ textAlign: "center", marginBottom: "20px" }}>Login</h2>
        {error && <p style={{ color: "#ff5722", textAlign: "center" }}>{error}</p>}
        <form onSubmit={handleSubmit}>
          <div style={{ marginBottom: "20px" }}>
            <label>Email</label>
            <input
              type="email"
              name="email"
              value={form.email}
              onChange={handleChange}
              style={{
                width: "100%",
                padding: "10px",
                borderRadius: "5px",
                border: "none"
              }}
            />
          </div>
          <div style={{ marginBottom: "20px" }}>
            <label>Password</label>
            <input
              type="password"
              name="password"
              value={form.password}
              onChange={handleChange}
              style={{
                width: "100%",
                padding: "10px",
                borderRadius: "5px",
                border: "none"
              }}
            />
          </div>
          <button
            type="submit"
            style={{
              width: "100%",
              backgroundColor: "#03a9f4", // Same button color as Register
              color: "#fff",
              border: "none",
              padding: "10px",
              borderRadius: "5px",
              fontWeight: "bold"
            }}
          >
            Login
          </button>
          <p style={{ marginTop: "15px", textAlign: "center" }}>
            Don't have an account?{" "}
            <Link to="/register" style={{ color: "#4caf50" }}>Register</Link>
          </p>
        </form>
      </div>
    </div>
  );
}
