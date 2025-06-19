// public/js/search.js
document.addEventListener('DOMContentLoaded', function () {
    console.log("chạy");
  const toggleBtn = document.getElementById('searchToggle');
  const searchBox = document.getElementById('searchBox');

  if (toggleBtn && searchBox) {
    toggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      searchBox.classList.toggle('d-none');
    });
  } else {
    console.warn('Không tìm thấy phần tử searchToggle hoặc searchBox');
  }
});
