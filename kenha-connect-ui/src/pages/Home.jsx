import { useState } from "react";

export default function Home() {
  const [incidents, setIncidents] = useState([
    {
      id: 1,
      user: "Jane Doe",
      time: "5 mins ago",
      location: "Thika Road",
      description: "Pothole causing traffic near Safari Park.",
      image: "/images/pothole.jpg", // Optional image
      likes: 3,
      comments: ["Seen it too!", "Needs fixing ASAP."]
    },
    {
      id: 2,
      user: "John Mwangi",
      time: "30 mins ago",
      location: "Lang'ata Road",
      description: "Broken streetlight near T-Mall.",
      image: "",
      likes: 1,
      comments: []
    }
  ]);

  const handleLike = (id) => {
    setIncidents(prev =>
      prev.map(post =>
        post.id === id ? { ...post, likes: post.likes + 1 } : post
      )
    );
  };

  const handleAddComment = (id, text) => {
    if (!text) return;
    setIncidents(prev =>
      prev.map(post =>
        post.id === id
          ? { ...post, comments: [...post.comments, text] }
          : post
      )
    );
  };

  return (
    <div style={{
      background: "linear-gradient(to right, #0f2027, #203a43, #2c5364)",
      minHeight: "100vh",
      padding: "20px",
      color: "#fff"
    }}>
      <h2 style={{ textAlign: "center", marginBottom: "30px" }}>Reported Incidents</h2>
      {incidents.map(post => (
        <div
          key={post.id}
          style={{
            background: "rgba(255, 255, 255, 0.1)",
            backdropFilter: "blur(10px)",
            marginBottom: "30px",
            padding: "20px",
            borderRadius: "12px",
            boxShadow: "0 0 10px rgba(0,0,0,0.3)"
          }}
        >
          <h4>{post.user} - <small>{post.time}</small></h4>
          <p style={{ fontWeight: "bold", margin: "5px 0" }}>{post.location}</p>
          <p>{post.description}</p>
          {post.image && (
            <img src={post.image} alt="incident" style={{ width: "100%", maxHeight: "200px", borderRadius: "8px" }} />
          )}
          <div style={{ marginTop: "10px" }}>
            <button
              onClick={() => handleLike(post.id)}
              style={{
                marginRight: "10px",
                background: "#4caf50",
                color: "#fff",
                padding: "5px 15px",
                borderRadius: "5px",
                border: "none",
                cursor: "pointer"
              }}
            >
              👍 React ({post.likes})
            </button>
            <details>
              <summary style={{ cursor: "pointer", color: "#03a9f4" }}>💬 Comments ({post.comments.length})</summary>
              <ul style={{ listStyle: "none", paddingLeft: "0", marginTop: "10px" }}>
                {post.comments.map((c, i) => (
                  <li key={i} style={{ marginBottom: "5px" }}>• {c}</li>
                ))}
              </ul>
              <form
                onSubmit={e => {
                  e.preventDefault();
                  const comment = e.target.elements.comment.value;
                  handleAddComment(post.id, comment);
                  e.target.reset();
                }}
              >
                <input
                  name="comment"
                  placeholder="Add a comment"
                  style={{
                    width: "80%",
                    padding: "5px",
                    borderRadius: "5px",
                    border: "none",
                    marginRight: "10px"
                  }}
                />
                <button type="submit" style={{
                  background: "#03a9f4",
                  border: "none",
                  padding: "5px 10px",
                  color: "#fff",
                  borderRadius: "5px"
                }}>Post</button>
              </form>
            </details>
          </div>
        </div>
      ))}
    </div>
  );
}
