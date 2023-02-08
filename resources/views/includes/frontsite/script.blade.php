<script src="https://cdn.tailwindcss.com/?plugins=forms"></script>

{{-- Swiper --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
      const swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 32,
        centeredSlides: true,
        autoplay: {
          delay: 8000,
        },
        breakpoints: {
          640: {
            slidesPerView: 1.5,
          },
          1024: {
            slidesPerView: 3,
          },
        },
      })
    })
  </script>