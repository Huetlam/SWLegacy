<?php
include 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Legacy</title>
    <link rel="icon" type="image/x-icon" href="uploads\icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="customform.css">
    <style>
          @font-face { font-family: aurebesh; src: url('GalacticBasic/GalacticBasic-rznB.ttf'); }
          .aurebesh {
            font-family: aurebesh;
          }
        </style>

  </head>

  <body style="background-color: #2c2f33;">

    <?php
    session_start();
      if (!isset($_SESSION['session']['username'])) {
        header('Location: login.php?error=session');

      }else {
        if ($_SESSION['session']['level']==2) {
          include 'admin.php';
          if (isset($_GET['page'])) {
            $page = $_GET['page'];
            include "$page.php";
          }else {
            include 'userhome.php';
          }
        }elseif ($_SESSION['session']['level']==1) {
          include 'usernav.php';
          if (isset($_GET['page'])) {
            $page = $_GET['page'];
            include "$page.php";
          }else {
            include 'userhome.php';
          }
        }

        else {
          include 'approval.php';
        }
      }
    ?>
    <script src="js/bootstrap.js"></script>

  </body>
  <script type='text/javascript'>
  function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor((t / 1000) % 60);
    var minutes = Math.floor((t / 1000 / 60) % 60);
    var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
      total: t,
      days: days,
      hours: hours,
      minutes: minutes,
      seconds: seconds
    };
  }

  function initializeClock(id, endtime) {
    var clock = document.getElementById(id);
    var daysSpan = clock.querySelector(".days");
    var hoursSpan = clock.querySelector(".hours");
    var minutesSpan = clock.querySelector(".minutes");
    var secondsSpan = clock.querySelector(".seconds");

    function updateClock() {
      var t = getTimeRemaining(endtime);

      if (t.total <= 0) {
        clearInterval(timeinterval);

        var newTime = Date.parse(endtime);
        var nowTime = Date.parse(new Date());

        while (newTime <= nowTime) {
          newTime = newTime + 1 * 24 * 60 * 60 * 1000; // add 24hours

        }

        var deadline = new Date(newTime);
        initializeClock('countdown', deadline);
      } else {
        daysSpan.innerHTML = t.days;
        hoursSpan.innerHTML = ("0" + t.hours).slice(-2);
        minutesSpan.innerHTML = ("0" + t.minutes).slice(-2);
        secondsSpan.innerHTML = ("0" + t.seconds).slice(-2);
      }
    }


    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
  }

  var deadline = "December 7 2019 12:00:00 GMT+1200";
  initializeClock("countdown", deadline);
  </script>
</html>
