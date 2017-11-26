<?php 
date_default_timezone_set("Asia/Bangkok"); 

$rank = array();
$users = getUser($accountDir);
$problems = getProblem($problemsDir);

foreach ($users as $u) {
	$rank[$u['username']] = array(
		'fullname'		=> $u['fullname'],
		'username'		=> $u['username'],
		'public'        => array(
            'total_score'   => 0,
            'last'          => 0,
            'problems'      => null,
        ),
	);
}

$json  = file_get_contents("$logJsonFile");
if(!empty($json)) {
    $rs = json_decode($json, true);
    foreach ($rs as $r) {
        $rank[$r['username']] = $r;
    }
}

$isLock = 0;
if($lockTime > 0) {
    $lessTime = $begintime + $duringTime*60 - time();
    if (( $lessTime < $lockTime*60 )) {
        $isLock = 1;
    }
}

if (is_dir($logsDir)) if ($dh = opendir($logsDir)) {
	while ($file = readdir($dh)) if ($file!="." && $file!=".." && $file != "<") {
		if (filemtime($logsDir.$file) < $begintime) { continue; }
		$handle = @fopen($logsDir.$file, "r");
        if ($handle && !feof($handle)) {
            $content = fgets($handle, 100); fclose($handle); 
        }
        getdata($content, $username, $problem, $score);

        // neu ko co diem o file nay thi ko xet gi ca
        if (!$score) continue;

        $p = array(
        	'time'		=> filemtime($logsDir.$file),
        	'score'		=> $score ? $score : 0,
        	'log'		=> $file,
        );

        $isChange = ($rank[$username]['public']['problems'][$problem]['score'] == 0 
            || filemtime($logsDir.$file) > $rank[$username]['final']['problems'][$problem]['time']);

        if($isChange) {
            if(!$isLock){
                $rank[$username]['public']['problems'][$problem] = $p;
                $rank[$username]['public']['last'] = max($rank[$username]['last'], filemtime($logsDir.$file));
            }else{
                $rank[$username]['lock']['problems'][$problem] = $p;
                $rank[$username]['lock']['last'] = max($rank[$username]['last'], filemtime($logsDir.$file));
            }
        }
	}
}

$rank = array_values($rank);

for($i = 0; $i < count($rank); $i++) {
    $rank[$i]['public']['total_score'] = 0;
    $rank[$i]['public']['last'] = 0;
    foreach ($rank[$i]['public']['problems'] as $p => $detail) {
            $rank[$i]['public']['total_score'] += $detail['score'];
            $rank[$i]['public']['last'] += ($detail['time'] - $begintime);
    }

   if(!isset($rank[$i]['lock'])) {
        $rank[$i]['final'] = $rank[$i]['public'];
   } else{
        

        foreach ($rank[$i]['lock']['problems'] as $p => $detail) {
            $rank[$i]['final']['problems'][$p] = $detail;
        }

        $rank[$i]['final']['last'] = $rank[$i]['lock']['last'];
        $rank[$i]['final']['problems'] = $rank[$i]['public']['problems'];

        $rank[$i]['final']['total_score'] = 0;
        foreach ($rank[$i]['final']['problems'] as $p => $detail) {
            $rank[$i]['final']['total_score'] += $detail['score'];
            $rank[$i]['final']['last'] += ($detail['time'] - $begintime);     
        }
   }
}

$newJson = json_encode($rank);
if(strcmp($json, $newJson)) {
    $pos = strspn($json ^ $newJson, "\0");
    //printf('First difference at position %d: "%s" vs "%s"',$pos, $json[$pos], $newJson[$pos]);
    writeLogJson("$logJsonFile", $newJson);
}

$keyStaust = $finalResult ? 'final' : 'public';

