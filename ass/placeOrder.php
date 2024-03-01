<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'items' parameter exists in the POST data
    if (isset($_POST["items"])) {
        // Extract the order items, address, and note from the POST data
        $items = $_POST["items"];
        $address = $_POST["address"];
        $note = $_POST["note"];

        // Connect to the MySQL database
        $servername = "localhost";
        $username = "root"; // Replace with your MySQL username
        $password = ""; // Replace with your MySQL password
        $dbname = "kinkin";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection is successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert each order item into the database
        foreach ($items as $item) {
            $itemName = $item["name"];
            $quantity = $item["quantity"];
            $price = $item["price"];
            $total = $item["total"];

            // Prepare SQL statement to insert order details into the 'orders' table
            $sql = "INSERT INTO orders (item_name, quantity, price, total, address, note) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siidss", $itemName, $quantity, $price, $total, $address, $note);
            $stmt->execute();
        }

        // Close the database connection
        $conn->close();

        // Send a success response
        echo "Order placed successfully!";
    } else {
        // If the 'items' parameter is not found, send an error response
        http_response_code(400);
        echo "Error: Items parameter not found in the request.";
    }
} else {
    // If the request method is not POST, send an error response
    http_response_code(405);
    echo "Error: Only POST requests are allowed.";
}
?>
