import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";

export default function Register() {
  const navigate = useNavigate();
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
      navigate('/home');
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
          {/* Name */}
          <div style={{ marginBottom: '15px' }}>
            <label>Name</label><br />
            <input
              type="text"
              name="name"
              value={form.name}
              onChange={handleChange}
              style={{ width: "100%", padding: "10px", borderRadius: "5px", border: "none" }}
            />
            {errors.name && <div style={{ color: "#f44336", fontSize: "12px" }}>{errors.name}</div>}
          </div>

          {/* Email */}
          <div style={{ marginBottom: '15px' }}>
            <label>Email</label><br />
            <input
              type="email"
              name="email"
              value={form.email}
              onChange={handleChange}
              style={{ width: "100%", padding: "10px", borderRadius: "5px", border: "none" }}
            />
            {errors.email && <div style={{ color: "#f44336", fontSize: "12px" }}>{errors.email}</div>}
          </div>

          {/* County Dropdown */}
          <div style={{ marginBottom: '15px' }}>
            <label>County</label><br />
            <select
              name="county"
              value={form.county}
              onChange={handleChange}
              style={{ width: "100%", padding: "10px", borderRadius: "5px", border: "none" }}
            >
              <option value="">-- Select County --</option>
              <option value="Baringo">Baringo</option>
              <option value="Bomet">Bomet</option>
              <option value="Bungoma">Bungoma</option>
              <option value="Busia">Busia</option>
              <option value="Elgeyo-Marakwet">Elgeyo-Marakwet</option>
              <option value="Embu">Embu</option>
              <option value="Garissa">Garissa</option>
              <option value="Homa Bay">Homa Bay</option>
              <option value="Isiolo">Isiolo</option>
              <option value="Kajiado">Kajiado</option>
              <option value="Kakamega">Kakamega</option>
              <option value="Kericho">Kericho</option>
              <option value="Kiambu">Kiambu</option>
              <option value="Kilifi">Kilifi</option>
              <option value="Kirinyaga">Kirinyaga</option>
              <option value="Kisii">Kisii</option>
              <option value="Kisumu">Kisumu</option>
              <option value="Kitui">Kitui</option>
              <option value="Kwale">Kwale</option>
              <option value="Laikipia">Laikipia</option>
              <option value="Lamu">Lamu</option>
              <option value="Machakos">Machakos</option>
              <option value="Makueni">Makueni</option>
              <option value="Mandera">Mandera</option>
              <option value="Marsabit">Marsabit</option>
              <option value="Meru">Meru</option>
              <option value="Migori">Migori</option>
              <option value="Mombasa">Mombasa</option>
              <option value="Murang'a">Murang'a</option>
              <option value="Nairobi">Nairobi</option>
              <option value="Nakuru">Nakuru</option>
              <option value="Nandi">Nandi</option>
              <option value="Narok">Narok</option>
              <option value="Nyamira">Nyamira</option>
              <option value="Nyandarua">Nyandarua</option>
              <option value="Nyeri">Nyeri</option>
              <option value="Samburu">Samburu</option>
              <option value="Siaya">Siaya</option>
              <option value="Taita-Taveta">Taita-Taveta</option>
              <option value="Tana River">Tana River</option>
              <option value="Tharaka-Nithi">Tharaka-Nithi</option>
              <option value="Trans Nzoia">Trans Nzoia</option>
              <option value="Turkana">Turkana</option>
              <option value="Uasin Gishu">Uasin Gishu</option>
              <option value="Vihiga">Vihiga</option>
              <option value="Wajir">Wajir</option>
              <option value="West Pokot">West Pokot</option>
            </select>
            {errors.county && <div style={{ color: "#f44336", fontSize: "12px" }}>{errors.county}</div>}
          </div>

          {/* Phone */}
          <div style={{ marginBottom: '15px' }}>
            <label>Phone</label><br />
            <input
              type="text"
              name="phone"
              value={form.phone}
              onChange={handleChange}
              style={{ width: "100%", padding: "10px", borderRadius: "5px", border: "none" }}
            />
            {errors.phone && <div style={{ color: "#f44336", fontSize: "12px" }}>{errors.phone}</div>}
          </div>

          {/* Password */}
          <div style={{ marginBottom: '15px' }}>
            <label>Password</label><br />
            <input
              type="password"
              name="password"
              value={form.password}
              onChange={handleChange}
              style={{ width: "100%", padding: "10px", borderRadius: "5px", border: "none" }}
            />
            {errors.password && <div style={{ color: "#f44336", fontSize: "12px" }}>{errors.password}</div>}
          </div>

          {/* Confirm Password */}
          <div style={{ marginBottom: '15px' }}>
            <label>Confirm Password</label><br />
            <input
              type="password"
              name="confirmPassword"
              value={form.confirmPassword}
              onChange={handleChange}
              style={{ width: "100%", padding: "10px", borderRadius: "5px", border: "none" }}
            />
            {errors.confirmPassword && <div style={{ color: "#f44336", fontSize: "12px" }}>{errors.confirmPassword}</div>}
          </div>

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
