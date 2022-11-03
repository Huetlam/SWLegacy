
<div class="container">

  <div class="row">
    <div class="col">
      <p class="display-4">Home</p>
    </div>
  </div>
  <div class="message">
    <div class="row">
      <div class="col-6">
          <h5 class="card-title">User Info:</h5>
          <?php
          $username = $_SESSION['session']['username'];
          $userID = $_SESSION['session']['userID'];
          $user_stmt = $dbconnect->prepare("SELECT user.*, faction.factionname FROM user JOIN faction ON user.factionID = faction.factionID WHERE userID = $userID");
          $user_stmt->execute();
          $user_result = $user_stmt->get_result();
          if ($user_result->num_rows==0) {
            $user1_stmt = $dbconnect->prepare("SELECT * FROM user WHERE userID = $userID");
            $user1_stmt->execute();
            $user1_result = $user1_stmt->get_result();
            $user_data = $user1_result->fetch_assoc();
            $faction = "None";

          }else {
            $user_data = $user_result->fetch_assoc();
            $faction = $user_data['factionname'];

          }
          $income = $user_data['income'];
          $upkeep = $user_data['upkeep'];
          $balance = $user_data['credits'];
          $balance = number_format($balance);
          $income = number_format($income);
          $upkeep = number_format($upkeep);

          echo " <p>Username: $username</p>";
          echo "<p class=''>Faction: $faction</p><p class='card-text'>Balance: $balance Credits</p><p class='card-text'>Credits per Turn: $income</p><p class='card-text'>Upkeep per Turn: $upkeep</p>";

          ?>
      </div>
      <div class="col-6">
          <h5 class="">Faction Info:</h5>


          <?php

          $faction_stmt = $dbconnect->prepare("SELECT user.factionID, faction.* FROM faction JOIN user ON user.factionID = faction.factionID WHERE userID = $userID");
          $faction_stmt->execute();
          $faction_result = $faction_stmt->get_result();
          if ($faction_result->num_rows==0) {

            $faction = "None";

          }else {
            $faction_data = $faction_result->fetch_assoc();
            $faction = $faction_data['factionname'];

          }
          $factionID = $faction_data['factionID'];
          $income = $faction_data['factionincome'];
          $planets_stmt = $dbconnect->prepare("SELECT planets.*, faction.factionID FROM planets JOIN faction on faction.factionID=planets.factionID WHERE faction.factionID = $factionID;");
          $planets_stmt->execute();
          $planets_result=$planets_stmt->get_result();
          if ($planets_result->num_rows==0) {
            $planets = 0;
            $capital = "None";

          }else {
            $planets = $planets_result->num_rows;
            $capital_stmt = $dbconnect->prepare("SELECT faction.factioncapital, planets.planetname FROM faction JOIN planets ON planetID = factioncapital WHERE faction.factionID = $factionID");
            $capital_stmt->execute();
            $capital_result = $capital_stmt->get_result();
            $capital_data = $capital_result->fetch_assoc();
            $capital = $capital_data['planetname'];
          }
          $factionimage = $faction_data['factionimg'];
          $income = number_format($income);
          echo "<p class='card-text'>Faction Name: $faction</p><p class='card-text'>Faction Income: $income Credits</p><p class='card-text'>Capital Planet: $capital </p><p class='card-text'>Planets Controlled: $planets</p>";

          ?>
      </div>
    </div>
    <!-- here -->
    <div class="row">
        <div class="countdown">
          <h1 class="countdown-title">Time till Next Round</h1>
          <div id="countdown" class="countdown">
        <div class="countdown-number">
          <span class="days countdown-time"></span>
          <span class="countdown-text">Days</span>
        </div>
        <div class="countdown-number">
          <span class="hours countdown-time"></span>
          <span class="countdown-text">Hours</span>
        </div>
        <div class="countdown-number">
          <span class="minutes countdown-time"></span>
          <span class="countdown-text">Minutes</span>
        </div>
        <div class="countdown-number">
          <span class="seconds countdown-time"></span>
          <span class="countdown-text">Seconds</span>
        </div>
      </div>

        </div>
      </div>
      </div>

</div>
