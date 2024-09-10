<?php
include 'includes/config2.php';
if (isset($_POST['search'])) {
    $classid = $_POST['search'];
    $result = mysqli_query($dbh, "SELECT * FROM quiz WHERE ClassNameNumeric='$classid'");
    $c = 1;
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $title = $row['title'];
            $total = $row['total'];
            $sahi = $row['sahi'];
            $time = $row['time'];
            $eid = $row['eid'];
            $tot_w = $row['tot_w'];
            $writ = $row['write_s'];
            $q12 = mysqli_query($dbh, "SELECT score FROM history WHERE eid='$eid' AND idroll='$email'");
            $rowcount = mysqli_num_rows($q12);
            $markk = $sahi * $total + $tot_w * $writ;
            $wwk = $total + $tot_w;
            echo '<tr style="background:#f9f9f9 !important">
                            <td>' . $c++ . '</td>
                            <td>' . $title . '</td>
                            <td>' . $wwk . '</td>
                            <td>' . $markk . '</td>     
                            <td>' . $time . '&nbsp;دقيقه</td>
                                    <td>
                                        <b>
                                            <a href="quiz_ex.php?q=ff&eid=' . $eid . '&n=1&t=' . $wwk . '" class="pull-right btn sub1" style="margin:0px;background:#99cc32">
                                                <span align="center" class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;
                                            </a>
                                        </b>
                                    </td>
                                </tr>';
        }
        $c = 0;
    } else {
        echo'<div style="font-size:20px;width: max-content;">';
        echo 'لا امتحانات حاليا';
        echo'</div>';
    }
}
