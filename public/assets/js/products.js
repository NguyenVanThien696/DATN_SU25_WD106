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

  document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector('#quantity');
    const plus = document.querySelector('.increase');
    const minus = document.querySelector('.decrease');

    if (plus) {
      plus.addEventListener('click', () => {
        let val = parseInt(input.value) || 1;
        input.value = val + 1;
      });
    }

    if (minus) {
      minus.addEventListener('click', () => {
        let val = parseInt(input.value) || 1;
        input.value = Math.max(1, val - 1);
      });
    }
  });

