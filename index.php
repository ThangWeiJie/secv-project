<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Space Booking System</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background: #ffffff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-container h2 {
      text-align: center;
      color: #1e3a8a;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #334155;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #cbd5e1;
      border-radius: 6px;
      font-size: 16px;
    }

    .form-group input:focus {
      border-color: #3b82f6;
      outline: none;
    }

    .error-message {
      color: red;
      font-size: 14px;
      margin-top: -10px;
      margin-bottom: 10px;
      display:
        <?php
          if(isset($_GET["err"])) {
            echo "block";
          } else {
            echo "none";
          }
        ?>;
    }

    .login-btn {
      width: 100%;
      padding: 12px;
      background-color: #3b82f6;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .login-btn:hover {
      background-color: #2563eb;
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2>Login</h2>
  <form method="POST" action="loginverify.php" id="loginForm"> 
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" required>
    </div>
    <div class="error-message" id="errorMessage">Invalid username or password</div>
    <button type="submit" class="login-btn">Login</button>
  </form>
</div>

</body>
</html>
