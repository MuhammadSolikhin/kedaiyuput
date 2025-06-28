<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
  <div class="container mt-5">
    <h2 class="mb-4">Keranjang Belanja</h2>
    <div id="cart-items" class="table-responsive">
      <div class="mb-3">
        <label for="table_number" class="form-label">Nomor Meja</label>
        <select class="form-select" id="table_number" name="table_number" required>
          <option value="" disabled selected>Pilih Nomor Meja</option>
          @foreach($tables as $table)
          @if($table->is_active)
        <option value="{{ $table->table_number }}">{{ $table->table_number }}</option>
        @endif
      @endforeach
        </select>
      </div>
      <div class="mb-4">
        <label for="payment_method" class="form-label">Metode Pembayaran</label>
        <select class="form-select" id="payment_method" name="payment_method" required>
          <option value="" disabled selected>Pilih metode pembayaran</option>
          <option value="cash">Cash</option>
          <option value="tf_bca">Transfer ke Rekening BCA</option>
          <option value="tf_bri">Transfer ke Rekening BRI</option>
          <option value="e_money">E-Money (Gopay)</option>
        </select>
        <table class="table">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="cart-table-body"></tbody>
        </table>
      </div>
      <div class="d-flex justify-content-end">
        <h4>Total Belanja: <span id="cart-total">Rp 0</span></h4>
      </div>
      <a href="{{ route('homepage.checkout') }}" class="btn btn-success" onclick="savePaymentData()">Pembayaran</a>

    </div>

    <script>
      function savePaymentData() {
        const selectedMethod = document.getElementById('payment_method').value;
        localStorage.setItem('payment_method', selectedMethod);
      }

      document.getElementById('table_number').addEventListener('change', function () {
        const selectedTable = this.value;
        localStorage.setItem('table_number', selectedTable);
      });

      // Fungsi untuk mengambil data dari localStorage
      function loadCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const tbody = document.getElementById('cart-table-body');
        const totalDisplay = document.getElementById('cart-total');
        tbody.innerHTML = '';

        let totalHarga = 0;

        cart.forEach((item, index) => {
          const subtotal = item.harga * item.jumlah;
          totalHarga += subtotal;

          const row = `
          <tr>
            <td>${item.nama}</td>
            <td>Rp ${item.harga.toLocaleString()}</td>
            <td>
              <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-outline-secondary me-1" onclick="ubahJumlah(${index}, -1)">-</button>
                <span>${item.jumlah}</span>
                <button class="btn btn-sm btn-outline-secondary ms-1" onclick="ubahJumlah(${index}, 1)">+</button>
              </div>
            </td>
            <td>Rp ${subtotal.toLocaleString()}</td>
            <td>
              <button class="btn btn-sm btn-danger" onclick="hapusItem(${index})">Hapus</button>
            </td>
          </tr>
        `;
          tbody.innerHTML += row;
        });

        totalDisplay.textContent = 'Rp ' + totalHarga.toLocaleString();
      }
      

      // Fungsi untuk hapus item dari cart
      function hapusItem(index) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
      }

      //fungsi untuk menambah atau mengurangi jumlah di Keranjang
      function ubahJumlah(index, delta) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (!cart[index]) return;

        cart[index].jumlah += delta;
        if (cart[index].jumlah < 1) cart[index].jumlah = 1; // Minimal 1 item

        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
      }

      // Jalankan saat halaman dimuat
      document.addEventListener('DOMContentLoaded', loadCart);
    </script>
</body>

</html>