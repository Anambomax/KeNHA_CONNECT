import { Link } from "react-router-dom";

export default function Landing() {
  return (
    <div style={{ textAlign: "center", marginTop: "50px" }}>
      <h1>Welcome to KeNHA_Connect</h1>
      <p>Report road incidents and view resolved issues</p>
      <Link to="/register">Register</Link> | <Link to="/login">Login</Link>
    </div>
  );
}
