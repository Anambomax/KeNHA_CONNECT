import React, { useState } from 'react';

export default function ReportIncident() {
  const [description, setDescription] = useState('');
  const [location, setLocation] = useState('');
  const [image, setImage] = useState(null);

  const user = JSON.parse(localStorage.getItem('user'));

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append('user_id', user?.id);
    formData.append('description', description);
    formData.append('location', location);
    if (image) formData.append('image', image);

    const res = await fetch('http://localhost/PROJECTKeNHA/backend/add_incident.php', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.status === 'success') {
      alert('Incident reported!');
      setDescription('');
      setLocation('');
      setImage(null);
    } else {
      alert('Error reporting incident');
    }
  };

  return (
    <form onSubmit={handleSubmit} style={{ padding: 20, maxWidth: 500, margin: '0 auto' }}>
      <h2>Report Incident</h2>
      <textarea value={description} onChange={e => setDescription(e.target.value)} placeholder="Incident details..." rows={4} required />
      <input type="text" value={location} onChange={e => setLocation(e.target.value)} placeholder="Location" required />
      <input type="file" accept="image/*" onChange={e => setImage(e.target.files[0])} />
      <button type="submit">Submit</button>
    </form>
  );
}
