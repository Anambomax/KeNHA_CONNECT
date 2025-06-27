function showTab(tabId) {
  document.querySelectorAll('.tab-section').forEach(tab => {
    tab.classList.remove('active');
  });
  document.getElementById(tabId).classList.add('active');

  // Highlight active menu item
  document.querySelectorAll('.nav-menu li').forEach(li => {
    li.classList.remove('active');
  });
  const tabIndex = { home: 0, feed: 1, news: 2 };
  document.querySelectorAll('.nav-menu li')[tabIndex[tabId]].classList.add('active');
}
