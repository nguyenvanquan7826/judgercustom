<?php include("header.php"); ?>

            <div class="row">
                <div class="col-md-6">
                    <?php if ($duringTime > 0) { ?>
                            <p>
                                <strong>Thời gian bắt đầu</strong>: <?php echo date("H:i:s", $begintime); ?> <br/>
                                <strong>Thời gian làm bài</strong>: <?php echo $duringTime; ?> phút. <br/>
                                <span id="timer"> </span>
                            </p>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <form class="navbar-form navbar-right"  action="upload.php" method="POST" enctype="multipart/form-data">
                        Nộp bài: 
                        <div class="form-group">
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success">Nộp</button>
                    </form>
                </div>
            </div>

		<?php include("rank.php"); ?>
        
        </div>  <!-- end container -->
    </div> <!-- end jumbotron -->
<?php include("footer.php"); ?>
