<?php
date_default_timezone_set("Asia/Bangkok"); 
$YYYY = date('Y', time());
$dir = $logsDir;
$cntc = $cntp = 0;
$reg_cttants = $reg_problems = $sum = $last = $cttants = $problems = array();
$data = $log = array(array());
$color = array("red", "orangered", "orange", "darkviolet", "blue");
if (is_dir($dir)) if ($dh = opendir($dir)) {
    while ($file = readdir($dh)) if ($file!="." && $file!=".." && $file != "<") {
        if (filemtime($dir.$file) < $begintime) continue;
        $handle = @fopen($dir.$file, "r");
        if ($handle && !feof($handle)) {
            $content = fgets($handle, 100); fclose($handle); 
        }
        getdata($content, $w, $p, $scr);
        if (updatectts($w, $cttants[$cntc], $reg_cttants[$w])) ++$cntc;
        if (updateprbs($p, $problems[$cntp], $reg_problems[$p])) ++$cntp;
        if ($scr == "") continue;

        // neu $w chua co diem bai $p hoac nop lai thi tinh toan va luu lai ket qua diem, file log va thoi gian cuoi cung
        if ($data[$w][$p] == 0 || filemtime($dir.$file) > filemtime($dir.$log[$w][$p])) {
            $data[$w][$p] = $scr;
            $log[$w][$p] = $file;
            $last[$w] = max($last[$w], filemtime($dir.$file));
        } 
    }
  closedir($dh);
}

?>

    <div class='datatable' style='background-color: #E1E1E1; padding-bottom: 3px'>
      <div style="background-color: white;margin:0em 0px 0 1px;position:relative;">
        <table class="standings">
          <?php function swap(&$xm, &$ym){ $tmp = $xm; $xm = $ym; $ym = $tmp; }
          for ($i = 0; $i < $cntc; ++$i)
          for ($j = 0; $j < $cntp; ++$j)
          if ($data[$cttants[$i]][$problems[$j]] != "...") $sum[$cttants[$i]] += $data[$cttants[$i]][$problems[$j]];
          
          // megar all user with data folder
          $users = getUser($accountDir); 
          $cttants = array();
          $cntc = 0;
          foreach ($users as $u) {
              $cttants[$cntc++] = $u['username'];
          }

          // SORT CONTESTANTS
          for ($i = 0; $i < $cntc; ++$i) 
          for ($j = $i + 1; $j < $cntc; ++$j)
          if ($sum[$cttants[$i]] < $sum[$cttants[$j]] || ($sum[$cttants[$i]] == $sum[$cttants[$j]] && $last[$cttants[$i]] > $last[$cttants[$j]]))
          swap ($cttants[$i], $cttants[$j]);

          // meger all problems with problems folder
          $allProblems = getProblem($problemsDir);
          // update all problems from folder to $problems.
          $problems = array(); 
          $cntp = 0;
          $tempP = array();
          foreach ($allProblems as $p) {
                $problems[$cntp++] = $p['name'];
                $tempP[$p['name']] = $p;
          }
          $allProblems = $tempP;
          ?>
          <tr style="background-color: #EDEDEE;">
                <th style='color:#898992; min-width:40px'>RK</th>
                <th style='text-align:left;color:#898992; text-align: center;' colspan="2">THÍ SINH</th>
                <th style='color:#898992;min-width:80px'>TỔNG</th>
                <?php foreach ($problems as $p) : $f = $problemsDir . '/' .$allProblems[$p]['file']; ?>
                    <th style='min-width:95px;'><a href="<?php echo $f ?>" target='_blank'><?php echo $p ?></a></th>
                <?php endforeach ?> 
          </tr>

          <?php for ($i = 0; $i < $cntc; ++$i) {
          $cl = "black	";
          if ($i >= $cntc - 5) $cl = "grey";
          if ($i < 5) $cl = $color[min($i, 6)];
          echo "<tr>";
          if ($i % 2 == 0) {
            echo "<td>".($i + 1)."</td>";
            echo "<td style='text-align:left;color:".$cl."'><b>".$cttants[$i]."</b></td>";
            // echo "<td style='text-align:left;color:".$cl."'><b>".$last[$cttants[$i]]."</b></td>";
            echo "<td style='text-align:left;color:".$cl."'><b>".$users[$cttants[$i]]['fullname']."</b></td>";
            echo "<td style='color:black'><b>".sprintf("%0.2f", $sum[$cttants[$i]])."</b></td>";
            for ($j = 0; $j < $cntp; ++$j)
                // echo "<td style='color:#0a0'> <a onclick=wload('".$logssubDir.rawurlencode($log[$cttants[$i]][$problems[$j]])."')> <b>".$data[$cttants[$i]][$problems[$j]]."</b> </a> </td>";
                echo "<td style='color:#0a0'> <b>".$data[$cttants[$i]][$problems[$j]]."</b> </a> </td>";
          } else {
            echo "<td class='contestant-cell dark'>".($i + 1)."</td>";
            echo "<td style='text-align:left;color:".$cl."' class='contestant-cell dark'><b>".$cttants[$i]."</b></td>";
            // echo "<td style='text-align:left;color:".$cl."' class='contestant-cell dark'><b>".$last[$cttants[$i]]."</b></td>";
            echo "<td style='text-align:left;color:".$cl."' class='contestant-cell dark'><b>".$users[$cttants[$i]]['fullname']."</b></td>";
            echo "<td style='color:black' class='contestant-cell dark'><b>".sprintf("%0.2f", $sum[$cttants[$i]])."</b></td>";
            for ($j = 0; $j < $cntp; ++$j)
              // echo "<td class='contestant-cell dark' style='color:#0a0'> <a onclick=wload('".$logssubDir.rawurlencode($log[$cttants[$i]][$problems[$j]])."')> <b>".$data[$cttants[$i]][$problems[$j]]."</b> </a> </td>";
                echo "<td class='contestant-cell dark' style='color:#0a0'> <b>".$data[$cttants[$i]][$problems[$j]]."</b> </a> </td>";
            }
            echo "</tr>"; 
          } ?>
        </table>
      </div>
	  
   
	</div> 