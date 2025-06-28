const menuItems = [
    { name: 'Nasi Goreng', price: 15000 },
    { name: 'Mie Ayam', price: 12000 },
    { name: 'Sate Ayam', price: 25000 },
    { name: 'Es Teh', price: 5000 },
    { name: 'Es Jeruk', price: 7000 }
];

const orderItems = [];

function displayMenu(items) {
    const menuList = document.getElementById('menuList');

    items.forEach(item => {
        const menuItem = document.createElement('div');
        menuItem.className = 'menu-item';
        
        const itemName = document.createElement('h3');
        itemName.textContent = item.name;

        const itemPrice = document.createElement('span');
        itemPrice.textContent = `Rp ${item.price.toLocaleString('id-ID')}`;

        const orderButton = document.createElement('button');
        orderButton.textContent = 'Pesan';
        orderButton.onclick = () => addToOrder(item);

        menuItem.appendChild(itemName);
        menuItem.appendChild(itemPrice);
        menuItem.appendChild(orderButton);        
        menuList.appendChild(menuItem);
    });
}
 
function addToOrder(item) {
    const existingItem = orderItems.find(order => order.name === item.name);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        orderItems.push({ ...item, quantity: 1 });
    }
    displayOrder();
}

// Fungsi untuk menghapus item dari daftar pesanan
function removeFromOrder(item) {
    const itemIndex = orderItems.findIndex(order => order.name === item.name);
    if (itemIndex !== -1) {
        orderItems.splice(itemIndex, 1);
        displayOrder();
    }
}

// Fungsi untuk menampilkan daftar pesanan
function displayOrder() {
    const orderList = document.getElementById('orderList');
    orderList.innerHTML = ''; // Kosongkan daftar pesanan sebelum ditampilkan lagi

    orderItems.forEach(order => {
        const orderItem = document.createElement('div');
        orderItem.className = 'order-item';

        const orderName = document.createElement('h4');
        orderName.textContent = order.name;

        const orderQuantity = document.createElement('span');
        orderQuantity.className = 'quantity';
        orderQuantity.textContent = `x${order.quantity}`;

        const orderPrice = document.createElement('span');
        orderPrice.textContent = `Rp ${(order.price * order.quantity).toLocaleString('id-ID')}`;

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Hapus';
        deleteButton.onclick = () => removeFromOrder(order);

        orderItem.appendChild(orderName);
        orderItem.appendChild(orderQuantity);
        orderItem.appendChild(orderPrice);
        orderItem.appendChild(deleteButton);

        orderList.appendChild(orderItem);
    });
}
        // Fungsi untuk mencetak struk
        function printReceipt() {
            let receiptContent = 'Struk Pesanan\n';
            let total = 0;

            orderItems.forEach(order => {
                receiptContent += `${order.name} x${order.quantity} - Rp ${(order.price * order.quantity).toLocaleString('id-ID')}\n`;
                total += order.price * order.quantity;
            });

            receiptContent += `\nTotal: Rp ${total.toLocaleString('id-ID')}\n`;
            alert(receiptContent);
        }
        
displayMenu(menuItems);