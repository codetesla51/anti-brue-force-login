<?php include "../controllers/file_contr.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Form</title>
  
</head>
<body>
  <form id="loginForm" class="form">
    <div class="header">
      <h2>Welcome Back</h2>
      <p>Please provide details to login into your account</p>
    </div>
    <div class="input_field">
      <label for="email">Enter Username</label>
      <input type="text" placeholder="Enter Username" name="uname" id="uname">
    </div>
    <div class="input_field">
      <label for="pass">Enter Password</label>
      <input type="password" placeholder="Enter Password" name="pass" id="pass">
      <i class="fa fa-eye"></i>
    </div>
    <div class="forgot"><a href="forgot_pass.php">Forgot password?</a></div>
    <button type="submit" class="log">Login</button>
    <div class="account">Don't have an account?&nbsp;<a href="sign_up.php">Sign up now</a></div>
  </form>

</body>
</html>