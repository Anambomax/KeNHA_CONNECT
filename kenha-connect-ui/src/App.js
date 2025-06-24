import Sidebar from "./components/Sidebar";
import Feed from "./components/Feed";
import RightPanel from "./components/RightPanel";

const dummyIncidents = [
  {
    id: 1,
    title: "Truck overturned",
    description: "Blocked highway at 8:00AM",
    image: "",
    timestamp: Date.now(),
  },
  {
    id: 2,
    title: "Bridge crack",
    description: "Detected cracks near Nyali",
    image: "",
    timestamp: Date.now(),
  },
];

function App() {
  return (
    <div className="flex bg-[#F0F4F8] min-h-screen font-sans">
      <Sidebar />
      <Feed incidents={dummyIncidents} />
      <RightPanel />
    </div>
  );
}

export default App;
