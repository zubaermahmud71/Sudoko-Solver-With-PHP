<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sudoko Solver - PHP || Zubaer Mahmud</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    table{
        max-width: 320px!important;
        margin: auto;
        margin-top: 50px;
    }
    table input {
        max-width: 24px;
        padding-left: 5px;
    }
    td {
        padding-top: 4px !important;
        padding-bottom: 4px !important;
        padding-right: 0px!important;
        padding-left: 4px !important;
    }
    tr.line {
        border-bottom: 2px solid black;
    }
    td.side {
        border-right: 2px solid black!important;
    }
  </style>
</head>
<body>

<?php

if (isset($_GET['result'])) {
    $r = $_GET['result'];
    $r = explode('-', $r);
    $time = $r[9];
}

?>

<div class="container text-center">
    <br>
    <h3>Sudoko Solver With PHP</h3>
    <form id="frmId" onsubmit="return sendData();" method="post">
        <table class="table table-bordered">
            <?php if (isset($_GET['result'])) {?>
                <tbody>
                    <?php for ($j=1; $j < 10; $j++) {
                        $row = $r[$j-1];
                        $row = str_split($row);             
                        ?>
                        <tr
                        <?php if ($j%3 == 0 && $j != 9) {
                            echo 'class="line"';
                        } ?>
                        >
                            <?php for ($i=1; $i < 10; $i++) { ?>
                                <td
                                <?php if ($i%3 == 0 && $i != 9) {
                                    echo 'class="side"';
                                } ?>
                                ><input disabled value='<?=$row[$i-1]?>' type="text" name="cell<?=$i?>" id="cell<?=$i?>"></td>
                            <?php } ?>
                        </tr>                
                    <?php } ?>
                </tbody>
            <?php }else {?>
                <tbody>
                    <?php for ($j=1; $j < 10; $j++) {             
                        ?>
                        <tr
                        <?php if ($j%3 == 0 && $j != 9) {
                            echo 'class="line"';
                        } ?>
                        >
                            <?php for ($i=1; $i < 10; $i++) { ?>
                                <td
                                <?php if ($i%3 == 0 && $i != 9) {
                                    echo 'class="side"';
                                } ?>
                                ><input type="text" name="cell<?=$i?>" id="cell<?=$i?>"></td>
                            <?php } ?>
                        </tr>                
                    <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        
        <?php if (isset($_GET['result'])) {?>
            <p>Executed Time : <?=$time?> sec</p>
            <a class="btn btn-info" href="index.php">Solve Another !</a>
        <?php }else{ ?>
        <input type="submit" class="btn btn-info" value="Submit">
        <?php } ?>
    </form>
    <br><br>
    <b>Github Link : </b><a href="http://" target="_blank" rel="noopener noreferrer"></a>
</div>

</body>
</html>

<script>
    function sendData() {
        var arr = $('#frmId').serializeArray();
        $.ajax({
            type: 'post',
            url: 'solve.php',
            data: {
                array: arr
            },
            success: function (response) {
                window.location.replace("index.php?result=" + response);
            }
        });
            
        return false;
    }
</script>