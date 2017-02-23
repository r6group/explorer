<?php
include "CSV_import.php";

//connect to database
mysql_connect("203.157.145.16", "phi", "dhr548");
mysql_select_db("phi"); //your database



function delete_files($target)
{
    if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
            delete_files($file);
        }

        rmdir($target);
    } elseif (is_file($target)) {
        unlink($target);
    }
}


$csv = new CSV_import();

$arr_encodings = $csv->get_encodings(); //take possible encodings list
$arr_encodings["default"] = "[default database encoding]"; //set a default (when the default database encoding should be used)

if (!isset($_POST["encoding"]))
    $_POST["encoding"] = "default"; //set default encoding for the first page show (no POST vars)

if ($_SERVER['REQUEST_METHOD'] == 'POST') //form was submitted
{
    $tmp_name = $_FILES['userfile']['tmp_name'];

    $tmp_unzip_dir = 'uploads/csv/' . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);

    $old = umask(0);
    mkdir($tmp_unzip_dir, 0777);
    umask($old);


    $zip = new \ZipArchive;
    $res = $zip->open($tmp_name);
    if ($res === TRUE) {
        $zip->extractTo($tmp_unzip_dir);
        $zip->close();
        echo 'woot!';
    } else {
        echo 'doh!';
    }


    //optional parameters
    $csv->table_name = $csvname;
    $csv->use_csv_header = 1;
    $csv->field_separate_char = ',';
    $csv->field_enclose_char = '"';
    $csv->field_escape_char = "\\";
    $csv->encoding = 'utf8';

    //start import now

    foreach (glob($tmp_unzip_dir . '/*.csv') as $file) {
        $file = basename($file, ".csv"); // $file is set to "index"
        $csv->file_name = $tmp_unzip_dir .'/'. $file . '.csv';
        //optional parameters
        $csv->table_name = $file;

        $csv->import();
    }

    delete_files($tmp_unzip_dir);

} else
    $_POST["use_csv_header"] = 1;


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
    <title>Quick CSV import</title>
    <style>
        .edt {
            background: #ffffff;
            border: 3px double #aaaaaa;
            -moz-border-left-colors: #aaaaaa #ffffff #aaaaaa;
            -moz-border-right-colors: #aaaaaa #ffffff #aaaaaa;
            -moz-border-top-colors: #aaaaaa #ffffff #aaaaaa;
            -moz-border-bottom-colors: #aaaaaa #ffffff #aaaaaa;
            width: 350px;
        }

        .edt_30 {
            background: #ffffff;
            border: 3px double #aaaaaa;
            font-family: Courier;
            -moz-border-left-colors: #aaaaaa #ffffff #aaaaaa;
            -moz-border-right-colors: #aaaaaa #ffffff #aaaaaa;
            -moz-border-top-colors: #aaaaaa #ffffff #aaaaaa;
            -moz-border-bottom-colors: #aaaaaa #ffffff #aaaaaa;
            width: 30px;
        }
    </style>
</head>

<body bgcolor="#f2f2f2">

<?= (!empty($csv->error) ? "SQL: ".$csv->sql."<hr/>Errors: " . $csv->error : "") ?>
</body>
</html>
