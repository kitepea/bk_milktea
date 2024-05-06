<?php
require_once '../../includes/config.php';

// Retrieve form data
$category = $_POST['category'] ?? 'all';

// Initialize the SQL components
$whereClauses = [];
$params = [];
$types = '';

// Build the base SQL query
$sql = "SELECT p.id AS product_id, p.name AS product_name, p.price, p.image_url, c.name AS category_name, p.quantity_sold
        FROM Product p
        JOIN Categories c ON p.category_id = c.id";

// Filtering by category
if ($category !== 'all') {
    $whereClauses[] = "c.name = ?";
    $params[] = $category;
    $types .= 's'; // 's' for string
}


// Append conditions for category filtering
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(' AND ', $whereClauses);
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind parameters if there are any
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$allProductsHTML = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imageUrl = $row["image_url"] ?? '../img/default-img.jpg';  // Default image if not available
        $allProductsHTML .= '
        <div class="w-52 bg-white shadow-md rounded-xl transform transition duration-500 hover:scale-105 hover:shadow-xl">
            <a href="../detailProduct/detailProduct.php?id=' . $row["product_id"] . '">                
                <img src="' . $imageUrl . '" alt="' . htmlspecialchars($row["product_name"], ENT_QUOTES, 'UTF-8') . '" class="h-60 w-52 object-cover rounded-t-xl" />
                <div class="px-4 py-3 w-52">
                    <span class="text-gray-400 mr-3 uppercase text-xs">' . htmlspecialchars($row["category_name"], ENT_QUOTES, 'UTF-8') . '</span>
                    <p class="text-lg font-bold text-black truncate block capitalize">' . htmlspecialchars($row["product_name"], ENT_QUOTES, 'UTF-8') . '</p>
                    <div class="flex items-center">
                        <p class="text-lg font-semibold text-black cursor-auto my-3">$' . number_format($row["price"]) . '</p>
                    </div>
                </div>
            </a>
        </div>
        ';
    }
}

// Close statement and connection
$stmt->close();
$conn->close();

echo $allProductsHTML;
?>
