import React, { useState } from 'react';
import '../App.css';

const IncidentCard = ({ post }) => {
  const [likes, setLikes] = useState(post.likes || 0);

  const handleLike = () => setLikes(likes + 1);

  return (
    <div className="post-card">
      <div className="post-header">
        <strong>{post.author}</strong>
        <span className={`status ${post.status.toLowerCase()}`}>{post.status}</span>
      </div>
      <p>{post.description}</p>
      {post.image && <img src={post.image} alt="incident" className="post-img" />}
      <div className="reactions">
        <button onClick={handleLike} className="btn secondary">👍 {likes}</button>
        <button className="btn primary">💬 Comment</button>
      </div>
    </div>
  );
};

export default IncidentCard;
