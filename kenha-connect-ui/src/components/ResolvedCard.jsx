export default function ResolvedCard({ issue, resolvedBy, method, date }) {
  return (
    <div style={{
      background: '#e2e8f0',
      padding: '20px',
      borderRadius: '10px'
    }}>
      <h4>{issue}</h4>
      <p><strong>Resolved By:</strong> {resolvedBy}</p>
      <p><strong>Method:</strong> {method}</p>
      <p><strong>Date:</strong> {date}</p>
    </div>
  );
}
