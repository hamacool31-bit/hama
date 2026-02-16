<?php
session_start(); // یەکجار فقط

$conn = new mysqli("localhost", "root", "", "login");
if ($conn->connect_error)
  die("Database connection failed");

// Initialize cart session
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = [];

// Add to cart
if (isset($_POST['add_to_cart'])) {
  $id = $_POST['id'];
  if (!in_array($id, $_SESSION['cart'])) {
    $_SESSION['cart'][] = $id;
  }
  header("Location: cart.php"); // Redirect to cart page
  exit();
}

// Fetch products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ku">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mobile Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f1f3f6;
    }

    h2 {
      text-align: center;
      margin: 20px 0;
    }

    .products {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      padding: 10px;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, .1);
      padding: 15px;
      width: 250px;
      text-align: center;
      background: #fff;
    }

    .card img {
      width: 100%;
      height: 160px;
      object-fit: contain;
      border-radius: 10px;
    }

    .price {
      color: #16a34a;
      font-weight: bold;
      margin: 5px 0;
    }

    button {
      padding: 5px 10px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      opacity: 0.9;
    }

    .navbar {
      background: #111827;
    }

    .navbar-brand,
    .nav-link {
      color: #fff !important;
    }

    .search-box {
      border-radius: 30px;
    }

    .category {
      background: #fff;
      padding: 12px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, .08);
      cursor: pointer;
      font-weight: 600;
    }

    .category:hover {
      background: #e5e7eb;
    }
  </style>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="nav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="mobile.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">My Account</a></li>
        <li class="nav-item"><a class="nav-link" href="add_product.php">Add Product</a></li>
        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<body>

  <!-- Navbar -->

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">📱 MobileShop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item me-2">
            <a class="btn btn-success btn-sm fw-bold" href="add_product.php" target="_blank">
              <i class="fa fa-plus"></i> دانانی کاڵا
            </a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-light btn-sm fw-bold" href="edit.html" target="_blank">
              <i class="fa fa-user"></i> My Account
            </a>
          </li>
        </ul>

      </div>
    </div>
  </nav>
  <div class="slider-box" style="max-width:800px;margin:40px auto;border-radius:15px;overflow:hidden;">
    <div id="slider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-inner text-center">
        <div class="carousel-item active">
          <img src="reklam3.jpg" class="d-block w-100" style="height:350px;object-fit:cover;" alt="Slide 1">
        </div>
        <div class="carousel-item">
          <img src="reklam2.jpg" class="d-block w-100" style="height:350px;object-fit:cover;" alt="Slide 2">
        </div>
        <div class="carousel-item">
          <img src="reklam.jpg" class="d-block w-100" style="height:350px;object-fit:cover;" alt="Slide 3">
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
      </button>

      <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
      </button>

    </div>
  </div>

  <!-- Search -->
  <div class="container mt-3">
    <input id="searchInput" class="form-control search-box" placeholder="🔍 گەڕان بۆ مۆبایل..."
      onkeyup="searchProduct()">
  </div>

  <!-- Categories -->
  <div class="container mt-4">
    <div class="row g-3 text-center">
      <div class="col-3">
        <div class="category" onclick="filterProducts('all')">📦 هەموو</div>
      </div>
      <div class="col-3">
        <div class="category" onclick="filterProducts('apple')">🍎 Apple</div>
      </div>
      <div class="col-3">
        <div class="category" onclick="filterProducts('samsung')">📱 Samsung</div>
      </div>
      <div class="col-3">
        <div class="category" onclick="filterProducts('xiaomi')">🔥 Xiaomi</div>
      </div>
    </div>
  </div>
  <!-- سەبەتە -->
  <h2>Mobile Shop</h2>
  <div class="products">
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "
    <div class='card' data-category='" . $row['brand'] . "'>
      <img src='uploads/" . $row['image'] . "' alt=''>
      <h4>" . $row['brand'] . " " . $row['name'] . "</h4>
      <p>Storage: " . $row['storage'] . "</p>
      <p>Color: " . $row['color'] . "</p>
      <p class='price'>$" . $row['price'] . "</p>
      <form method='POST'>
        <input type='hidden' name='id' value='" . $row['id'] . "'>
        <button type='submit' name='add_to_cart'>🛒 Add to Cart</button>
      </form>
    </div>";
      }
    } else {
      echo "<p>No products found</p>";
    }
    ?>
  </div>

  <script>
    function filterProducts(cat) {
      document.querySelectorAll(".products .card").forEach(p => {
        p.style.display = (cat == 'all' || p.dataset.category.toLowerCase() == cat.toLowerCase()) ? "block" : "none";
      });
    }
    function searchProduct() {
      let val = document.getElementById("searchInput").value.toLowerCase();
      document.querySelectorAll(".products .card").forEach(p => {
        p.style.display = p.innerText.toLowerCase().includes(val) ? "block" : "none";
      });
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>