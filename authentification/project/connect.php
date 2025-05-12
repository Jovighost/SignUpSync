<?php
session_start(); // Start the session

// Check if form fields are set
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create a connection to the database
    $conn = new mysqli('localhost', 'root', "", 'authentification');

    // Check for connection errors
    if ($conn->connect_error) {
        echo "$conn->connect_error";
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Connection successful, proceed with sign-up logic

        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Email already exists. Please use a different email.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                // Set success message in session
                $_SESSION['success_message'] = "CONGRATULATIONS, YOU HAVE SUCCESSFULLY CREATED AN ACCOUNT.";
                
                // Redirect to sign-up page
                header("Location: signup.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    // Close the database connection
    $conn->close();
} else {
    echo "CONGRATULATIONS, YOU ARE LOGGED IN.";
}
?>