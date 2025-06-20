import { Link } from "react-router-dom";

export default function Landing() {
  const backgroundStyle = {
    backgroundImage: "url('/images/road-bg.jpg')",
    backgroundSize: "cover",
    backgroundPosition: "center",
    height: "100vh",
    color: "white",
    display: "flex",
    flexDirection: "column",
    justifyContent: "center",
    alignItems: "center",
    textShadow: "2px 2px 4px rgba(0,0,0,0.8)",
  };

  return (
    <div style={backgroundStyle}>
      <h1 style={{ fontSize: "3rem", marginBottom: "1rem" }}>Welcome to KeNHA_Connect</h1>
      <p style={{ fontSize: "1.5rem", marginBottom: "2rem", maxWidth: "600px", textAlign: "center" }}>
        Report road issues in real time and view resolved incidents across Kenya
      </p>
      <div>
        <Link
          to="/register"
          style={{
            backgroundColor: "#00bcd4",
            color: "white",
            padding: "10px 20px",
            borderRadius: "20px",
            textDecoration: "none",
            marginRight: "15px",
            fontWeight: "bold",
          }}
        >
          Register
        </Link>
        <Link
          to="/login"
          style={{
            backgroundColor: "#4caf50",
            color: "white",
            padding: "10px 20px",
            borderRadius: "20px",
            textDecoration: "none",
            fontWeight: "bold",
          }}
        >
          Login
        </Link>
      </div>
    </div>
  );
}
