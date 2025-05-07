<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Green Calculator</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start();
require 'requires/connect_db.php';
require 'requires/nav.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$year = date("Y");
$total_score = 0;
$certificate_level = '';

// Check for associated card
$card_check_query = "SELECT * FROM cards WHERE user_id = '$user_id' LIMIT 1";
$card_check_result = mysqli_query($conn, $card_check_query);
$has_card = mysqli_num_rows($card_check_result) > 0;

// Check for active subscription
$sub_check_query = "SELECT * FROM subscriptions WHERE user_id = '$user_id' AND status = 'active' AND (end_date IS NULL OR end_date >= CURDATE()) LIMIT 1";
$sub_check_result = mysqli_query($conn, $sub_check_query);
$has_subscription = mysqli_num_rows($sub_check_result) > 0;

// Redirect or show options if not eligible
if (!$has_card || !$has_subscription) {
    echo "<h2>Access Restricted</h2>";
    if (!$has_card) {
        echo "<p>You must register a card to use the Green Calculator.</p>";
        echo '<a href="register_card.php"><button>Register Card</button></a>';
    }
    if (!$has_subscription) {
        echo "<p>You must pay the £99 subscription fee to access the calculator.</p>";
        echo '<a href="subscribe.php"><button>Subscribe Now</button></a>';
    }
    include 'includes/footer.php';
    exit(); // Stop loading the calculator
}




$questions = [
    'carbon_emissions' => 'Has your organisation actively reduced its carbon emissions in the past year?',
    'renewable_energy' => 'Does your organisation use renewable energy sources (e.g. solar, wind, hydro) for its operations?',
    'waste_reduction' => 'Have you implemented systems to reduce, reuse, or recycle waste within your organisation?',
    'water_conservation' => 'Has your organisation taken steps to reduce water consumption or improve water efficiency?',
    'supply_chain' => 'Do your suppliers follow sustainable practices (e.g. ethical sourcing, local materials, reduced emissions)?',
    'energy_efficiency' => 'Has your organisation invested in energy-efficient infrastructure, appliances, or processes?',
    'eco_friendly_products' => 'Are your products or services designed with sustainability in mind (e.g. biodegradable, reusable, low-impact)?',
    'sustainable_packaging' => 'Do you use sustainable, recyclable, or minimal packaging for your products?',
    'transportation_sustainability' => 'Do your employees or operations use low-emission transport options (e.g. EVs, cycling, public transport)?',
    'community_engagement' => 'Has your organisation been involved in any community, environmental, or educational sustainability initiatives?'
];


