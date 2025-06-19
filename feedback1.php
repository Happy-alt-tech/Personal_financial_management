<?php
session_start(); // Session start karna zaroori hai
if (!isset($_SESSION['name'])) {
    echo "<script>alert('Please log in first!'); window.location.href='login.php';</script>";
    exit();
}
$username = htmlspecialchars($_SESSION['name']); // Securely fetching user name
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        body {
            font-family: "montserrat-regular";
            margin: 0;
            padding: 0;
            background-image: url("http://localhost/PHP/p5_converted.jpg");
            background-attachment: fixed;
            background-size: 100% 100%;
        }
        html {
            scroll-behavior: smooth;
        }
        body::-webkit-scrollbar {
            display: block;
            width: 8px;
            background: #95c11e;
        }
        body::-webkit-scrollbar-thumb {
            background-color: #fff;
            border-radius: 50px;
        }
        body {
            overflow-x: hidden;
        }
        .form-container {
            width: 40%;
            margin: 5% auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 8px rgba(69, 235, 4, 0.1);
            border-radius: 8px;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
            background: red;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .close-btn:hover {
            background: darkred;
        }
        .form-header {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #60fa01;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #000000;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 95%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        .form-group textarea {
            height: 100px;
            resize: none;
        }
        .form-group button {
            background-color: #6bf700;
            color: rgb(0, 0, 0);
            padding: 0.8rem 1.2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-left: 230px;
        }
        .form-group button:hover {
            height: 50px;
            width: 200px;
            background-color: #56801f;
            transition: 500ms;
            color: white;
            box-shadow: 2px 2px 8px 4px rgb(171, 215, 149);
        }
        .form-footer {
            text-align: center;
            margin-top: 1rem;
            color: #000000;
        }
        #Rating {
            height: 40px;
            width: 160px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Close Button -->
        <button class="close-btn" onclick="window.location.href='main.html'">X</button>

        <form id="feedbackForm" action="feedback.php" method="POST">
            <div class="form-header">Feedback Form</div>

            <!-- Name (Auto-filled and Read-Only) -->
            <div class="form-group">
                <label for="name">User - Name</label>
                <input type="text" id="name" name="name" value="<?php echo $username; ?>" readonly>
            </div>

            <!-- Feedback Text -->
            <div class="form-group">
                <label for="Feedback_Text">Your Feedback</label>
                <textarea id="Feedback_Text" name="feedback_text" placeholder="Write your feedback..." required></textarea>
            </div>

            <!-- Rating (Dropdown with Labels) -->
            <div class="form-group">
                <label for="Rating">Rating</label>
                <select id="Rating" name="rating" required>
                    <option value="5">Excellent</option>
                    <option value="4">Very Good</option>
                    <option value="3">Good</option>
                    <option value="2">Fair</option>
                    <option value="1">Poor</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit">Submit Feedback</button>
            </div>
        </form>
        <div class="form-footer">
            Thank you for your valuable feedback!
        </div>
    </div>
</body>
</html>
