import React from "react";
import ReportIncident from "../components/ReportIncident";
import PublicChannel from "../components/PublicChannel";
import ProfileCard from "../components/ProfileCard";

const Home = () => {
  return (
    <div
      style={{
        minHeight: "100vh",
        background: "linear-gradient(to right, #2980b9, #6dd5fa)",
        padding: "30px",
      }}
    >
      <div className="container">
        <h2
          className="text-white mb-4"
          style={{ fontWeight: "bold", textShadow: "1px 1px #000" }}
        >
          👋 Welcome to KeNHA Connect
        </h2>

        <div className="row">
          {/* Left Column: Report Incident */}
          <div className="col-md-6 mb-4">
            <ReportIncident />
          </div>

          {/* Right Column: Profile & Public */}
          <div className="col-md-6 mb-4">
            <ProfileCard />
            <div className="mt-4">
              <PublicChannel />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Home;
