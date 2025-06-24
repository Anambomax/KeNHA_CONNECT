// src/components/Sidebar.jsx
import { FaHome, FaUser, FaSignOutAlt } from "react-icons/fa";

export default function Sidebar() {
  return (
    <div className="w-1/5 h-screen bg-gradient-to-b from-[#034078] to-[#1282A2] text-white p-6 fixed left-0 shadow-lg">
      <h2 className="text-2xl font-extrabold mb-10 tracking-wide">KeNHA Connect</h2>
      <ul className="space-y-6 text-lg">
        <li className="flex items-center gap-3 cursor-pointer hover:text-[#FDC500] transition">
          <FaHome /> Home
        </li>
        <li className="flex items-center gap-3 cursor-pointer hover:text-[#FDC500] transition">
          <FaUser /> Profile
        </li>
        <li className="flex items-center gap-3 cursor-pointer hover:text-[#FDC500] transition">
          <FaSignOutAlt /> Logout
        </li>
      </ul>
    </div>
  );
}