function swap(&$xm, &$ym){ $tmp = $xm; $xm = $ym; $ym = $tmp; }
for ($i = 0; $i < count($rank); $i++) {
    for($j = $i + 1; $j < count($rank); $j++){
        $isSwap = 0;
        $iScore = $rank[$i][$keyStaust]['total_score'];
        $jScore = $rank[$j][$keyStaust]['total_score'];
        $iLast = $rank[$i][$keyStaust]['last'];
        $jLast = $rank[$j][$keyStaust]['last'];
        if($iScore < $jScore || ($iScore == $jScore && $iLast > $jLast) ) $isSwap = 1;
        if($isSwap) swap($rank[$i], $rank[$j]);
    }
}

?>

<?php if($isLock && !$finalResult) : ?>
    <div class="lock">Bảng kết quả sẽ đóng băng trong <?php echo $lockTime ?> phút cuối cùng để tạo kịch tính!</div>
<?php endif ?>

<div class='datatable' style='background-color: #E1E1E1; padding-bottom: 3px'>
	<div style="background-color: white;margin:0em 0px 0 1px;position:relative;">
		<table class="standings" style="font-size: medium;">
			<tr style="background-color: #EDEDEE; line-height: 20px">
                <th style='color:#898992; min-width:40px'>RK</th>
                <th style='text-align:left;color:#898992;'>MÃ SV</th>
                <th style='text-align:left;color:#898992;'>HỌ & TÊN</th>
                <th style='color:#898992;min-width:80px'>TỔNG ĐIỂM</th>
                <th style='color:#898992;min-width:80px'>THỜI GIAN</th>
                <?php $i = -1;
                    foreach ($problems as $p) : $pfile = $problemsDir . '/' .$p['file']; $i++;?>
                    <th style='min-width:95px;'>
                        <a href="<?php echo $pfile ?>" target='_blank'><?php echo $p['name'] . ' ('.$fixScore[$i] .')'; ?></a>
                    </th>
                <?php endforeach ?> 
          	</tr>
          	<?php 
          	$i = 0; 
          	foreach ($rank as $r) : $i++;
                $me = $_SESSION['tuser'] == $r['username'];

                $color = ($i % 2 == 0) ? 'dark' : '';
                $color = $me ? 'me' : $color;
                $total = $me ?  $r['final']['total_score'] : $r[$keyStaust]['total_score'];
                $last = $me ?  $r['final']['last'] : $r[$keyStaust]['last'];
                //$time -= $begintime;
                $last = (int) ($last / 60);
                $last = $last > 0 ? $last : 0;
                ?>
          		
          		<tr style="line-height: 20px">
          			<td class="<?php echo $color ?>"><strong><?php echo $i ?></strong></td>
          			<td class="<?php echo $color ?>" style="text-align: left;"><strong><?php echo $r['username'] ?></strong></td>
          			<td class="<?php echo $color ?>" style="text-align: left;"><strong><?php echo $r['fullname'] ?></strong></td>
          			<td class="<?php echo $color ?>" style="color:red;"><strong><?php echo $total ?></strong></td>
                    <td class="<?php echo $color ?>"><strong><?php echo $last ?></strong></td>
          			<?php foreach ($problems as $p) : 
                        $pName = $p['name']; 
                        $classPending = '';
                        $score = $r[$keyStaust]['problems'][$pName]['score'];
                        if( $keyStaust =='public' && isset($r['lock']['problems'][$pName]) )  {
                            $score .= '+?';
                            $classPending = 'pending';
                        }
                        if($me){
                            $classPending = '';
                            $score = $r['final']['problems'][$pName]['score'];
                        }
                        $time =  $r[$keyStaust]['problems'][$pName]['time'] - $begintime;
                        $time = (int) ($time / 60);
                        $score .= $time > 0 ? " <br><span style='color:black; font-size:12px;'>$time'</span>" : '';
                    ?>
	                    <td class="contestant-cell <?php echo $color . ' ' . $classPending?>" style="color: #5cb85c"><?php echo $score ?></td>
	                <?php endforeach ?> 
          		</tr>
          	<?php endforeach; ?>
      	</table>
	</div>
</div> 