// src/components/IncidentCard.jsx
import { FaComment, FaHeart } from "react-icons/fa";

export default function IncidentCard({ incident }) {
  return (
    <div className="bg-white shadow-md rounded-2xl p-4 mb-6 border border-[#e0e0e0]">
      <h3 className="font-bold text-lg text-[#034078]">{incident.title}</h3>
      <p className="text-sm text-gray-700 mt-1">{incident.description}</p>
      {incident.image && (
        <img src={incident.image} alt="incident" className="mt-3 rounded-xl" />
      )}
      <div className="flex justify-between mt-3 text-[#1282A2] text-sm">
        <span className="flex items-center gap-1"><FaComment /> 5</span>
        <span className="flex items-center gap-1"><FaHeart /> 10</span>
        <span>{new Date(incident.timestamp).toLocaleString()}</span>
      </div>
    </div>
  );
}
