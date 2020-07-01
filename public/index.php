<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once  __DIR__ . '/primes.php';

use Loculus\UlamSpiral\Spire;

session_start();

$n = isset($_GET['n']) ? (int) $_GET['n'] : 1;

if (isset($_GET['stop']) && $_GET['stop']) {
    $_SESSION['stop'] = true;
} else {
    $_SESSION['stop'] = false;
}

if ($n < 1 || $n > 20000) {
    $n = 1;
}

usleep(10);

$start = $n;
$end = 20000;

$spire = new Spire($start, $end);
$spire->calculate();
$matrix = $spire->getMatrix();

$radius = ceil(sqrt($end) / 2);
?>
<html>
<head>
    <title>Ulam Prime Spire</title>
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
            border: 1px solid #333;
            border-radius: 50%;
            background-color: #333;
            color: #eee;
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
    <?php for($j=$radius; $j>=-$radius; $j--): ?>
        <tr>
            <?php for($i=-$radius; $i<$radius; $i++): ?>
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

<?php if (isset($_SESSION['stop']) && $_SESSION['stop']): ?>
    <a href="/?n=<?= $n; ?>&amp;stop=0">Start</a>
<?php endif; ?>

<a href="/?n=<?= $n+1; ?>">Next</a>

<script type="application/javascript">
    <?php if (!isset($_SESSION['stop']) || !$_SESSION['stop']): ?>
        window.location.href = "/?n=<?= ++$n; ?>";
    <?php endif; ?>
</script>
</body>
</html>
