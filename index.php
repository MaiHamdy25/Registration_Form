<!DOCTYPE HTML>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>

    <?php
    // define variables and set to empty values
    $nameErr = $emailErr = $genderErr = $agreeErr = "";
    $name = $email = $gender = $group = $details = "";
    $selectCourse = [];
    $showInput = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $showInput = true;

        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $nameErr = "Only letters and white space allowed";
                $showInput = false;
            }
        }

        if ($nameErr) {
            $email = $_POST["email"] ?? "";
            $group = $_POST["group"] ?? "";
            $details = $_POST["details"] ?? "";
            $gender = $_POST["gender"] ?? "";
            $selectCourse = $_POST["selectCourse"] ?? [];
            if (!is_array($selectCourse)) {
                $selectCourse = [];
            }
        } else {
            $email = $group = $details = $gender = "";
            $selectCourse = [];
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            $showInput = false;
        } else {
            $email = test_input($_POST["email"]);
        }

        if (empty($_POST["group"])) {
            $group = "";
        } else {
            $group = test_input($_POST["group"]);
        }

        if (empty($_POST["details"])) {
            $details = "";
        } else {
            $details = test_input($_POST["details"]);
        }

        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
            $showInput = false;
        } else {
            $gender = test_input($_POST["gender"]);
        }

        if (empty($_POST["agree"])) {
            $agreeErr = "Agreement is required";
            $showInput = false;
        }

        if ($nameErr || $emailErr || $genderErr || $agreeErr) {
            $showInput = false;
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <h2>Class Registration</h2>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Name: <input type="text" name="name" value="<?php echo $nameErr ? $name : ''; ?>">
        <span class="error">* <?php echo $nameErr; ?></span>
        <br><br>
        E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br><br>
        Group: <input type="number" name="group" value="<?php echo $group; ?>">
        <br><br>
        Class details: <textarea name="details" rows="5" cols="40"><?php echo $details; ?></textarea>
        <br><br>
        Gender:
        <input type="radio" name="gender" value="female" <?php if ($gender == "female") echo "checked"; ?>>Female
        <input type="radio" name="gender" value="male" <?php if ($gender == "male") echo "checked"; ?>>Male
        <span class="error">* <?php echo $genderErr; ?></span>
        <br><br>
        Select Course:
        <select name="selectCourse[]" multiple>
            <option value="Cyber" <?php if (is_array($selectCourse) && in_array("Cyber", $selectCourse)) echo "selected"; ?>>Cyber Security</option>
            <option value="Web" <?php if (is_array($selectCourse) && in_array("Web", $selectCourse)) echo "selected"; ?>>Web Development</option>
            <option value="Mobile" <?php if (is_array($selectCourse) && in_array("Mobile", $selectCourse)) echo "selected"; ?>>Mobile Application</option>
            <option value="AI" <?php if (is_array($selectCourse) && in_array("AI", $selectCourse)) echo "selected"; ?>>AI</option>
        </select>
        <br><br>
        <label for="agree">Agree</label>
        <input type="checkbox" name="agree" id="agree" <?php if (!empty($_POST["agree"])) echo "checked"; ?>>
        <span class="error">* <?php echo $agreeErr; ?></span>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if ($showInput) {
        echo "<h2>Your Input:</h2>";
        echo "Name: $name";
        echo "<br>";
        echo "Email: $email";
        echo "<br>";
        echo "Group: $group";
        echo "<br>";
        echo "Details: $details";
        echo "<br>";
        echo "Gender: $gender";
        echo "<br>";
        echo "Your Courses: " . implode(", ", $selectCourse);
    }
    ?>

</body>

</html>