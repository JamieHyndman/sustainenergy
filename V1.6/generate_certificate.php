<?php
require 'libs/fpdf.php';            //library for pdf generator
require 'requires/connect_db.php'; // Include DB connection
session_start();

$user_id = $_SESSION['user_id'] ?? null;
$score = $_GET['score'] ?? 0;
$level = $_GET['level'] ?? 'Participant';
$year = $_GET['year'] ?? date('Y');
$date = date('F j, Y');
$company_name = 'Your Company Name'; // Default in case DB query fails

// Fetch company name and logo from database
$company_logo_path = null;

if ($user_id) {
    $user_id_safe = mysqli_real_escape_string($conn, $user_id);
    $query = "SELECT company_name, company_logo FROM users WHERE id = '$user_id_safe' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $company_name = $row['company_name'];
        if (!empty($row['company_logo'])) {
            $potential_path = "uploads/logos/" . basename($row['company_logo']);
            if (file_exists($potential_path)) {
                $company_logo_path = $potential_path;
            }
        }
    }
}


// Certificate Colors by Level
$color = [
    'Gold' => [212, 175, 55],
    'Silver' => [192, 192, 192],
    'Bronze' => [205, 127, 50]
];
$levelColor = $color[$level] ?? [0, 0, 0];

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(20, 20, 20);

// Draw Border
$pdf->SetDrawColor(34, 139, 34); // Forest green
$pdf->Rect(10, 10, 190, 277); // x, y, width, height

// Add Sustain Energy logo on the left
$pdf->Image('images/logo.png', 15, 15, 30); // (x, y, width)

// Add user company logo on the right (if available)
if ($company_logo_path) {
    $pdf->Image($company_logo_path, 165, 15, 30); // x = 165 to right-align, adjust width as needed
}




$pdf->Ln(40); // Spacing after logo
$pdf->SetFont('Arial', 'B', 18);
$pdf->SetTextColor(34, 139, 34);
$pdf->Cell(0, 10, 'Sustain Energy Certificate of Achievement', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor($levelColor[0], $levelColor[1], $levelColor[2]);
$pdf->Cell(0, 10, strtoupper($level . ' AWARD'), 0, 1, 'C');
$pdf->Ln(10);

// Body
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);
$bodyText = "On behalf of Sustain Energy, $company_name has been awarded the $level Certificate for outstanding achievement in sustainability for the year $year.\n\n"
          . "This recognition is presented to acknowledge your environmental commitment and performance, with a total score of $score points.\n\n"
          . "Congratulations on meeting your sustainable goals.";
$pdf->MultiCell(0, 10, $bodyText, 0, 'C');
$pdf->Ln(20);

// Footer
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "Issued on $date", 0, 1, 'C');
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Thank you for helping build a greener future.', 0, 1, 'C');

// Output
$pdf->Output('I', "SustainEnergy_Certificate_$level.pdf");
?>
