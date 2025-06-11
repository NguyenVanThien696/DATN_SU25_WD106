document.addEventListener('DOMContentLoaded', function () {
  const colorRadios = document.querySelectorAll('.color-radio');
  const thumbnails = document.querySelectorAll('.thumbnail-variant');
  const mainImage = document.getElementById('main-image');

  colorRadios.forEach((input) => {
    input.closest('label').addEventListener('click', function () {
      const selectedColor = input.value;

      const matched = Array.from(thumbnails).find(img => img.dataset.color === selectedColor);
      if (matched) {
        mainImage.src = matched.dataset.image;
      }
    });
  });
});