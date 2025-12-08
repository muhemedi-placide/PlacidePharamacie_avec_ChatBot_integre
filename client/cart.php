<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier — PHARMA Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: Inter, sans-serif; padding-top: 70px; }
        .cart-item img { height: 80px; object-fit: contain; }
        .cart-item input { max-width: 70px; text-align: center; }
        .cart-summary { font-weight: 700; font-size: 1.2rem; }
        .empty-cart { text-align: center; padding: 50px 0; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4">Votre Panier <a href="http://localhost/placidePharmancie/client/header.php" style="font-size: 12px; color: black;">Retour ou continue l'ajout</a> </h2>
    <div id="cartContainer"></div>
</div>

<script>
    function loadCart() {
        const cartContainer = document.getElementById('cartContainer');
        const cart = JSON.parse(localStorage.getItem('pharmacyCart') || '[]');

        if (!cart.length) {
            cartContainer.innerHTML = `<div class="empty-cart alert alert-info">Commande envoiée. <a href="http://localhost/placidePharmancie/client/header.php">Retournez à l\'accueil</a></div>`;
            return;
        }

        let html = `
            <table class="table table-bordered bg-white shadow-sm">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
        `;

        let grandTotal = 0;
        cart.forEach(item => {
            const total = (item.sellingPrice || 0) * (item.quantity || 0);
            grandTotal += total;

            html += `
                <tr class="cart-item">
                    <td>
                        <img src="${item.image}" alt="${item.name}" class="me-2">
                        ${item.name}
                    </td>
                    <td>${numberWithSpaces(item.sellingPrice)} FBu</td>
                    <td>
                        <input type="number" min="1" max="${item.maxQuantity || 9999}" value="${item.quantity}" onchange="updateQty(${item.id}, this.value)">
                    </td>
                    <td id="total-${item.id}">${numberWithSpaces(total)} FBu</td>
                    <td><button class="btn btn-danger btn-sm" onclick="removeItem(${item.id})">Supprimer</button></td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="cart-summary">Total : ${numberWithSpaces(grandTotal)} FBu</div>
                <button class="btn btn-success" onclick="checkout()">Passer la commande</button>
            </div>
        `;

        cartContainer.innerHTML = html;
    }

    function numberWithSpaces(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    function updateQty(id, qty) {
        let cart = JSON.parse(localStorage.getItem('pharmacyCart') || '[]');
        qty = parseInt(qty) || 1;

        cart = cart.map(item => {
            if (item.id === id) {
                if (item.maxQuantity && qty > item.maxQuantity) qty = item.maxQuantity;
                item.quantity = qty;
                const totalCell = document.getElementById(`total-${id}`);
                if (totalCell) totalCell.textContent = numberWithSpaces(item.sellingPrice * qty) + " FBu";
            }
            return item;
        });

        localStorage.setItem('pharmacyCart', JSON.stringify(cart));
        loadCart(); // recalculer le total
    }

    function removeItem(id) {
        let cart = JSON.parse(localStorage.getItem('pharmacyCart') || '[]');
        cart = cart.filter(item => item.id !== id);
        localStorage.setItem('pharmacyCart', JSON.stringify(cart));
        loadCart();
    }

    function checkout() {
        // alert("Commande simulée ! Vous pouvez maintenant implémenter le paiement ou la confirmation.");
        localStorage.removeItem('pharmacyCart');
        loadCart();
    }

    // initial load
    loadCart();
</script>

<script src="https://cdn.botpress.cloud/webchat/v3.4/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/12/08/13/20251208133820-AZY2SFW4.js" defer></script>


</body>
</html>
