import React, { useEffect, useState } from "react";

const PublicChannel = () => {
  const [resolved, setResolved] = useState([]);

  useEffect(() => {
    fetch("http://localhost/PROJECTKeNHA/backend/public_channel.php")
      .then(res => res.json())
      .then(data => setResolved(data.reports || []));
  }, []);

  return (
    <div
      style={{
        background: "#fff",
        borderRadius: "12px",
        boxShadow: "0 4px 12px rgba(0, 0, 0, 0.1)",
        padding: "25px",
      }}
    >
      <h4 style={{ color: "#27ae60", marginBottom: "20px" }}>📢 Public Channel (Resolved)</h4>
      {resolved.length === 0 ? (
        <p className="text-muted">No resolved issues yet.</p>
      ) : (
        resolved.map((item, i) => (
          <div
            key={i}
            style={{
              background: "#f8f9fa",
              padding: "15px",
              borderRadius: "8px",
              marginBottom: "20px",
              border: "1px solid #dee2e6"
            }}
          >
            <img
              src={`http://localhost/PROJECTKeNHA/uploads/${item.image}`}
              alt="incident"
              className="img-fluid rounded mb-2"
              style={{ maxHeight: "220px", objectFit: "cover" }}
            />
            <p><strong>Description:</strong> {item.description}</p>
            <small className="text-muted">
              ✅ Resolved by <strong>{item.resolved_by}</strong> on {item.resolved_at}
            </small>
          </div>
        ))
      )}
    </div>
  );
};

export default PublicChannel;
