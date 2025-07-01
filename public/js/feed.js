<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.reaction-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const type = this.dataset.type;
      const feedbackId = this.dataset.feedback;

      fetch('api/add_reaction.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `feedback_id=${feedbackId}&type=${type}`
      }).then(() => loadReactions(feedbackId));
    });
  });

  document.querySelectorAll('.comment-form').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const feedbackId = this.dataset.feedback;
      const commentInput = this.querySelector('.comment-input');
      const comment = commentInput.value.trim();

      if (!comment) return;

      fetch('api/add_comment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `feedback_id=${feedbackId}&comment=${encodeURIComponent(comment)}`
      }).then(() => {
        commentInput.value = '';
        loadComments(feedbackId);
      });
    });
  });

  function loadReactions(feedbackId) {
    fetch(`api/get_reactions.php?feedback_id=${feedbackId}`)
      .then(res => res.json())
      .then(data => {
        const container = document.querySelector(`.reactions[data-feedback="${feedbackId}"]`);
        container.innerHTML = `👍 ${data.like} 👎 ${data.dislike} ⭐ ${data.star}`;
      });
  }

  function loadComments(feedbackId) {
    fetch(`api/get_comments.php?feedback_id=${feedbackId}`)
      .then(res => res.json())
      .then(comments => {
        const commentBox = document.querySelector(`.comments[data-feedback="${feedbackId}"]`);
        commentBox.innerHTML = comments.map(c => `
          <div class="comment-item"><strong>${c.full_name}</strong>: ${c.comment}</div>
        `).join('');
      });
  }

  // Load initial data
  document.querySelectorAll('.reactions').forEach(div => {
    loadReactions(div.dataset.feedback);
  });
  document.querySelectorAll('.comments').forEach(div => {
    loadComments(div.dataset.feedback);
  });
});
</script>
