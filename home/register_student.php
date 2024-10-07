<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BelajarSkuy</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Fonts -->
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="styles/register.css" />
  </head>
  <body>
    <header>
      <a href="index.html"><img src="../images/home (1).png" alt="logo menu home" /></a>
    </header>
    <main>
        <div class="image">
            <h2>Your Learning Journey Starts Here!</h2>
            <img src="../images/logo.png" alt="logo belajarskuy">
        </div>
        <form action="">
            <h1>Create Student Account</h1>
            <div class="form-row">
                <div class="input-data">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" required>
                </div>
                <div class="input-data">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <label for="birth-date">Birth</label>
                    <input type="date" id="birth-date" name="birth-date" required>
                </div>
                <div class="input-data">
                    <label for="school">School</label>
                    <input type="text" id="school" name="school" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data email">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" required>
                </div>
                <div class="input-data">
                    <label for="confirmation-password">Confirmation Password</label>
                    <input type="password" id="confirmation-password" name="confirmation-password" autocomplete="new-password" required>
                </div>
            </div>
            <div class="form-row">
                <div class="create-btn">
                    <button type="submit">Create Account</button>
                </div>
            </div>
            <div class="links">Already have an account? <a href="login.php">Login</a></div>
        </form>
    </main>
  </body>
</html>
