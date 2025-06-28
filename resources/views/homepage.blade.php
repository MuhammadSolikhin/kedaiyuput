<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Kedai Yuput</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <!-- Favicons -->
  <link href="{{ asset('assets/homepage/img/favicon.png') }}" rel="icon" />
  <link href="{{ asset('assets/homepage/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap"
    rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/homepage/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/homepage/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/homepage/vendor/aos/aos.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/homepage/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/homepage/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="{{ asset('assets/homepage/css/main.css') }}" rel="stylesheet" />
  <style>
    #cart-count {
      min-width: 1.2rem;
      height: 1.2rem;
      font-size: 0.75rem;
      padding: 0.25em;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .cart-link {
      display: inline-block;
      position: relative;
    }

    .navmenu {
      padding: 0.5rem 1rem;
    }

    .navmenu ul li a {
      text-decoration: none;
      color: inherit;
    }

    .navmenu a {
      color: inherit;
      text-decoration: none;
    }

    .floating-order-btn {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 999;
      background-color: #dc3545;
      /* merah */
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 1rem;
      border-radius: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease-in-out;
    }

    .floating-order-btn:hover {
      background-color: #c82333;
    }

    .d-none {
      display: none !important;
    }
  </style>


</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">Kedai Yuput!</h1>
        <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu d-flex align-items-center justify-content-between px-3">

        <div class="d-flex align-items-center gap-3">
          <!-- Cart -->
          <a href="{{ route('homepage.cart') }}" class="cart-link position-relative">
            <i class="bi bi-cart" style="font-size: 1.4rem;"></i>
            <span id="cart-count"
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              0
            </span>
          </a>

          <!-- Login -->
          <a href="{{ route('login') }}">
            <i class="bi bi-box-arrow-in-right" style="font-size: 1.3rem;"></i>
          </a>

          <!-- Mobile Toggle (hamburger menu) -->
          <i class="mobile-nav-toggle d-xl-none bi bi-list" style="font-size: 1.5rem; cursor: pointer;"></i>
        </div>
      </nav>

    </div>
  </header>

  <main class="main">
    <!-- /Hero Section -->

    <!-- Menu Section -->
    <section id="menu" class="menu section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Our Menu</h2>
        <p>
          <span>Check Our</span>
          <span class="description-title">Menu From Kedai Yuput!</span>
        </p>
      </div>
      <!-- End Section Title -->

      <div class="container">
        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
          @foreach ($categories as $index => $category)
        <li class="nav-item">
        <a class="nav-link {{ $index === 0 ? 'active show' : '' }}" data-bs-toggle="tab"
          data-bs-target="#menu-{{ Str::slug($category->name) }}">
          <h4>{{ $category->name }}</h4>
        </a>
        </li>
      @endforeach
        </ul>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
          @foreach ($categories as $index => $category)
        <div class="tab-pane fade {{ $index === 0 ? 'active show' : '' }}" id="menu-{{ Str::slug($category->name) }}">
        <div class="tab-header text-center">
          <p>Menu</p>
          <h3>{{ $category->name }}</h3>
        </div>

        <div class="row gy-5">
          @forelse ($category->menus as $menu)
        <div class="col-lg-4 menu-item" data-id="{{ $menu->id }}">
        <a href="{{ asset('storage/' . $menu->image_url) }}" class="glightbox">
        <img src="{{ asset('storage/' . $menu->image_url) }}" class="menu-img img-fluid"
        alt="{{ $menu->name }}" />
        </a>
        <h4>{{ $menu->name }}</h4>
        <p class="price">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>

        <div class="quantity">
        <h5 class="subtitle">Jumlah</h5>
        <div class="form quantityCounter">
        <i class="icon btnQuantity minus" onclick="decreaseQuantity(this)">
        <img src="https://rafaelalucas.com/dailyui/12/assets/minus.svg" alt="Minus" />
        </i>
        <input class="inputQuantity" type="number" value="0" min="1" />
        <i class="icon btnQuantity plus" onclick="increaseQuantity(this)">
        <img src="https://rafaelalucas.com/dailyui/12/assets/plus.svg" alt="Plus" />
        </i>
        </div>
        </div>
        </div>
        @empty
        <p class="text-center">Belum ada menu di kategori ini.</p>
        @endforelse
        </div>
        </div>
      @endforeach
        </div>

      </div>
    </section>
    <!-- /Menu Section -->
  </main>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>
  <button id="floating-order-button" onclick="goToCheckout()" class="floating-order-btn d-none">
    Pesan Sekarang
  </button>
  <script>
    function increaseQuantity(el) {
      const container = el.closest(".menu-item");
      const qtyInput = container.querySelector(".inputQuantity");
      const nama = container.querySelector("h4").innerText;
      const hargaText = container.querySelector(".price").innerText;
      const harga = parseInt(hargaText.replace(/\D/g, "")); // ambil angka dari "Rp 7.000"
      const id = container.getAttribute("data-id");
      // Tambah jumlah di input
      let currentValue = parseInt(qtyInput.value);
      qtyInput.value = currentValue + 1;

      // Tambah ke localStorage
      addToCart(parseInt(id), nama, harga, 1);

      // Update badge
      updateCartCount();
    }

    function decreaseQuantity(el) {
      const container = el.closest(".menu-item");
      const qtyInput = container.querySelector(".inputQuantity");
      let currentValue = parseInt(qtyInput.value);
      if (currentValue >= 1) {
        qtyInput.value = currentValue - 1;

        // Kurangi 1 dari cart
        const nama = container.querySelector("h4").innerText;
        reduceFromCart(nama, 1);
        updateCartCount();
      }
    }

    function addToCart(id, nama, harga, jumlah) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      const index = cart.findIndex((item) => item.id === id);
      if (index !== -1) {
        cart[index].jumlah += jumlah;
      } else {
        cart.push({ id, nama, harga, jumlah });
      }

      localStorage.setItem("cart", JSON.stringify(cart));
    }

    function reduceFromCart(nama, jumlah) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      const index = cart.findIndex((item) => item.nama === nama);

      if (index !== -1) {
        cart[index].jumlah -= jumlah;
        if (cart[index].jumlah <= 0) {
          cart.splice(index, 1);
        }
      }

      localStorage.setItem("cart", JSON.stringify(cart));
    }

    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem("cart")) || [];
      const totalItem = cart.reduce((sum, item) => sum + item.jumlah, 0);

      const cartCount = document.getElementById("cart-count");
      if (cartCount) cartCount.innerText = totalItem;

      const orderButton = document.getElementById("floating-order-button");
      if (orderButton) {
        if (totalItem > 0) {
          orderButton.classList.remove("d-none");
        } else {
          orderButton.classList.add("d-none");
        }
      }
    }

    function goToCheckout() {
      window.location.href = "/cart"; // Ubah sesuai route kamu
    }


    // Inisialisasi count saat halaman dimuat
    document.addEventListener("DOMContentLoaded", updateCartCount);
  </script>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/homepage/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/homepage/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/homepage/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/homepage/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/homepage/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/homepage/js/main.js') }}"></script>
</body>

</html>