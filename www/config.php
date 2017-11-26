<?php
date_default_timezone_set("Asia/Bangkok"); 

//Thời gian bắt đầu kỳ thi (định dạng HH, MM, SS, MM, DD, YYYY)
$begintime = mktime(20, 5, 00, 11, 24, 2017);
//Thời gian làm bài - (đặt 0: không giới hạn)
$duringTime = 100; //(gio * phút)
//Thoi gian bu gio
$addTime = 2 * 60; // 3 phut 
// Thoi gian block bang diem khi ve cuoi
$lockTime = 0;// phut
// final result
$finalResult = 0;

$fixScore = array(10);

$baseDir = "F:/contests/olp24112017";

//Thư mục lưu bài làm trực tuyến của học sinh
$uploadDir = "$baseDir/submit/";	
//Thư mục chứa file logs
$logsDir = "$baseDir/submit/Logs/";
$logssubDir = "$baseDir/submit/Logs/";
$logJsonFile = "$baseDir/submit/logJson.json";

$accountDir = $baseDir;
//Thư mục chưa đề (định dạng pdf, jpg hoặc zip)
$problemsDir = "problems/";

//Thư mục chứa test
// $examTestDir = "contests/tests";

//Tên file test tổng hợp
// $examTestFile = "Full.contest";

//Tên file đề tổng hợp
// $problemsFile = "";
//1: Công bố kết quả sau khi chấm, 0: không công bố.
$publish = 1;

$menu = array(
	array('name' => 'Bảng điểm', 'url' => 'index.php', 'target' => ''),
	array('name' => 'Hướng dẫn', 'url' => 'doc.php' , 'target' => '_blank'),
);

$school = 'ĐH CNTT&TT Thái Nguyên';
$title = "Olympic tin học 2017 - " . $school;
$footer = "Khoa Công nghệ thông tin - Trường Đại học CNTT&TT Thái Nguyên @ 2016";
?>