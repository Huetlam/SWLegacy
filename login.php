<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="icon" type="image/x-icon" href="uploads\icon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="customlogin.css">

</head>
  <body>

  <form class="login" action="loggingin.php" method="post">
    <h2 class="title">Welcome</h2>
    <img src="uploads/icon.png" alt="Logo" class="logo">
    <input type="text" name="username" placeholder="Enter Username" required maxlength="30">
    <input type="password" name="password" placeholder="Enter Password" required maxlength="15">
    <input type="submit" name="submit">
    <a href="signup.php">Make an Account</a>

  </form>






    
  </body>
</html>



