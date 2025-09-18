<?php
// Database connection
$host = "localhost";
$user = "root";     // MySQL username (XAMPP default = root)
$pass = "";         // MySQL password (XAMPP default = empty)
$db   = "counselling_db";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $counsellor   = $_POST['counsellor']   ?? '';
    $studentName  = $_POST['studentName']  ?? '';
    $date         = $_POST['date']         ?? '';
    $time         = $_POST['time']         ?? '';

    if ($counsellor && $studentName && $date && $time) {
        $sql = "INSERT INTO bookings (counsellor_name, student_name, booking_date, booking_time) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $counsellor, $studentName, $date, $time);

        if ($stmt->execute()) {
            echo "<h2>✅ Booking Confirmed!</h2>";
            echo "<p><strong>Counsellor:</strong> $counsellor</p>";
            echo "<p><strong>Your Name:</strong> $studentName</p>";
            echo "<p><strong>Date:</strong> $date</p>";
            echo "<p><strong>Time:</strong> $time</p>";
            echo "<br><a href='home.html'>Back to Home</a>";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "⚠️ Missing required form fields!";
    }
} else {
    echo "⚠️ Please submit the form.";
}

$conn->close();
?>
