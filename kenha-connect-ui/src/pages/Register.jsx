import { useState } from 'react';
import { Link } from 'react-router-dom';

export default function Register() {
  const [form, setForm] = useState({
    name: '',
    email: '',
    county: '',
    phone: '',
    password: '',
    confirmPassword: ''
  });
  const [errors, setErrors] = useState({});

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const validate = () => {
    let temp = {};
    if (!form.name) temp.name = 'Name is required';
    if (!form.email.includes('@')) temp.email = 'Email is invalid';
    if (!form.county) temp.county = 'Select a county';
    if (!form.phone.match(/^\d{10}$/)) temp.phone = 'Phone must be 10 digits';
    if (form.password.length < 6) temp.password = 'Password too short';
    if (form.password !== form.confirmPassword) temp.confirmPassword = 'Passwords do not match';
    setErrors(temp);
    return Object.keys(temp).length === 0;
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (validate()) {
      console.log('Registered:', form);
    }
  };

  return (
    <div style={{
      background: "linear-gradient(to right, #0f2027, #203a43, #2c5364)",
      minHeight: "100vh",
      padding: "40px",
      color: "#fff",
    }}>
      <div style={{
        maxWidth: "600px",
        background: "#ffffff22",
        backdropFilter: "blur(10px)",
        margin: "auto",
        padding: "30px",
        borderRadius: "12px",
        boxShadow: "0 0 15px rgba(0,0,0,0.3)",
      }}>
        <h2 style={{ textAlign: "center", marginBottom: "20px" }}>Create Your Account</h2>
        <form onSubmit={handleSubmit}>
          {['name', 'email', 'county', 'phone', 'password', 'confirmPassword'].map((field, index) => (
            <div key={index} style={{ marginBottom: '15px' }}>
              <label>{field.charAt(0).toUpperCase() + field.slice(1)}</label><br />
              {field === 'county' ? (
                <select
                  name="county"
                  value={form.county}
                  onChange={handleChange}
                  style={{ width: "100%", padding: "10px", borderRadius: "5px", border: "none" }}
                >
                  <option value="">-- Select County --</option>
                  <option value="Nairobi">Nairobi</option>
                  <option value="Mombasa">Mombasa</option>
                  <option value="Kisumu">Kisumu</option>
                </select>
              ) : (
                <input
                  type={field.toLowerCase().includes('password') ? 'password' : 'text'}
                  name={field}
                  value={form[field]}
                  onChange={handleChange}
                  style={{ width: "100%", padding: "10px", borderRadius: "5px", border: "none" }}
                />
              )}
              {errors[field] && (
                <div style={{ color: "#f44336", fontSize: "12px" }}>{errors[field]}</div>
              )}
            </div>
          ))}
          <button
            type="submit"
            style={{
              background: "#03a9f4",
              padding: "10px 20px",
              border: "none",
              borderRadius: "5px",
              color: "#fff",
              fontWeight: "bold",
              width: "100%",
              marginTop: "10px"
            }}
          >
            Register
          </button>
          <p style={{ textAlign: "center", marginTop: "15px" }}>
            Already registered? <Link to="/login" style={{ color: "#4caf50" }}>Login here</Link>
          </p>
        </form>
      </div>
    </div>
  );
}
