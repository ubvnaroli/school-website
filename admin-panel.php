<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>એડમિન પેનલ | પ્રવેશ અરજીઓ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', 'Nirmala UI', sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #1a237e, #283593);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 24px;
        }
        .logout-btn {
            background: #ffd700;
            color: #1a237e;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #1a237e;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        .filters {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .filters input, .filters select {
            padding: 8px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            flex: 1;
            min-width: 200px;
        }
        table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        th {
            background: #1a237e;
            color: white;
            padding: 15px;
            text-align: left;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .view-btn {
            background: #283593;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
        }
        .download-btn {
            background: #4caf50;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .pagination a {
            background: white;
            padding: 8px 15px;
            text-decoration: none;
            color: #1a237e;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }
        .pagination a.active {
            background: #1a237e;
            color: white;
        }
        @media (max-width: 768px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-shield"></i> એડમિન પેનલ - પ્રવેશ અરજીઓ</h1>
            <div>
                <a href="export_csv.php" class="logout-btn" style="background: #4caf50; margin-right: 10px;">
                    <i class="fas fa-download"></i> CSV ડાઉનલોડ
                </a>
                <a href="admin-login.html" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> લોગઆઉટ
                </a>
            </div>
        </div>
        
        <?php
        // ડેટા લોડ કરો
        $json_file = 'data/admissions.json';
        $applications = [];
        
        if (file_exists($json_file)) {
            $applications = json_decode(file_get_contents($json_file), true) ?? [];
        }
        
        // ફિલ્ટર
        $filter_class = $_GET['class'] ?? '';
        $filter_stream = $_GET['stream'] ?? '';
        $search = $_GET['search'] ?? '';
        
        if (!empty($filter_class)) {
            $applications = array_filter($applications, function($app) use ($filter_class) {
                return $app['class'] == $filter_class;
            });
        }
        
        if (!empty($filter_stream)) {
            $applications = array_filter($applications, function($app) use ($filter_stream) {
                return ($app['stream'] ?? '') == $filter_stream;
            });
        }
        
        if (!empty($search)) {
            $applications = array_filter($applications, function($app) use ($search) {
                return stripos($app['student_name'], $search) !== false || 
                       stripos($app['mobile'], $search) !== false;
            });
        }
        
        // પેજિનેશન
        $page = $_GET['page'] ?? 1;
        $per_page = 20;
        $total = count($applications);
        $pages = ceil($total / $per_page);
        $offset = ($page - 1) * $per_page;
        $applications = array_slice($applications, $offset, $per_page);
        ?>
        
        <!-- આંકડા -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total; ?></div>
                <div class="stat-label">કુલ અરજીઓ</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    $class11 = array_filter($applications, fn($a) => ($a['class'] ?? '') == '11');
                    echo count($class11);
                    ?>
                </div>
                <div class="stat-label">ધોરણ 11</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    $class12 = array_filter($applications, fn($a) => ($a['class'] ?? '') == '12');
                    echo count($class12);
                    ?>
                </div>
                <div class="stat-label">ધોરણ 12</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    $today = array_filter($applications, fn($a) => substr($a['submitted_at'] ?? '', 0, 10) == date('Y-m-d'));
                    echo count($today);
                    ?>
                </div>
                <div class="stat-label">આજની અરજીઓ</div>
            </div>
        </div>
        
        <!-- ફિલ્ટર્સ -->
        <div class="filters">
            <form method="GET" style="display: flex; gap: 15px; width: 100%; flex-wrap: wrap;">
                <input type="text" name="search" placeholder="🔍 નામ અથવા મોબાઇલથી શોધો..." value="<?php echo htmlspecialchars($search); ?>">
                
                <select name="class">
                    <option value="">બધા ધોરણ</option>
                    <option value="9" <?php echo $filter_class == '9' ? 'selected' : ''; ?>>ધોરણ 9</option>
                    <option value="10" <?php echo $filter_class == '10' ? 'selected' : ''; ?>>ધોરણ 10</option>
                    <option value="11" <?php echo $filter_class == '11' ? 'selected' : ''; ?>>ધોરણ 11</option>
                    <option value="12" <?php echo $filter_class == '12' ? 'selected' : ''; ?>>ધોરણ 12</option>
                </select>
                
                <select name="stream">
                    <option value="">બધી સ્ટ્રીમ</option>
                    <option value="science" <?php echo $filter_stream == 'science' ? 'selected' : ''; ?>>સાયન્સ</option>
                    <option value="commerce" <?php echo $filter_stream == 'commerce' ? 'selected' : ''; ?>>કોમર્સ</option>
                    <option value="arts" <?php echo $filter_stream == 'arts' ? 'selected' : ''; ?>>આર્ટ્સ</option>
                </select>
                
                <button type="submit" style="background: #1a237e; color: white; padding: 8px 20px; border: none; border-radius: 5px; cursor: pointer;">
                    <i class="fas fa-filter"></i> ફિલ્ટર કરો
                </button>
                
                <a href="admin-panel.php" style="background: #6c757d; color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px;">
                    <i class="fas fa-times"></i> રીસેટ
                </a>
            </form>
        </div>
        
        <!-- ટેબલ -->
        <table>
            <thead>
                <tr>
                    <th>અરજી નંબર</th>
                    <th>તારીખ</th>
                    <th>નામ</th>
                    <th>ધોરણ</th>
                    <th>સ્ટ્રીમ</th>
                    <th>મોબાઇલ</th>
                    <th>પિતાનું નામ</th>
                    <th>દસ્તાવેજો</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($applications)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 50px;">
                        <i class="fas fa-folder-open" style="font-size: 48px; color: #ccc;"></i>
                        <p style="margin-top: 10px;">કોઈ અરજી મળી નથી</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($applications as $app): ?>
                    <tr>
                        <td><strong>#<?php echo $app['application_id']; ?></strong></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($app['submitted_at'])); ?></td>
                        <td><?php echo htmlspecialchars($app['student_name']); ?></td>
                        <td>
                            <?php 
                            echo $app['class'];
                            if (!empty($app['stream'])) {
                                $stream_names = ['science'=>'સા', 'commerce'=>'કો', 'arts'=>'આ'];
                                echo ' (' . ($stream_names[$app['stream']] ?? '') . ')';
                            }
                            ?>
                        </td>
                        <td><?php echo $app['mobile']; ?></td>
                        <td><?php echo htmlspecialchars($app['father_name']); ?></td>
                        <td>
                            <a href="view_files.php?id=<?php echo $app['application_id']; ?>" class="view-btn" target="_blank">
                                <i class="fas fa-eye"></i> જુઓ
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- પેજિનેશન -->
        <?php if ($pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&class=<?php echo urlencode($filter_class); ?>&stream=<?php echo urlencode($filter_stream); ?>&search=<?php echo urlencode($search); ?>" 
                   class="<?php echo $i == $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>