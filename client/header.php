<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PHARMA Shop — Catalogue</title>

    <!-- Bootstrap CSS via CDN (v5.3) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Pour info : documentation Bootstrap recommande l’usage du CDN dans Quick start -->
    <!-- Voir docs Bootstrap v5.3 introduction / quick start. :contentReference[oaicite:0]{index=0} -->

    <style>
        :root {
            --success: #20750fff;
            --muted: #6c757d;
            --surface: #ffffff;
            --bg: #f8f9fa;
        }

        body {
            background: var(--bg);
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        /* HEADER */
        header {
            height: 60px;
            background: var(--surface);
            border-bottom: 1px solid #e6e6e6;
            z-index: 1000;
        }

        .nav-link-custom {
            padding: 8px 14px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #212529;
            text-decoration: none;
        }

        .nav-link-custom:hover {
            background: #f1f3f5;
            text-decoration: none;
        }

        .nav-link-custom.active {
            background: var(--success);
            color: #fff !important;
        }

        /* Mobile menu */
        #mobileMenu {
            position: fixed;
            top: 60px;
            right: 0;
            width: 280px;
            height: calc(100vh - 60px);
            background: var(--surface);
            border-left: 1px solid #e6e6e6;
            padding: 18px;
            display: none;
            overflow-y: auto;
            z-index: 2000;
        }

        #mobileOverlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            z-index: 1990;
        }

        /* Product card */
        .product-card img {
            height: 160px;
            object-fit: contain;
            background: #fff;
            padding: 10px;
        }

        .product-price {
            font-weight: 700;
        }

        .badge-out-of-stock {
            background: #ffc9c9;
            color: #8b1e1e;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 0.8rem;
        }

        /* Toast */
        .success-toast {
            position: fixed;
            bottom: 26px;
            right: 26px;
            background: #28a745;
            color: white;
            padding: 12px 16px;
            border-radius: 10px;
            display: none;
            box-shadow: 0 8px 20px rgba(16, 24, 40, 0.12);
            z-index: 2200;
            min-width: 220px;
        }

        /* small screens spacing for container below header */
        main.container {
            margin-top: 74px;
            padding-bottom: 60px;
        }

        @media (max-width: 575px) {
            .product-card img {
                height: 120px;
            }
        }
    </style>
</head>

