<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Checkout</h2>

        <h5>Ringkasan Pesanan:</h5>
        <p><strong>Nomor Meja:</strong> <span id="summary-table-number">-</span></p>
        <p><strong>Metode Pembayaran:</strong> <span id="summary-payment-method">-</span></p>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="checkout-items-body"></tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <h4>Total: <span id="checkout-total">Rp 0</span></h4>
        </div>

        <input type="hidden" name="cart_data" id="cart_data">

        <button id="confirm-payment" class="btn btn-primary mt-3">Konfirmasi Pembayaran</button>
        <a href="{{ route('homepage.cart') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>

    <script>
        function getPaymentMethodName(method) {
            switch (method) {
                case 'cash': return 'Cash';
                case 'tf_bca': return 'Transfer ke BCA (4972001957) an/ Putri Andriani';
                case 'tf_bri': return 'Transfer ke BRI (379101015019501) an/ Ayu Afriani Yunita';
                case 'e_money': return 'Gopay (o83896057824) an/ Putri Andriani';
                default: return 'Tidak diketahui';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const tableNumber = localStorage.getItem('table_number');
            const paymentMethod = localStorage.getItem('payment_method');
            const tbody = document.getElementById('checkout-items-body');
            const totalDisplay = document.getElementById('checkout-total');
            const cartDataInput = document.getElementById('cart_data');

            document.getElementById('summary-table-number').textContent = tableNumber || 'Belum dipilih';
            document.getElementById('summary-payment-method').textContent = getPaymentMethodName(paymentMethod);

            tbody.innerHTML = '';
            let totalHarga = 0;

            cart.forEach(item => {
                const subtotal = item.harga * item.jumlah;
                totalHarga += subtotal;

                const row = `
                <tr>
                    <td>${item.nama}</td>
                    <td>Rp ${item.harga.toLocaleString()}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${subtotal.toLocaleString()}</td>
                </tr>
                `;
                tbody.innerHTML += row;
            });

            totalDisplay.textContent = 'Rp ' + totalHarga.toLocaleString();
            cartDataInput.value = JSON.stringify(cart);
        });


        document.getElementById('confirm-payment').addEventListener('click', function () {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const tableNumber = localStorage.getItem('table_number');
            const paymentMethod = localStorage.getItem('payment_method');
            const total = cart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);

            console.log({
                table_number: tableNumber,
                payment_method: paymentMethod,
                items: cart,
                total: total
            });

            fetch('/checkout/confirm', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    table_number: tableNumber,
                    payment_method: paymentMethod,
                    items: cart,
                    total: total
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Pembayaran berhasil dikonfirmasi!');
                        localStorage.removeItem('cart');
                        localStorage.removeItem('table_number');
                        localStorage.removeItem('payment_method');
                        localStorage.setItem('order_id', data.order_id);
                        window.location.href = '/checkout/waiting';;
                    } else {
                        alert('Gagal menyimpan data');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan saat konfirmasi pembayaran.');
                });
        });


    </script>
</body>

</html>