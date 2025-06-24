import React from 'react';
import Navbar from '../components/Navbar';
import IncidentCard from '../components/IncidentCard';
import { Link } from 'react-router-dom';

const samplePosts = [
  {
    id: 1,
    author: "Jane Mwangi",
    description: "Large pothole along Mbagathi Way causing traffic.",
    image: "https://via.placeholder.com/500x250",
    status: "Pending",
    likes: 8
  },
  {
    id: 2,
    author: "KeNHA Officer",
    description: "Pothole sealed on Thika Road near Safari Park. Resolved!",
    image: "https://via.placeholder.com/500x250",
    status: "Resolved",
    likes: 21
  }
];

const Home = () => {
  return (
    <div className="home-page">
      <Navbar />
      <div className="home-feed">
        <h2>KeNHA Public Channel</h2>
        {samplePosts.map(post => (
          <IncidentCard key={post.id} post={post} />
        ))}
      </div>

      {/* Floating + Report Button */}
      <Link to="/report" className="floating-report-btn">
        + Report
      </Link>
    </div>
  );
};

export default Home;
