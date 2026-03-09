<?php
// process_admission.php
session_start();

// ફોલ્ડર્સ બનાવો (જો ન હોય તો)
$upload_dir = "uploads/";
$data_dir = "data/";

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}
if (!file_exists($data_dir)) {
    mkdir($data_dir, 0777, true);
}

// ફોર્મ ડેટા એકત્રિત કરો
$student_name = $_POST['student_name'] ?? '';
$dob = $_POST['dob'] ?? '';
$class = $_POST['class'] ?? '';
$stream = $_POST['stream'] ?? '';
$father_name = $_POST['father_name'] ?? '';
$mother_name = $_POST['mother_name'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$district = $_POST['district'] ?? 'વલસાડ';
$address = $_POST['address'] ?? '';

// વેલિડેશન
if (empty($student_name) || empty($dob) || empty($class) || empty($father_name) || empty($mother_name) || empty($mobile) || empty($address)) {
    header("Location: admission.php?error=1");
    exit();
}

// યુનિક આઈડી બનાવો
$application_id = time() . '_' . rand(1000, 9999);
$student_folder = $upload_dir . $application_id . '/';
mkdir($student_folder, 0777, true);

// ફાઇલો અપલોડ કરો
$uploaded_files = [];
$required_files = ['lc', 'marksheet', 'aadhar', 'photo', 'passbook', 'father_aadhar', 'mother_aadhar'];
$all_uploaded = true;

foreach ($required_files as $file) {
    if (isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
        $ext = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
        $filename = $file . '_' . $application_id . '.' . $ext;
        $destination = $student_folder . $filename;
        
        if (move_uploaded_file($_FILES[$file]['tmp_name'], $destination)) {
            $uploaded_files[$file] = $destination;
        } else {
            $all_uploaded = false;
        }
    } else {
        $all_uploaded = false;
    }
}

// વૈકલ્પિક ફાઇલો અપલોડ કરો
$optional_files = ['caste', 'ration'];
foreach ($optional_files as $file) {
    if (isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
        $ext = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
        $filename = $file . '_' . $application_id . '.' . $ext;
        $destination = $student_folder . $filename;
        move_uploaded_file($_FILES[$file]['tmp_name'], $destination);
        $uploaded_files[$file] = $destination;
    }
}

if (!$all_uploaded) {
    header("Location: admission.php?error=1");
    exit();
}

// ડેટા JSON ફાઇલમાં સેવ કરો
$admission_data = [
    'application_id' => $application_id,
    'submitted_at' => date('Y-m-d H:i:s'),
    'student_name' => $student_name,
    'dob' => $dob,
    'class' => $class,
    'stream' => $stream,
    'father_name' => $father_name,
    'mother_name' => $mother_name,
    'mobile' => $mobile,
    'district' => $district,
    'address' => $address,
    'files' => $uploaded_files
];

// JSON ફાઇલમાં સેવ કરો
$json_file = $data_dir . 'admissions.json';
$current_data = [];

if (file_exists($json_file)) {
    $current_data = json_decode(file_get_contents($json_file), true) ?? [];
}

$current_data[] = $admission_data;
file_put_contents($json_file, json_encode($current_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// CSV ફાઇલમાં પણ સેવ કરો (Excel માં ખોલવા માટે)
$csv_file = $data_dir . 'admissions.csv';
$is_new_file = !file_exists($csv_file);

$fp = fopen($csv_file, 'a');
if ($is_new_file) {
    fputcsv($fp, ['અરજી નંબર', 'તારીખ', 'નામ', 'ધોરણ', 'સ્ટ્રીમ', 'મોબાઇલ', 'પિતાનું નામ', 'માતાનું નામ']);
}
fputcsv($fp, [$application_id, date('Y-m-d H:i'), $student_name, $class, $stream, $mobile, $father_name, $mother_name]);
fclose($fp);

// સફળતા પેજ પર રીડાયરેક્ટ કરો
header("Location: admission.php?success=1");
exit();
?>