<body class="role-customer">
    <!--
    Changer ici pour simuler un rôle différent :
    <body class="role-staff"> ou <body class="role-admin">
  -->

    <!-- HEADER -->
    <header class="fixed-top d-flex align-items-center">
        <nav class="container d-flex justify-content-between align-items-center">
            <a href="#" class="fw-bold fs-4 text-decoration-none">💊 PHARMA Shop</a>

            <!-- Desktop navigation (visible lg and up) -->
            <div class="d-none d-lg-flex align-items-center gap-2">
                <!-- Si tu veux afficher Catalogue ou autres selon rôle, ajoute les classes appropriées -->
                <!-- <a href="/product-catalog" class="nav-link-custom customer">Catalogue</a> -->
                <a href="/product-management" class="nav-link-custom staff admin">Gestion Produits</a>
                <a href="/sales-report" class="nav-link-custom admin">Rapports</a>
            </div>

            <!-- Right section -->
            <div class="d-flex align-items-center gap-2">
                <a href="cart.php" class="btn btn-outline-success d-none d-sm-inline-flex">🛒 Panier</a>
                <button class="btn btn-success d-none d-sm-inline-flex"><a href="http://localhost/placidePharmancie/index2.php" style="text-align: none; text-decoration: none; color: white;">Connexion</a></button>

                <!-- hamburger for mobile -->
                <button id="menuToggle" class="btn btn-light d-lg-none" aria-label="Ouvrir le menu">
                    ☰
                </button>
            </div>
        </nav>
    </header>

    <!-- mobile overlay + menu -->
    <div id="mobileOverlay" aria-hidden="true"></div>
    <aside id="mobileMenu" aria-hidden="true">
        <div class="border-bottom pb-3 mb-3">
            <a href="cart.php" class="btn btn-outline-success w-100 mb-2">🛒 Panier</a>
            <button class="btn btn-success w-100"><a href="http://localhost/placidePharmancie/index2.php">Connexion</a></button>
        </div>

        <!-- Tu peux réactiver ces liens si besoin -->
        <!-- <nav class="d-flex flex-column gap-2">
            <a href="/product-catalog" class="nav-link-custom customer staff admin">Catalogue</a>
            <a href="/product-management" class="nav-link-custom staff admin">Gestion Produits</a>
            <a href="/sales-report" class="nav-link-custom admin">Rapports</a>
        </nav> -->
    </aside>

    <!-- MAIN -->
    <main class="container">
        <!-- Title -->
        <div class="mb-4">
            <h2 class="fw-bold">Catalogue de Produits</h2>
            <p class="text-muted">Parcourez notre sélection de produits pharmaceutiques</p>
        </div>

        <div class="row">
            <!-- Sidebar filters -->
            <aside class="col-lg-3 col-md-4 mb-3">
                <div class="card p-3 shadow-sm">
                    <h5 class="fw-bold mb-3">Filtres</h5>

                    <div class="mb-3">
                        <label class="form-label">Recherche</label>
                        <input type="text" id="searchTerm" class="form-control" placeholder="Nom ou code barre">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <select id="categoryFilter" class="form-select">
                            <option value="">Toutes</option>
                            <option value="Antibiotique">Antibiotique</option>
                            <option value="Vitamine">Vitamine</option>
                            <option value="Douleur">Douleur</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Prix Min</label>
                            <input type="number" id="minPrice" class="form-control" placeholder="0">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Prix Max</label>
                            <input type="number" id="maxPrice" class="form-control" placeholder="9999">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Disponibilité</label>
                        <select id="availability" class="form-select">
                            <option value="all">Toutes</option>
                            <option value="available">Disponible</option>
                            <option value="unavailable">Non disponible</option>
                        </select>
                    </div>

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
            </aside>

            <!-- Product grid -->
            <section class="col-lg-9 col-md-8">
                <div class="row" id="productGrid"></div>
            </section>
        </div>
    </main>

    <!-- Toast notification -->
    <div class="success-toast" id="successToast" role="status" aria-live="polite">
        <div id="toastMessage">Produit ajouté au panier</div>
    </div>

    <!-- Bootstrap JS (bundle Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* ---------- Mobile menu handlers ---------- */
        const menuToggle = document.getElementById("menuToggle");
        const mobileMenu = document.getElementById("mobileMenu");
        const mobileOverlay = document.getElementById("mobileOverlay");

        menuToggle.addEventListener("click", () => {
            mobileMenu.style.display = "block";
            mobileOverlay.style.display = "block";
            document.body.style.overflow = "hidden";
            mobileMenu.setAttribute("aria-hidden", "false");
            mobileOverlay.setAttribute("aria-hidden", "false");
        });

        mobileOverlay.addEventListener("click", () => {
            mobileMenu.style.display = "none";
            mobileOverlay.style.display = "none";
            document.body.style.overflow = "auto";
            mobileMenu.setAttribute("aria-hidden", "true");
            mobileOverlay.setAttribute("aria-hidden", "true");
        });

        /* ---------- Role visibility ---------- */
        function applyRole() {
            // determine role from body class
            const role = document.body.classList.contains("role-admin") ? "admin" :
                document.body.classList.contains("role-staff") ? "staff" :
                "customer";

            // show/hide nav links based on classes
            document.querySelectorAll(".nav-link-custom").forEach(link => {
                if (!link.classList.contains(role)) link.style.display = "none";
                else link.style.display = "inline-flex";
            });

            // if you add mobile links later, hide them similarly
            document.querySelectorAll("#mobileMenu .nav-link-custom").forEach(link => {
                if (!link.classList.contains(role)) link.style.display = "none";
                else link.style.display = "flex";
            });
        }

        applyRole();

        /* ---------- Data containers ---------- */
        let initialProducts = []; // will be filled from API
        let filteredProducts = []; // after filtering

        /* ---------- Load products from API ---------- */
        async function loadProducts() {
            try {
                const response = await fetch("api/get_stock.php");
                const data = await response.json();

                // If an error key exists, log it
                if (data.error) {
                    console.error("API error:", data.error);
                }

                // ensure defaults and images
                data.forEach(p => {
                    if (!p.image) p.image = "https://www.shutterstock.com/image-photo/pharmaceutical-various-dosage-forms-on-260nw-2485895317.jpg";
                    // if no status in DB, infer from remainingQuantity
                    p.status = (p.remainingQuantity > 0 ? "Available" : "Unavailable");
                });

                initialProducts = data;
                filteredProducts = [...initialProducts];
                renderProducts();
            } catch (error) {
                console.error("Erreur de chargement :", error);
            }
        }

        loadProducts();

        /* ---------- Rendering ---------- */
        function renderProducts() {
            const grid = document.getElementById("productGrid");
            grid.innerHTML = "";

            if (!filteredProducts.length) {
                grid.innerHTML = `<div class="col-12"><div class="alert alert-info">Aucun produit trouvé.</div></div>`;
                return;
            }

            filteredProducts.forEach(product => {
                const isAvailable = product.remainingQuantity > 0 && product.status === "Available";

                const card = document.createElement("div");
                card.className = "col-md-4 mb-4";
                card.innerHTML = `
            <div class="card h-100 product-card shadow-sm">
                <img src="${product.image}" class="card-img-top" alt="${escapeHtml(product.name)}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-1">${escapeHtml(product.name)}</h5>
                    <p class="text-muted small mb-2">${escapeHtml(product.company)}</p>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="product-price">${numberWithSpaces(product.sellingPrice)} FBu</div>
                        ${isAvailable ? '' : '<span class="badge-out-of-stock">Rupture</span>'}
                    </div>
                    <div class="mt-auto">
                        <div class="input-group mb-2">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="decrementQty(${product.id})">-</button>
                            <input type="number" min="1" max="${product.remainingQuantity || 1}" value="1" id="qty-${product.id}" class="form-control form-control-sm text-center" style="max-width:78px">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="incrementQty(${product.id})">+</button>
                        </div>
                        <button class="btn btn-success w-100" onclick="addToCart(${product.id})" ${!isAvailable ? 'disabled' : ''}>
                            Ajouter au panier
                        </button>
                    </div>
                </div>
            </div>
        `;
                grid.appendChild(card);
            });
        }

        /* ---------- Helpers ---------- */
        function numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }

        function escapeHtml(unsafe) {
            return (unsafe + '').replace(/[&<"']/g, function(m) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '"': '&quot;',
                    "'": '&#039;'
                })[m];
            });
        }

        /* ---------- Quantity controls ---------- */
        function incrementQty(id) {
            const input = document.getElementById(`qty-${id}`);
            if (!input) return;
            const max = parseInt(input.max) || 9999;
            let v = parseInt(input.value) || 1;
            if (v < max) input.value = v + 1;
        }

        function decrementQty(id) {
            const input = document.getElementById(`qty-${id}`);
            if (!input) return;
            let v = parseInt(input.value) || 1;
            if (v > 1) input.value = v - 1;
        }

        /* ---------- Filtering ---------- */
        function filterProducts() {
            const search = (document.getElementById("searchTerm").value || "").trim().toLowerCase();
            const category = document.getElementById("categoryFilter").value;
            const minPrice = parseFloat(document.getElementById("minPrice").value || "");
            const maxPrice = parseFloat(document.getElementById("maxPrice").value || "");
            const availability = document.getElementById("availability").value;
            const sort = document.getElementById("sortBy").value;

            filteredProducts = initialProducts.filter(p => {
                if (search) {
                    const needle = search;
                    if (!(p.name?.toLowerCase().includes(needle) || (p.barcode && p.barcode.toLowerCase().includes(needle)))) {
                        return false;
                    }
                }

                if (category && category !== "") {
                    if (p.category !== category) return false;
                }

                if (!isNaN(minPrice)) {
                    if (p.sellingPrice < minPrice) return false;
                }

                if (!isNaN(maxPrice)) {
                    if (p.sellingPrice > maxPrice) return false;
                }

                if (availability === "available") {
                    if (!(p.remainingQuantity > 0 && p.status === "Available")) return false;
                } else if (availability === "unavailable") {
                    if (p.remainingQuantity > 0) return false;
                }

                return true;
            });

            // Sorting
            filteredProducts.sort((a, b) => {
                switch (sort) {
                    case "name-asc":
                        return a.name.localeCompare(b.name);
                    case "name-desc":
                        return b.name.localeCompare(a.name);
                    case "price-asc":
                        return a.sellingPrice - b.sellingPrice;
                    case "price-desc":
                        return b.sellingPrice - a.sellingPrice;
                    default:
                        return 0;
                }
            });

            renderProducts();
        }

        /* ---------- Clear filters ---------- */
        function clearFilters() {
            document.getElementById("searchTerm").value = "";
            document.getElementById("categoryFilter").value = "";
            document.getElementById("minPrice").value = "";
            document.getElementById("maxPrice").value = "";
            document.getElementById("availability").value = "all";
            document.getElementById("sortBy").value = "name-asc";
            filterProducts();
        }

        document.getElementById("clearFilters").addEventListener("click", clearFilters);

        // Hook inputs to filter
        document.querySelectorAll("#searchTerm, #categoryFilter, #minPrice, #maxPrice, #availability, #sortBy")
            .forEach(el => el.addEventListener("input", debounce(filterProducts, 180)));

        /* ---------- Add to cart (localStorage) ---------- */
        function addToCart(id) {
            const product = initialProducts.find(p => p.id === id);
            if (!product) return;

            const qtyInput = document.getElementById(`qty-${id}`);
            let qty = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
            if (qty < 1) qty = 1;
            if (product.remainingQuantity && qty > product.remainingQuantity) qty = product.remainingQuantity;

            try {
                const existing = localStorage.getItem("pharmacyCart");
                let cart = existing ? JSON.parse(existing) : [];

                const idx = cart.findIndex(i => i.id === id);
                if (idx > -1) {
                    cart[idx].quantity = (cart[idx].quantity || 0) + qty;
                } else {
                    cart.push({
                        id: product.id,
                        barcode: product.barcode || "",
                        name: product.name,
                        company: product.company || "",
                        sellingPrice: product.sellingPrice,
                        image: product.image || "",
                        quantity: qty,
                        maxQuantity: product.remainingQuantity || null
                    });
                }

                localStorage.setItem("pharmacyCart", JSON.stringify(cart));

                // dispatch a custom event to let other parts of app know
                window.dispatchEvent(new CustomEvent("cartUpdated", {
                    detail: {
                        count: cart.reduce((s, it) => s + (it.quantity || 0), 0)
                    }
                }));

                // show toast
                showToast(`${product.name} ajouté au panier (${qty})`);
            } catch (err) {
                console.error("Erreur ajout panier:", err);
                alert("Erreur lors de l'ajout au panier. Réessayez.");
            }
        }

        function showToast(message = "Produit ajouté au panier") {
            const toast = document.getElementById("successToast");
            const msg = document.getElementById("toastMessage");
            msg.textContent = message;
            toast.style.display = "block";
            toast.style.opacity = "1";

            setTimeout(() => {
                toast.style.opacity = "0";
                setTimeout(() => toast.style.display = "none", 400);
            }, 2000);
        }

        /* ---------- Utilities ---------- */
        function debounce(fn, wait) {
            let t;
            return function() {
                clearTimeout(t);
                t = setTimeout(() => fn.apply(this, arguments), wait);
            };
        }
    </script>
</body>
<script src="https://cdn.botpress.cloud/webchat/v3.4/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/12/08/13/20251208133820-AZY2SFW4.js" defer></script>



</html>