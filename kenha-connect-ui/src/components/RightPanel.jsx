// src/components/RightPanel.jsx
export default function RightPanel() {
  return (
    <div className="w-1/5 h-screen fixed right-0 top-0 bg-[#F5F8FA] text-[#034078] p-5 overflow-y-scroll shadow-inner">
      <h3 className="font-bold text-xl mb-4 border-b border-[#1282A2] pb-2">Public Updates</h3>
      <ul className="space-y-4 text-sm">
        <li className="bg-white p-3 rounded-xl shadow-sm">
          ✔ Potholes filled – Nairobi
        </li>
        <li className="bg-white p-3 rounded-xl shadow-sm">
          ✔ Traffic cleared – Mombasa Rd
        </li>
        <li className="bg-white p-3 rounded-xl shadow-sm">
          ✔ Road repaired – Thika Superhighway
        </li>
      </ul>
    </div>
  );
}
