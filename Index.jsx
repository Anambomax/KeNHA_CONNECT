import { Link } from "react-router-dom";

export default function Index() {
  return (
    <div className="h-screen flex flex-col items-center justify-center bg-gradient-to-r from-blue-500 to-green-500 text-white">
      <h1 className="text-5xl font-bold mb-4">Welcome to KeNHA_Connect</h1>
      <p className="mb-8 text-lg">Report and monitor road incidents in real-time</p>
      <div className="space-x-4">
        <Link to="/register" className="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-200">Register</Link>
        <Link to="/login" className="bg-white text-green-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-200">Login</Link>
      </div>
    </div>
  );
}
