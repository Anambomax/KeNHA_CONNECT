import { useState } from "react";

export default function Register() {
  const [formData, setFormData] = useState({
    name: "", email: "", county: "", phone: "", password: "", confirmPassword: ""
  });

  const counties = ["Nairobi", "Mombasa", "Kisumu", "Nakuru", "Eldoret"];

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-100">
      <form className="bg-white p-8 rounded-xl shadow-md w-full max-w-md space-y-4">
        <h2 className="text-2xl font-bold text-center">Register</h2>
        <input type="text" placeholder="Name" className="w-full p-2 border rounded" />
        <input type="email" placeholder="Email" className="w-full p-2 border rounded" />
        <select className="w-full p-2 border rounded">
          <option value="">Select County</option>
          {counties.map((c, i) => <option key={i} value={c}>{c}</option>)}
        </select>
        <input type="tel" placeholder="Phone" className="w-full p-2 border rounded" />
        <input type="password" placeholder="Password" className="w-full p-2 border rounded" />
        <input type="password" placeholder="Confirm Password" className="w-full p-2 border rounded" />
        <button className="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Register</button>
      </form>
    </div>
  );
}
