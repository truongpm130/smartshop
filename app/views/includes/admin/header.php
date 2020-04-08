<?php
// set a time limit in seconds
$timeLimit = 60*60;

// Get the current time
$now = time();

//    If session variable not set, redirect ro login page
if (!isset($_SESSION['user_id'])) {
    redirect('users/login');
    exit();
} elseif ($now > $_SESSION['start'] + $timeLimit) {
//    if time limt has expired, destroy session and redirect
    $_SESSION = [];
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-86400, '/');
    }
    session_destroy();
    redirect('/users/login?expired=yes');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SmartShop - Admin</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo URLROOT ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- CKeditor -->
  <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

  <!-- Custom styles for this template-->
  <link href="<?php echo URLROOT ?>/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo URLROOT ?>/css/style_admin.css" rel="stylesheet">

</head>

<body id="page-top">