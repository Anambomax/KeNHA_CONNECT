import IncidentCard from '../components/IncidentCard';

const mockIncidents = [
  {
    id: 1,
    user: 'John Mwangi',
    description: 'Huge pothole on Thika Road near Garden City.',
    image: 'https://via.placeholder.com/400x200',
    time: '2 hours ago'
  },
  {
    id: 2,
    user: 'Mary Wanjiru',
    description: 'Flooding on Mombasa Road causing delays.',
    image: 'https://via.placeholder.com/400x200',
    time: '5 hours ago'
  }
];

export default function Home() {
  return (
    <div style={{ flex: 1, padding: '30px' }}>
      <h2>Latest Reported Incidents</h2>
      <div style={{ marginTop: '20px', display: 'flex', flexDirection: 'column', gap: '20px' }}>
        {mockIncidents.map(incident => (
          <IncidentCard key={incident.id} {...incident} />
        ))}
      </div>
    </div>
  );
}
