import React, { useState } from "react";

const ReportIncident = () => {
  const [description, setDescription] = useState("");
  const [image, setImage] = useState(null);
  const user = JSON.parse(localStorage.getItem("user"));

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("description", description);
    formData.append("image", image);
    formData.append("user_id", user?.id);

    try {
      const response = await fetch("http://localhost/PROJECTKeNHA/backend/add_incident.php", {
        method: "POST",
        body: formData
      });

      const data = await response.json();
      if (data.success) {
        alert("✅ Incident reported successfully!");
        setDescription("");
        setImage(null);
      } else {
        alert("❌ Failed to report: " + data.message);
      }
    } catch (error) {
      alert("🚫 Error uploading incident.");
    }
  };

  return (
    <div
      style={{
        background: "#fff",
        borderRadius: "12px",
        boxShadow: "0 4px 12px rgba(0, 0, 0, 0.1)",
        padding: "25px",
        marginBottom: "30px",
      }}
    >
      <h4 style={{ color: "#2980b9", marginBottom: "20px" }}>📝 Report an Incident</h4>
      <form onSubmit={handleSubmit}>
        <textarea
          className="form-control mb-3"
          placeholder="Describe the issue..."
          value={description}
          onChange={(e) => setDescription(e.target.value)}
          required
          rows="4"
        />
        <input
          type="file"
          className="form-control mb-3"
          accept="image/*"
          onChange={(e) => setImage(e.target.files[0])}
          required
        />
        <button type="submit" className="btn btn-primary w-100">📤 Submit</button>
      </form>
    </div>
  );
};

export default ReportIncident;
