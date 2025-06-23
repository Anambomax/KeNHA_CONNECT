import React, { useState } from 'react';

export default function ReportIncident() {
  const [description, setDescription] = useState('');
  const [location, setLocation] = useState('');
  const [image, setImage] = useState(null);
  const user = JSON.parse(localStorage.getItem('user'));

  const handleSubmit = (e) => {
    e.preventDefault();

    if (!user) {
      alert("You must be logged in to report.");
      return;
    }

    navigator.geolocation.getCurrentPosition(
      async (pos) => {
        const { latitude, longitude } = pos.coords;
        const formData = new FormData();
        formData.append('user_id', user.id);
        formData.append('description', description);
        formData.append('location', location);
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        if (image) formData.append('image', image);

        const res = await fetch('http://localhost/PROJECTKeNHA/backend/add_incident.php', {
          method: 'POST',
          body: formData
        });

        const data = await res.json();
        if (data.status === 'success') {
          alert("Incident reported!");
          setDescription('');
          setLocation('');
          setImage(null);
        } else {
          alert("Failed to report.");
        }
      },
      (err) => {
        alert("Location access is required to submit an incident.");
      }
    );
  };

  return (
    <form onSubmit={handleSubmit} style={{ maxWidth: 500, margin: '0 auto', padding: 20, background: '#f1f5f9', borderRadius: 8 }}>
      <h2>Report Incident</h2>
      <textarea
        value={description}
        onChange={(e) => setDescription(e.target.value)}
        placeholder="Describe the issue..."
        rows={4}
        required
        style={{ width: '100%', marginBottom: 10 }}
      />
      <input
        type="text"
        value={location}
        onChange={(e) => setLocation(e.target.value)}
        placeholder="Location name"
        required
        style={{ width: '100%', marginBottom: 10 }}
      />
      <input
        type="file"
        accept="image/*"
        capture="environment" // This uses the back camera
        onChange={(e) => setImage(e.target.files[0])}
        required
        style={{ marginBottom: 10 }}
      />
      <button type="submit" style={{ padding: 10, background: '#0f172a', color: '#fff', border: 'none', borderRadius: 4 }}>
        Submit
      </button>
    </form>
  );
}
