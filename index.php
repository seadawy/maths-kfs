<!DOCTYPE html>
<html dir="rtl">
<?php
include('includes/config.php');
session_start();
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/start.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f5f5f5;
    }

    h2 {
      font-size: 2em;
      margin: 20px 0;
    }

    .container {
      margin: 0 auto;
      max-width: 1200px;
      padding: 20px;
      text-align: center;
    }

    .mml {
      color: white;
      padding: 10px 30px;
      width: 100%;
      max-width: 300px;
      border-radius: 8px;
      display: inline-block;
      background: rgba(255, 255, 255, 0.35);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(11px);
      -webkit-backdrop-filter: blur(11px);
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .row {
      display: flex;
      justify-content: space-around;
      align-items: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 40px;
    }

    .col-lg-4 {
      background-color: #fff;
      border-radius: 7px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      width: 100%;
      max-width: 300px;
      text-align: center;
      padding: 20px;
      text-decoration: none;
      color: #333;
      font-size: larger;
    }

    .col-lg-4:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .col-lg-4 h2 {
      font-size: 1.2em;
      margin: 0;
    }

    .imgpanned {
      border-radius: 12px;
      width: 100%;
      max-width: 300px;
      height: auto;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }

    .imgpanned:hover {
      transform: scale(1.05);
    }

    .newBackground {
      margin: 0;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1430' height='510' preserveAspectRatio='none' viewBox='0 0 1430 510'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1979%26quot%3b)' fill='none'%3e%3crect width='1430' height='510' x='0' y='0' fill='url(%26quot%3b%23SvgjsLinearGradient1980%26quot%3b)'%3e%3c/rect%3e%3cpath d='M1489.596%2c382.077C1542.106%2c382.456%2c1570.869%2c326.85%2c1596.125%2c280.812C1620.022%2c237.251%2c1641.466%2c188.799%2c1620.281%2c143.857C1596.192%2c92.753%2c1546.092%2c55.219%2c1489.596%2c54.813C1432.497%2c54.402%2c1379.598%2c90.134%2c1355.614%2c141.953C1334.516%2c187.537%2c1361.224%2c235.429%2c1385.699%2c279.293C1411.14%2c324.889%2c1437.383%2c381.7%2c1489.596%2c382.077' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M356.58 134.31 a102.78 102.78 0 1 0 205.56 0 a102.78 102.78 0 1 0 -205.56 0z' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M254.02 373.55 a133.35 133.35 0 1 0 266.7 0 a133.35 133.35 0 1 0 -266.7 0z' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M966.21%2c28.123C983.577%2c28.454%2c999.909%2c18.74%2c1008.084%2c3.414C1015.839%2c-11.125%2c1012.071%2c-28.212%2c1003.89%2c-42.516C995.638%2c-56.943%2c982.825%2c-70.204%2c966.21%2c-69.797C950.071%2c-69.401%2c939.348%2c-54.907%2c931.601%2c-40.743C924.253%2c-27.309%2c920.138%2c-11.812%2c927.014%2c1.869C934.583%2c16.929%2c949.358%2c27.802%2c966.21%2c28.123' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M153.224%2c255.461C168.41%2c254.581%2c182.478%2c247.945%2c190.61%2c235.091C199.386%2c221.22%2c202.998%2c203.72%2c195.042%2c189.363C186.881%2c174.636%2c170.047%2c166.934%2c153.224%2c167.63C137.521%2c168.28%2c125.406%2c179.313%2c117.003%2c192.594C107.784%2c207.165%2c98.884%2c224.97%2c107.492%2c239.91C116.107%2c254.863%2c135.996%2c256.46%2c153.224%2c255.461' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M1035.807%2c573.734C1064.004%2c573.611%2c1092.45%2c562.718%2c1106.244%2c538.126C1119.795%2c513.968%2c1113.518%2c484.567%2c1099.083%2c460.927C1085.326%2c438.397%2c1062.201%2c423.25%2c1035.807%2c422.771C1008.553%2c422.276%2c982.729%2c435.354%2c968.423%2c458.556C953.367%2c482.974%2c949.813%2c513.984%2c964.299%2c538.745C978.661%2c563.294%2c1007.365%2c573.858%2c1035.807%2c573.734' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M850.968%2c466.787C891.006%2c466.037%2c930.288%2c447.493%2c948.72%2c411.942C966.006%2c378.603%2c952.898%2c340.006%2c933.315%2c307.962C914.765%2c277.609%2c886.508%2c253.492%2c850.968%2c251.99C812.789%2c250.377%2c776.147%2c268.224%2c755.616%2c300.453C733.422%2c335.291%2c726.118%2c379.89%2c746.661%2c415.726C767.296%2c451.722%2c809.484%2c467.564%2c850.968%2c466.787' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M1334.59%2c132.307C1357.398%2c130.745%2c1371.012%2c109.572%2c1382.345%2c89.718C1393.538%2c70.108%2c1403.923%2c48.097%2c1394.321%2c27.66C1383.435%2c4.489%2c1360.178%2c-11.119%2c1334.59%2c-11.927C1307.61%2c-12.779%2c1281.059%2c0.075%2c1267.947%2c23.67C1255.154%2c46.69%2c1260.21%2c74.69%2c1273.981%2c97.139C1287.072%2c118.479%2c1309.613%2c134.017%2c1334.59%2c132.307' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1253.159%2c466.334C1276.018%2c466.596%2c1291.456%2c445.176%2c1301.847%2c424.813C1311.138%2c406.605%2c1313.258%2c385.599%2c1303.528%2c367.623C1293.31%2c348.745%2c1274.62%2c335.311%2c1253.159%2c334.864C1230.95%2c334.402%2c1209.375%2c345.793%2c1199.024%2c365.448C1189.247%2c384.014%2c1196.446%2c405.23%2c1206.367%2c423.719C1217.058%2c443.643%2c1230.549%2c466.075%2c1253.159%2c466.334' fill='rgba(200%2c 216%2c 233%2c 0.48)' class='triangle-float1'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1979'%3e%3crect width='1430' height='510' fill='white'%3e%3c/rect%3e%3c/mask%3e%3clinearGradient x1='50%25' y1='0%25' x2='50%25' y2='100%25' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1980'%3e%3cstop stop-color='rgba(207%2c 117%2c 0%2c 1)' offset='0.82'%3e%3c/stop%3e%3cstop stop-color='rgba(26%2c 28%2c 32%2c 1)' offset='1'%3e%3c/stop%3e%3c/linearGradient%3e%3cstyle%3e %40keyframes float1 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-10px%2c 0)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float1 %7b animation: float1 5s infinite%3b %7d %40keyframes float2 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-5px%2c -5px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float2 %7b animation: float2 4s infinite%3b %7d %40keyframes float3 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(0%2c -10px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float3 %7b animation: float3 6s infinite%3b %7d %3c/style%3e%3c/defs%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
    }
  </style>
  <title>الرئيسيه</title>
</head>

<body class="newBackground">
  <div class="container marketing " style="margin-top: 10px;">
    <center>
      <h2 class="mml">السير محمد اسماعيل</h2>
    </center>
    <?php
    $q = $_GET['q'];
    if ($q == '2') {
      echo '
      <div class="row">
        <a href="learn.php?q=1&c=9152" class="col-lg-4">
          <h2>الصف الاول</h2>
        </a>
        <a href="learn.php?q=1&c=9981" class="col-lg-4">
          <h2>الصف الثانى</h2>
        </a>
        <a href="learn.php?q=1&c=855" class="col-lg-4">
          <h2>الصف الثالث</h2>
        </a>
      </div>
    </div>
    ';
    } else { ?>
      <div class="row">
        <center>
          <div class="col-lg-3" style="width: fit-content;">
            <img src="images/panned.jpg" class="imgpanned" alt="Image">
          </div>
        </center>
      </div>
      <div class="row">
        <a href="exam.php" class="col-lg-4">
          <h2>الامتحانات</h2>
        </a>
        <a href="index.php?q=2" class="col-lg-4">
          <h2>الصفوف الثلاثه</h2>
        </a>
        <a href="feedback.php" class="col-lg-4">
          <h2>الواجبات</h2>
        </a>
        <a href="contact/index.html" class="col-lg-4">
          <h2>التواصل مع السنتر</h2>
        </a>
      </div>
  </div>
<?php } ?>
</body>

</html>