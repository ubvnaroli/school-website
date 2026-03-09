<?php
// view_files.php
$app_id = $_GET['id'] ?? '';

if (empty($app_id)) {
    die('અરજી નંબર જરૂરી છે');
}

$json_file = 'data/admissions.json';
$applications = json_decode(file_get_contents($json_file), true) ?? [];

$application = null;
foreach ($applications as $app) {
    if ($app['application_id'] == $app_id) {
        $application = $app;
        break;
    }
}

if (!$application) {
    die('અરજી મળી નથી');
}
?>

<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>દસ્તાવેજો - <?php echo htmlspecialchars($application['student_name']); ?></title>
    <style>
        body {
            font-family: 'Poppins', 'Nirmala UI', sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #1a237e, #283593);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .doc-grid {
            display: grid;
            gap: 20px;
        }
        .doc-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .doc-name {
            font-weight: bold;
            color: #1a237e;
        }
        .btn {
            background: #283593;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #1a237e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📄 દસ્તાવેજો - <?php echo htmlspecialchars($application['student_name']); ?></h2>
            <p>અરજી નંબર: #<?php echo $app_id; ?> | ધોરણ: <?php echo $application['class']; ?></p>
        </div>
        
        <div class="doc-grid">
            <?php foreach ($application['files'] as $type => $file): ?>
            <div class="doc-card">
                <span class="doc-name">
                    <?php
                    $names = [
                        'lc' => '📜 એલ.સી.',
                        'marksheet' => '📊 માર્કશીટ',
                        'aadhar' => '🆔 આધાર કાર્ડ',
                        'photo' => '📸 ફોટો',
                        'passbook' => '🏦 બેંક પાસબુક',
                        'father_aadhar' => '👨 પિતાનો આધાર',
                        'mother_aadhar' => '👩 માતાનો આધાર',
                        'caste' => '📋 જ્ઞાતિ પ્રમાણપત્ર',
                        'ration' => '🪪 રેશન કાર્ડ'
                    ];
                    echo $names[$type] ?? $type;
                    ?>
                </span>
                <a href="<?php echo $file; ?>" class="btn" target="_blank">
                    <i class="fas fa-eye"></i> જુઓ
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="admin-panel.php" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">← પાછા જાઓ</a>
        </div>
    </div>
</body>
</html>