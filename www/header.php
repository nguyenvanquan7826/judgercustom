<?php
	include("init.php");
	include("config.php");
	include("functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en"> <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <meta http-equiv="refresh" content="30" /> -->

    <title><?php echo $title ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="../css_hy/clear.css" type="text/css" charset="utf-8" /> -->
    <link rel="stylesheet" href="../css_hy/style.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="../css_hy/datatable.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="../css_hy/table-form.css" type="text/css" charset="utf-8" />

	<script src="js/jquery-latest.js"></script>
	<script>
		var refreshId = setInterval(function(){
			$('#logs').load('logs.php');
			$('#timer').load('timer.php');
		}, 1000);
	</script>

    <style type="text/css">
        .menu > li {
            display: inline;
        }
        .navbar-header {
            max-width: 100%;
            min-width: 500px;
        }
        .datatable {
            width: 100%;
            position: unset;
        }
        .datatable table {
            width: 100%;
        }
        .datatable .dark {
            background-color: #f9f9f9;
        }
        h1, h2, h3 {
            margin-top: 0px;
            margin-bottom: 0px;
        }
        a.main-menu {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }
        .pending {
            background-color: #d439f1 !important;
            color: white !important;
        }
        .lock {
            background-color: #5cb85c;
            text-align: center;
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        .me {
            background-color: #e1ecf4;
            color: black;
        }
        .datatable td, .datatable th {
            padding: 0px 5px 0px 5px;
        }
    </style>

</head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img src="/img/logo_ictu1.png" width="56px" height="56px" style="float: left; margin-right: 15px; margin-top: 5px;" />
            <h4 style="font-weight: bold;color:white"><?php echo $title ?></h4>
            <ul class="menu">
                <?php foreach ($menu as $m): ?>
                    <li><a class="main-menu" target="<?php echo $m['target'] ?>" href="<?php echo $m['url'] ?>"><?php echo $m['name'] ?></a></li>    
                <?php endforeach; ?>
           </ul>
        </div>
		
		<div class="navbar-collapse collapse">
			<div class="navbar-form navbar-right"> 
				<a class="btn btn-success" href="repass.php" title="Đổi mật khẩu">Thí sinh: <?php echo $_SESSION['tname']; ?></a> 
				<a href="logout.php">(Thoát)</a>
		</div>
		</div>  
      </div>
    </div>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container" style="background: white; padding: 15px;">
            <img src="/img/olp2017.jpg" style="max-width: 100%">
        
