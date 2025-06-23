import React from "react";
import ReportIncident from "../components/ReportIncident";
import PublicChannel from "../components/PublicChannel";
import ProfileCard from "../components/ProfileCard";

const Home = () => {
  return (
    <div style={{ background: "#f0f2f5", padding: "30px", minHeight: "100vh" }}>
      <div className="container">
        <div className="row gy-4">
          {/* Left Side: Main Feed */}
          <div className="col-lg-8">
            <div className="mb-4">
              <ReportIncident />
            </div>
            <div>
              <PublicChannel />
            </div>
          </div>

          {/* Right Side: Profile */}
          <div className="col-lg-4">
            <ProfileCard />
          </div>
        </div>
      </div>
    </div>
  );
};

export default Home;
