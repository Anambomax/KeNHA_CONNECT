import { Link } from 'react-router-dom';

export default function Sidebar() {
  return (
    <div style={{
      width: '250px',
      background: '#0f172a',
      color: '#fff',
      padding: '30px 20px'
    }}>
      <h2>KeNHA Connect</h2>
      <nav style={{ marginTop: '30px', display: 'flex', flexDirection: 'column', gap: '15px' }}>
        <Link to="/" style={{ color: '#fff', textDecoration: 'none' }}>🏠 Home</Link>
        <Link to="/news" style={{ color: '#fff', textDecoration: 'none' }}>📢 Resolved Issues</Link>
        <button style={{
          marginTop: '30px',
          padding: '10px 15px',
          background: '#38bdf8',
          color: '#000',
          border: 'none',
          borderRadius: '6px',
          cursor: 'pointer'
        }}>
          ➕ Post Incident
        </button>
      </nav>
    </div>
  );
}
