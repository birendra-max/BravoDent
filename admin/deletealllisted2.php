<?php
include 'connect.php';

if (isset($_GET['edate']) and isset($_GET['sdate'])) {
    $edate = $_GET['edate'];
    $sdate = $_GET['sdate'];
    $tdate = date('d-M-Y');
    $tdateu = date('d-M-Y h:i:sa');
    $cntt = 0;

    function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    if (isset($_GET['labname']) and $_GET['labname'] != "all") {
        $sql = "SELECT * FROM orders WHERE labname='" . $_GET['labname'] . "'";
    } else {
        $sql = "SELECT * FROM orders";
    }

    $res = mysqli_query($bd, $sql);
    while ($row = mysqli_fetch_array($res)) {
        $orderDate = strtotime(date("d-M-Y", strtotime($row["created_at"])));
        if (strtotime($sdate) <= $orderDate and $orderDate <= strtotime($edate)) {
            $ordid = $row['orderid'];
            $sql2 = "SELECT * FROM orders_finished WHERE orderid='$ordid'";
            $res2 = mysqli_query($bd, $sql2);

            if ($res2 and $row2 = mysqli_fetch_array($res2)) {
                $filepid2 = "../api/finished_files/" . trim($row2['finished_file']);
                $pid2 = $row2['id'];

                mysqli_query($bd, "UPDATE orders_finished SET delete_status='1', d_date='$tdate' WHERE id=$pid2");

                if (file_exists($filepid2)) {
                    if (unlink($filepid2)) {
                        $cntt = $cntt + 1;
                    }
                }
            }
        }
    }

    if ($cntt < 10) {
        $cntt = 10;
    }

    $vv = 60 * round($cntt / 10, 0);
    echo "Wait for ............" . round($cntt / 10, 0) . " Minute";
}
?>

<script type="text/javascript">
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            alert("Deletion is completed. Now Redirecting to home.");
            window.location = 'backup.php';
        }
    }, 1000);
}

window.onload = function () {
    var duration = <?php echo $vv; ?>;
    var display = document.querySelector('#time');
    startTimer(duration, display);
};
</script>

<body>
    <div>Deletion complete in <span id="time">05:00</span> minutes!</div>
</body>
