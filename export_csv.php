<?php
// export_csv.php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=admissions_'.date('Y-m-d').'.csv');

$output = fopen('php://output', 'w');

// CSV હેડર
fputcsv($output, ['અરજી નંબર', 'તારીખ', 'નામ', 'જન્મ તારીખ', 'ધોરણ', 'સ્ટ્રીમ', 'પિતાનું નામ', 'માતાનું નામ', 'મોબાઇલ', 'જિલ્લો', 'સરનામું']);

// ડેટા લોડ કરો
$json_file = 'data/admissions.json';
if (file_exists($json_file)) {
    $applications = json_decode(file_get_contents($json_file), true) ?? [];
    
    foreach ($applications as $app) {
        fputcsv($output, [
            $app['application_id'],
            $app['submitted_at'],
            $app['student_name'],
            $app['dob'],
            $app['class'],
            $app['stream'] ?? '-',
            $app['father_name'],
            $app['mother_name'],
            $app['mobile'],
            $app['district'],
            $app['address']
        ]);
    }
}

fclose($output);
exit();
?>