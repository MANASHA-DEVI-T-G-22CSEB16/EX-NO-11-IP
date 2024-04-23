<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
</head>
<body>
    <?php
    $name = $email = $phone = "";
    $name_err = $email_err = $phone_err = "";
    $name_pattern = "/^[a-zA-Z\s]+$/";
    $email_pattern = "/^\S+@\S+\.\S+$/";
    $phone_pattern = "/^\d{10}$/";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate name
        if (empty($_POST["name"])) {
            $name_err = "Please enter your name.";
        } else {
            if (!preg_match($name_pattern, $_POST["name"])) {
                $name_err = "Only letters and white space allowed.";
            } else {
                $name = $_POST["name"];
            }
        }
        if (empty($_POST["email"])) {
            $email_err = "Please enter your email address.";
        } else {
            if (!preg_match($email_pattern, $_POST["email"])) {
                $email_err = "Invalid email format.";
            } else {
                $email = $_POST["email"];
            }
        }
        if (empty($_POST["phone"])) {
            $phone_err = "Please enter your phone number.";
        } else {
            if (!preg_match($phone_pattern, $_POST["phone"])) {
                $phone_err = "Invalid phone number format.";
            } else {
                $phone = $_POST["phone"];
            }
        }
        if (empty($name_err) && empty($email_err) && empty($phone_err)) {
            $conn = new mysqli("localhost", "root", "", "exercise11");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "INSERT INTO users (name, email, phone) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $phone);
            if ($stmt->execute()) {
                echo "Records inserted successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $stmt->close();
            $conn->close();
        }
    }
    ?>
    <div class="container">
        <h2>User Registration Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
                <span class="error"><?php echo $phone_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
