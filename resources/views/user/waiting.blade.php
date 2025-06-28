<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Menunggu Pembayaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container text-center mt-5">
        <h2>Menunggu Verifikasi Pembayaran</h2>
        <p>Pembayaran Anda sedang diproses. Silakan tunggu...</p>
        <img src="https://cdn-icons-png.flaticon.com/512/189/189792.png" width="120">
    </div>

    <script>
        const orderId = localStorage.getItem('order_id');

        if (!orderId) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tidak ditemukan ID pesanan. Silakan ulangi pemesanan.',
            }).then(() => {
                window.location.href = '/';
            });
        }

        function checkPaymentStatus() {
            fetch(`/payment-status/${orderId}`)
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    if (data.status === 'paid') {
                        Swal.fire({
                            title: 'Pembayaran Dikonfirmasi!',
                            text: 'Admin telah mengonfirmasi pembayaran Anda.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            localStorage.removeItem('order_id');
                            window.location.href = '/';
                        });
                    }
                })
                .catch(err => console.error(err));
        }

        setInterval(checkPaymentStatus, 5000); // cek tiap 5 detik
    </script>
</body>

</html>