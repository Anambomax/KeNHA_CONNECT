import ResolvedCard from '../components/ResolvedCard';

const resolvedIssues = [
  {
    id: 1,
    issue: 'Thika pothole fixed',
    resolvedBy: 'KeNHA Road Unit',
    method: 'Filled with asphalt',
    date: '2025-06-18'
  },
  {
    id: 2,
    issue: 'Flooding cleared',
    resolvedBy: 'EMT Response Team',
    method: 'Opened drainage',
    date: '2025-06-17'
  }
];

export default function ResolvedNews() {
  return (
    <div style={{ flex: 1, padding: '30px', background: '#f8fafc' }}>
      <h2>Resolved Incidents</h2>
      <div style={{ marginTop: '20px', display: 'flex', flexDirection: 'column', gap: '20px' }}>
        {resolvedIssues.map(issue => (
          <ResolvedCard key={issue.id} {...issue} />
        ))}
      </div>
    </div>
  );
}
