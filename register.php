<?php
require 'config.php';
$message = '';

// الحذف
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $message = "<div class='alert success'>تم الحذف بنجاح</div>";
}

// التسجيل
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['student_name']);
    $email = trim($_POST['email']);
    $number = trim($_POST['student_number']);
    $year = $_POST['year_of_study'];
    $batch = trim($_POST['batch_name']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert error'>الإيميل غير صحيح</div>";
    } else {
        $sql = "INSERT INTO students (student_name, email, student_number, year_of_study, batch_name) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$name, $email, $number, $year, $batch]);
            $message = "<div class='alert success'>تم التسجيل بنجاح</div>";
        } catch(PDOException $e) {
            $message = "<div class='alert error'>الإيميل أو الرقم الجامعي مستخدم</div>";
        }
    }
}

// جلب كل الطلاب
$students = $pdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>