$submitted = false;
$shortfall = 0;
$error_message = '';  // Variable for error messages

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all questions are answered
    foreach ($questions as $key => $question) {
        if (!isset($_POST[$key])) {
            $error_message = "Please answer all questions before submitting.";
            break;
        }
    }

    // If no errors, proceed with calculation
    if (!$error_message) {
        // Calculate the total score based on selected radio buttons
        foreach ($questions as $key => $question) {
            $total_score += (int)$_POST[$key];
        }

        // Determine certificate level based on total score
        if ($total_score >= 70) {
            $certificate_level = 'Gold';
        } elseif ($total_score >= 60) {
            $certificate_level = 'Silver';
        } else {
            $certificate_level = 'Bronze';
        }

        // Check if a result already exists for this user & year
        $check_query = "SELECT * FROM calculator_results WHERE user_id = '$user_id' AND year = '$year'";
        $check_result = mysqli_query($conn, $check_query);

        if (!$check_result) {
            $error_message = "Database error: " . mysqli_error($conn);
        }

        if (!$error_message) {
            if (mysqli_num_rows($check_result) > 0) {
                // Update existing result
                $query = "UPDATE calculator_results 
                          SET total_score = '$total_score', certificate_level = '$certificate_level' 
                          WHERE user_id = '$user_id' AND year = '$year'";
            } else {
                // Insert new result
                $query = "INSERT INTO calculator_results (user_id, year, total_score, certificate_level)
                          VALUES ('$user_id', '$year', '$total_score', '$certificate_level')";
            }

            // Execute the query and check for errors
            if (mysqli_query($conn, $query)) {
                $submitted = true;
            } else {
                $error_message = "Database error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<h1>Green Calculator</h1>
<h2><p> This is the green calculator. Please feel free to take part to get your total sustainability score. There will be 10 questions all based on sustainability, marked out of 100. At the end, you will be given a certificate and a grade of bronze, silver or gold. You will be given the option to buy green points to improve your score. Please answer</p>
<p>Red for Not Achieved: +0 Points </p>
<p>Amber for Somewhat Achieved: +5 Points</p>
<p>Green for Fully Achieved: +10 Points</p></h2>



<?php if ($submitted): ?>
    <div class="result">
        <h2>Thank You for Participating!</h2>
        <p>Your total score: <strong><?= $total_score ?></strong></p>
        <p>Certificate Level: <strong><?= $certificate_level ?></strong></p>

        <?php if ($total_score < 100): ?>
            <?php
                $points_to_silver = max(0, 60 - $total_score);
                $points_to_gold = max(0, 70 - $total_score);
                $points_to_full = max(0, 100 - $total_score);
            ?>

            <p>You can boost your score by purchasing green vouchers at <strong>£10 per point</strong>.</p>

            <form method="POST" action="shop.php">
                <?php if ($points_to_silver > 0): ?>
                    <button type="submit" name="points_needed" value="<?= $points_to_silver ?>">
                        Reach Silver (Buy <?= $points_to_silver ?> point<?= $points_to_silver > 1 ? 's' : '' ?> – £<?= $points_to_silver * 10 ?>)
                    </button>
                <?php endif; ?>

                <?php if ($points_to_gold > 0): ?>
                    <button type="submit" name="points_needed" value="<?= $points_to_gold ?>">
                        Reach Gold (Buy <?= $points_to_gold ?> point<?= $points_to_gold > 1 ? 's' : '' ?> – £<?= $points_to_gold * 10 ?>)
                    </button>
                <?php endif; ?>

                <?php if ($points_to_full > 0): ?>
                    <button type="submit" name="points_needed" value="<?= $points_to_full ?>">
                        Reach 100 Points (Buy <?= $points_to_full ?> point<?= $points_to_full > 1 ? 's' : '' ?> – £<?= $points_to_full * 10 ?>)
                    </button>
                <?php endif; ?>

                <input type="hidden" name="from_calculator" value="yes">
            </form>
        <?php endif; ?>

        <br>
        <a href="generate_certificate.php?score=<?= $total_score ?>&level=<?= $certificate_level ?>" target="_blank" class="button">
            Download Your Certificate
        </a>
        <a href="calculator.php"><button>Try Again</button></a>
    </div>
<?php else: ?>

    <?php if ($error_message): ?>
        <div class="error-message"><?= $error_message ?></div>
    <?php endif; ?>

    <form action="calculator.php" method="POST" id="calculatorForm">
        <div class="progress-bar">
            <div class="progress-bar-inner" id="progress-bar-inner"></div>
        </div>
        <div id="questions-container">
            <?php foreach ($questions as $key => $question): ?>
                <div class="question-container" id="question-<?= $key; ?>">
                    <h2><?= $question ?></h2>
                    <div class="radio-group">
                        <input type="radio" name="<?= $key ?>" value="0" id="<?= $key ?>-red">
                        <label for="<?= $key ?>-red" class="red-label">RED: +0 Points</label>

                        <input type="radio" name="<?= $key ?>" value="5" id="<?= $key ?>-amber">
                        <label for="<?= $key ?>-amber" class="amber-label">AMBER: +5 Points</label>

                        <input type="radio" name="<?= $key ?>" value="10" id="<?= $key ?>-green">
                        <label for="<?= $key ?>-green" class="green-label">GREEN: +10 Points</label>
                    </div>
                    <button type="button" onclick="nextQuestion('<?= $key ?>')">Next</button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" id="submit-button" style="display:none">Submit</button>
    </form>
<?php endif; ?>

<script>
    const questions = document.querySelectorAll('.question-container');
    let currentIndex = 0;
    const progressBar = document.getElementById('progress-bar-inner');
    questions[currentIndex].classList.add('active');

    function nextQuestion(currentKey) {
        const currentQuestion = document.getElementById('question-' + currentKey);
        const selected = currentQuestion.querySelector('input[type="radio"]:checked');
        if (!selected) {
            alert("Please select an option before proceeding.");
            return;
        }

        currentQuestion.classList.remove('active');
        currentIndex++;
        const progress = Math.round((currentIndex / questions.length) * 100);
        progressBar.style.width = progress + "%";

        if (currentIndex < questions.length) {
            questions[currentIndex].classList.add('active');
        } else {
            document.getElementById('submit-button').style.display = 'block';
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
