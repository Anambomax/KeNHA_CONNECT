// src/components/Feed.jsx
import IncidentCard from "./IncidentCard";

export default function Feed({ incidents }) {
  return (
    <div className="w-3/5 ml-[20%] mr-[20%] py-6">
      {incidents.map((incident) => (
        <IncidentCard key={incident.id} incident={incident} />
      ))}
    </div>
  );
}
