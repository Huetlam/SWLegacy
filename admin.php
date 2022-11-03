<?php
$approve_stmt = $dbconnect->prepare("SELECT * FROM `user`");
$approve_stmt->execute();
$approve_result = $approve_stmt->get_result();
$approve_data = $approve_result->fetch_assoc();
// include 'navbar.php';
?>

<nav class="navbar navbar-expand-lg bg-prussian">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="index.php?page=userhome">Star Wars: Legacy</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active text-light" aria-current="page" href="index.php?page=createplanet">New Planet</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=createsector">New Sector</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=createfaction">New Faction</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=roles">Roles</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=editshop">Edit Shop</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=adminapprove">New Users</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php">|</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=inv">Inventory</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=shop">Shop</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=regions">Planets</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=fleets">Fleets</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php?page=battles">Battles</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="#">|</a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="logout.php">Log Out</a>

        </li>
      </ul>
    </div>
  </div>
</nav>
<!--
<div class="row bg-light ">

  <div class="col-2 bg-primary">
    Online GSRPG
  </div>
  <div class="col-2">
  </div>
  <div class="col-2">
    <a href="">New Faction</a>
  </div>
  <div class="col-2">
    <a href="">New Unit</a>
  </div>
  <div class="col-2">
    <a href="index.php?page=editshop">Edit Shop</a>
  </div>
</div>

<a href="editshop.php">Edit Shop</a> -->
