<?php

require_once __DIR__ . '/Spire.php';
require_once  __DIR__ . '/primes.php';

$n = isset($_GET['n']) ? $_GET['n'] : 1;

usleep(10);

$start = $n;
$end = 20000;
$spire = new Spire($start, $end);
$spire->calculate(true);
$matrix = $spire->getMatrix();

$radius = ceil(sqrt($end) / 2);
//exit;
?>
<html>
<head>
    <title>Optimus Prime</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <style>
        table {
            border: 1px solid #333;
        }
        tr {
            border: 1px solid #333;
        }
        td {
            width: 8px;
            height: 8px;
            border: 1px solid #333;
            text-align: center;
            vertical-align: middle;
        }
        td.prime {
            padding: 2px;
            border: 1px solid black;
            border-radius: 50%;
            background-color: black;
        }
        td.center {
            border: 1px solid goldenrod;
            border-radius: 50%;
            background-color: goldenrod;
        }
        td.prime:hover {
            background-color: silver;
        }
    </style>
</head>
<body>
<table>
    <tbody>
    <?php for($i=-$radius; $i<$radius; $i++): ?>
        <tr>
            <?php for($j=-$radius+1; $j<$radius+1; $j++): ?>
                <?php if (isset($matrix[$i][$j])): ?>
                    <?php
                    $value = $matrix[$i][$j];
                    $isPrime = in_array($value, $primes);
                    $cssClasses = [];

                    if ($isPrime) {
                        $cssClasses[] = 'prime';
                    }

                    if ($i == 0 && $j == 0) {
                        $cssClasses[] = 'center';
                    }

                    $classes = implode(' ', $cssClasses);
                    ?>
                    <td <?php if ($cssClasses) echo 'class="'.$classes.'"'; ?> title="<?= sprintf('(%d, %d): %d', $i, $j, $matrix[$i][$j]) ?>"></td>
                <?php else: ?>
                    <td></td>
                <?php endif; ?>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
    </tbody>
</table>

<a href="/?n=<?= $n-1; ?>">Previous</a>
<a href="/?n=<?= $n+1; ?>">Next</a>
<?php
//switch ($n) {
//    case 1:
//        $n = 7;
//    case 7:
//        $n = 11;
//        break;
//    case 11:
//        $n = 23;
//        break;
//    case 23:
//        $n = 41;
//        break;
//    case 41:
//        $n = 47;
//        break;
//    case 47:
//        $n = 53;
//        break;
//}
?>
<script type="application/javascript">
    window.location.href = "/?n=<?= ++$n; ?>";
    //window.location.href = "/?n=<?//= $n; ?>//";
</script>
</body>
</html>
