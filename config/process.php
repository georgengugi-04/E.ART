<?php
// Ensure proper Content-Type header is set for JSON responses
header('Content-Type: application/json');

// Start session
session_start();

// Include database connection
include("connect.php");

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Artwork details
    $artwork_title = sanitize_input($_POST["artwork-title"]);
    $artwork_category = sanitize_input($_POST["artwork-category"]);
    $artwork_description = sanitize_input($_POST["artwork-description"]);
    $artwork_dimensions = sanitize_input($_POST["artwork-dimensions"]);
    $artwork_medium = sanitize_input($_POST["artwork-medium"]);
    $artwork_price = sanitize_input($_POST["artwork-price"]);
    $artwork_year = sanitize_input($_POST["artwork-year"]);
    $artwork_tags = sanitize_input($_POST["artwork-tags"]);

    // Artist information
    $artist_name = sanitize_input($_POST["artist-name"]);
    $artist_email = sanitize_input($_POST["artist-email"]);
    $artist_phone = sanitize_input($_POST["artist-phone"]);
    $artist_location = sanitize_input($_POST["artist-location"]);
    $artist_bio = sanitize_input($_POST["artist-bio"]);
    $artist_website = isset($_POST["artist-website"]) ? sanitize_input($_POST["artist-website"]) : "";

    // Initialize response array
    $response = array(
        "status" => "error",
        "message" => "An error occurred during submission"
    );

    // Validate required fields
    if (
        empty($artwork_title) || empty($artwork_category) || empty($artwork_description) || 
        empty($artwork_dimensions) || empty($artwork_medium) || empty($artwork_price) || 
        empty($artwork_year) || empty($artist_name) || empty($artist_email) || 
        empty($artist_phone) || empty($artist_location) || empty($artist_bio)
    ) {
        $response["message"] = "Please fill in all required fields";
    } else {
        // Validate email
        if (!filter_var($artist_email, FILTER_VALIDATE_EMAIL)) {
            $response["message"] = "Invalid email format";
        } else if (!is_numeric($artwork_price)) {
            $response["message"] = "Price must be a numeric value";
        } else if (!is_numeric($artwork_year) || $artwork_year < 1900 || $artwork_year > date("Y")) {
            $response["message"] = "Please enter a valid year";
        } else {
            // Proceed with DB operations

            // Check if artist exists
            $check_artist_sql = "SELECT artist_id FROM artists WHERE email = ?";
            if ($stmt = $conn->prepare($check_artist_sql)) {
                $stmt->bind_param("s", $artist_email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Artist exists, update info
                    $row = $result->fetch_assoc();
                    $artist_id = $row["artist_id"];

                    $update_artist_sql = "UPDATE artists SET full_name = ?, phone = ?, location = ?, bio = ?, website = ? WHERE artist_id = ?";
                    if ($update_stmt = $conn->prepare($update_artist_sql)) {
                        $update_stmt->bind_param("sssssi", $artist_name, $artist_phone, $artist_location, $artist_bio, $artist_website, $artist_id);
                        $update_stmt->execute();
                        $update_stmt->close();
                    }
                } else {
                    // Insert new artist
                    $insert_artist_sql = "INSERT INTO artists (full_name, email, phone, location, bio, website) VALUES (?, ?, ?, ?, ?, ?)";
                    if ($insert_stmt = $conn->prepare($insert_artist_sql)) {
                        $insert_stmt->bind_param("ssssss", $artist_name, $artist_email, $artist_phone, $artist_location, $artist_bio, $artist_website);
                        $insert_stmt->execute();
                        $artist_id = $insert_stmt->insert_id;
                        $insert_stmt->close();
                    }
                }

                $stmt->close();
            }

            // Insert artwork
            $insert_artwork_sql = "INSERT INTO artworks (title, category, description, dimensions, medium, price, year_created, tags, artist_id, submission_date, status)
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pending')";

            if ($artwork_stmt = $conn->prepare($insert_artwork_sql)) {
                $artwork_stmt->bind_param(
                    "sssssdssi",
                    $artwork_title,
                    $artwork_category,
                    $artwork_description,
                    $artwork_dimensions,
                    $artwork_medium,
                    $artwork_price,
                    $artwork_year,
                    $artwork_tags,
                    $artist_id
                );

                if ($artwork_stmt->execute()) {
                    $artwork_id = $artwork_stmt->insert_id;
                    $artwork_stmt->close();

                    // Set session data
                    $_SESSION["artwork_submission"] = array(
                        "artwork_id" => $artwork_id,
                        "artist_id" => $artist_id,
                        "title" => $artwork_title
                    );

                    $response["status"] = "success";
                    $response["message"] = "Artwork details saved successfully";
                    $response["redirect"] = "upload.php";
                    $response["artwork_id"] = $artwork_id;
                } else {
                    $response["message"] = "Error saving artwork: " . $conn->error;
                }
            } else {
                $response["message"] = "Database error: " . $conn->error;
            }
        }
    }

    // Return JSON response and exit to prevent additional output
    echo json_encode($response);
    exit;
}
?>