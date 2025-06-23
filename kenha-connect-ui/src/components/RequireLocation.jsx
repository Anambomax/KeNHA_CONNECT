import React, { useEffect, useState } from 'react';

const RequireLocation = ({ children }) => {
  const [locationAllowed, setLocationAllowed] = useState(null);

  useEffect(() => {
    if (!navigator.geolocation) {
      alert("Geolocation is not supported by your browser.");
      setLocationAllowed(false);
      return;
    }

    navigator.geolocation.getCurrentPosition(
      position => {
        console.log('Location:', position.coords);
        setLocationAllowed(true);
      },
      error => {
        alert("Location access is required to use this app.");
        setLocationAllowed(false);
      }
    );
  }, []);

  if (locationAllowed === null) return <p>Checking location access...</p>;
  if (!locationAllowed) return <p>Location permission is required to continue.</p>;

  return children;
};

export default RequireLocation;
