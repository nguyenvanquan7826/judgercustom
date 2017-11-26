<?php include("config.php"); ?>
<?php include("functions.php"); ?>
<div class="row">
	  
    <div class="col-md-4">
        <h2>Bài thi:</h2>
            <?php
                $problems = getProblem($problemsDir);
                foreach ($problems as $p) {
                    echo "<h4><a href='".$problemsDir."/".$p['file']."' target='_blank'>".$p['name']."</a></h4>";
                }
            ?>
    </div>
</div>