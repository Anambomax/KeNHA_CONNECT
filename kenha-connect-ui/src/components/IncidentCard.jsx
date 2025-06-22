export default function IncidentCard({ user, description, image, time }) {
  return (
    <div style={{
      background: '#fff',
      padding: '20px',
      borderRadius: '10px',
      boxShadow: '0 0 10px rgba(0,0,0,0.1)'
    }}>
      <p><strong>{user}</strong> reported:</p>
      <p>{description}</p>
      {image && <img src={image} alt="incident" style={{ width: '100%', borderRadius: '10px', marginTop: '10px' }} />}
      <p style={{ fontSize: '12px', color: '#555' }}>{time}</p>
      <div style={{ marginTop: '10px' }}>
        <button style={{ marginRight: '10px' }}>👍</button>
        <button style={{ marginRight: '10px' }}>🚫</button>
        <button>✅</button>
      </div>
    </div>
  );
}
