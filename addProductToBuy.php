<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue Produits</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7f7f7;
        }
        .product-card img {
            height: 160px;
            object-fit: contain;
        }
        .success-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            display: none;
            z-index: 2000;
        }
    </style>

</head>
<body class="pt-4">

<div class="container">

    <!-- Title -->
    <div class="mb-4">
        <h2 class="fw-bold">Catalogue de Produits</h2>
        <p>Parcourez notre sélection de produits pharmaceutiques</p>
    </div>

    <div class="row">

        <!-- Sidebar Filters -->
        <div class="col-lg-3 col-md-4 mb-3">

            <div class="card p-3">
                <h5 class="fw-bold mb-3">Filtres</h5>

                <!-- Search -->
                <div class="mb-3">
                    <label class="form-label">Recherche</label>
                    <input type="text" id="searchTerm" class="form-control" placeholder="Nom ou code barre">
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label class="form-label">Catégorie</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">Toutes</option>
                        <option value="Antibiotique">Antibiotique</option>
                        <option value="Vitamine">Vitamine</option>
                        <option value="Douleur">Douleur</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div class="mb-3">
                    <label class="form-label">Prix Min</label>
                    <input type="number" id="minPrice" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Prix Max</label>
                    <input type="number" id="maxPrice" class="form-control">
                </div>

                <!-- Availability -->
                <div class="mb-3">
                    <label class="form-label">Disponibilité</label>
                    <select id="availability" class="form-select">
                        <option value="all">Toutes</option>
                        <option value="available">Disponible</option>
                        <option value="unavailable">Non disponible</option>
                    </select>
                </div>

                <!-- Sort -->
                <div class="mb-3">
                    <label class="form-label">Trier par</label>
                    <select id="sortBy" class="form-select">
                        <option value="name-asc">Nom (A → Z)</option>
                        <option value="name-desc">Nom (Z → A)</option>
                        <option value="price-asc">Prix croissant</option>
                        <option value="price-desc">Prix décroissant</option>
                    </select>
                </div>

                <button id="clearFilters" class="btn btn-secondary w-100 mt-2">Réinitialiser</button>
            </div>

        </div>

        <!-- Product grid -->
        <div class="col-lg-9 col-md-8">
            <div class="row" id="productGrid"></div>
        </div>

    </div>

</div>

<!-- Success Notification -->
<div class="success-toast" id="successToast">
    ✔ Produit ajouté au panier
    <div id="addedProductName"></div>
</div>

<script>
    /**
     *  SAMPLE DATA
     *  Replace this with your API or backend data
     */
    const initialProducts = [
        {
            id: 1,
            barcode: "A123",
            name: "Paracetamol",
            company: "PharmaPlus",
            sellingPrice: 2500,
            category: "Douleur",
            remainingQuantity: 15,
            registeredDate: "2024-03-11",
            expirationDate: "2026-01-01",
            image: "https://via.placeholder.com/150",
            status: "Available"
        },
        {
            id: 2,
            barcode: "B892",
            name: "Vitamine C",
            company: "VitaCorp",
            sellingPrice: 3500,
            category: "Vitamine",
            remainingQuantity: 0,
            registeredDate: "2024-01-10",
            expirationDate: "2025-08-01",
            image: "https://via.placeholder.com/150",
            status: "Unavailable"
        }
    ];

    let filteredProducts = [...initialProducts];

    function renderProducts() {
        const grid = document.getElementById("productGrid");
        grid.innerHTML = "";

        filteredProducts.forEach((product) => {
            const card = `
                <div class="col-md-4 mb-4">
                    <div class="card product-card p-2">
                        <img src="${product.image}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="text-muted">${product.company}</p>
                            <p class="fw-bold">${product.sellingPrice} FBU</p>

                            <button class="btn btn-primary w-100" onclick="addToCart(${product.id})">
                                Ajouter au panier
                            </button>
                        </div>
                    </div>
                </div>
            `;
            grid.innerHTML += card;
        });
    }

    function filterProducts() {
        const search = document.getElementById("searchTerm").value.toLowerCase();
        const category = document.getElementById("categoryFilter").value;
        const minPrice = document.getElementById("minPrice").value;
        const maxPrice = document.getElementById("maxPrice").value;
        const availability = document.getElementById("availability").value;
        const sort = document.getElementById("sortBy").value;

        filteredProducts = initialProducts.filter((p) => {
            if (search && !p.name.toLowerCase().includes(search) && !p.barcode.toLowerCase().includes(search))
                return false;

            if (category && p.category !== category)
                return false;

            if (minPrice && p.sellingPrice < parseFloat(minPrice))
                return false;

            if (maxPrice && p.sellingPrice > parseFloat(maxPrice))
                return false;

            if (availability === "available" && (p.remainingQuantity === 0 || p.status !== "Available"))
                return false;

            if (availability === "unavailable" && p.remainingQuantity > 0)
                return false;

            return true;
        });

        // Sorting
        filteredProducts.sort((a, b) => {
            switch (sort) {
                case "name-asc": return a.name.localeCompare(b.name);
                case "name-desc": return b.name.localeCompare(a.name);
                case "price-asc": return a.sellingPrice - b.sellingPrice;
                case "price-desc": return b.sellingPrice - a.sellingPrice;
                default: return 0;
            }
        });

        renderProducts();
    }

    function clearFilters() {
        document.getElementById("searchTerm").value = "";
        document.getElementById("categoryFilter").value = "";
        document.getElementById("minPrice").value = "";
        document.getElementById("maxPrice").value = "";
        document.getElementById("availability").value = "all";
        document.getElementById("sortBy").value = "name-asc";

        filterProducts();
    }

    function addToCart(id) {
        const product = initialProducts.find((p) => p.id === id);

        let cart = JSON.parse(localStorage.getItem("pharmacyCart") || "[]");

        let item = cart.find((c) => c.id === id);

        if (item) item.quantity++;
        else cart.push({ ...product, quantity: 1 });

        localStorage.setItem("pharmacyCart", JSON.stringify(cart));

        document.getElementById("addedProductName").innerText = product.name;
        const toast = document.getElementById("successToast");
        toast.style.display = "block";

        setTimeout(() => (toast.style.display = "none"), 2000);
    }

    // Listeners
    document.querySelectorAll("input, select").forEach((el) => {
        el.addEventListener("input", filterProducts);
    });

    document.getElementById("clearFilters").addEventListener("click", clearFilters);

    // Initial render
    renderProducts();
</script>

</body>
</html>
