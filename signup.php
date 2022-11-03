<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css">  
    <link rel="stylesheet" href="customlogin.css">
    <link rel="icon" type="image/x-icon" href="uploads\icon.png">
    <title>Signup</title>
  </head>
  <body>
    <form class="signup" action="newuser.php" method="post">
      <h2 class="title">Sign Up</h2>
      <input type="text" name="username" placeholder="Username" maxlength="40" required>
      <input type="password" name="password" placeholder="Password" maxlength="40" required>
      <input type="email" name="email" placeholder="Email" maxlength="80" required>
      <input list="faction" required id="factionDataList" name="faction" placeholder="Faction...">
        <datalist id="faction">
          <option value="Rebel Alliance"></option>
          <option value="Galactic Empire"></option>
        </datalist>
      <input type="submit" name="submit">
      <a href="login.php">Sign In</a>
    </form>
  </body>
</html>
