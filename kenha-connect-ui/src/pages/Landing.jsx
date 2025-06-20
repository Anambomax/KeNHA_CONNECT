import { Link } from "react-router-dom";

export default function Landing() {
  return (
    <div
      style={{
        background: "linear-gradient(to right, #0f2027, #203a43, #2c5364)",
        minHeight: "100vh",
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        alignItems: "center",
        padding: "20px",
        color: "#fff",
      }}
    >
      <div
        style={{
          backgroundColor: "rgba(255, 255, 255, 0.1)",
          backdropFilter: "blur(10px)",
          padding: "40px",
          borderRadius: "20px",
          textAlign: "center",
          maxWidth: "600px",
          boxShadow: "0 0 10px rgba(0,0,0,0.3)",
        }}
      >
        <h1 style={{ fontSize: "3rem", marginBottom: "10px" }}>KeNHA_Connect</h1>
        <p style={{ fontSize: "1.3rem", marginBottom: "30px" }}>
          Report and follow up on road issues across Kenya
        </p>
        <Link
          to="/register"
          style={{
            backgroundColor: "#03a9f4",
            color: "#fff",
            padding: "10px 25px",
            borderRadius: "30px",
            marginRight: "15px",
            textDecoration: "none",
            fontWeight: "bold",
          }}
        >
          Register
        </Link>
        <Link
          to="/login"
          style={{
            backgroundColor: "#4caf50",
            color: "#fff",
            padding: "10px 25px",
            borderRadius: "30px",
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
