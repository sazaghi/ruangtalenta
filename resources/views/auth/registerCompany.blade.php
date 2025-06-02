<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ruang Talenta</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
}

body {
  background: #0b0b0b;
  color: white;
}


.auth {
  margin-left: auto;
  display: flex;
}

.auth a {
  color: white;
  text-decoration: none;
  margin: 0 10px;
  font-size: 0.95em;
}

.hero {
  display: flex;
  height:100vh;
  background: url('{{ asset('images/bg-perusahaan.png') }}') center/cover no-repeat;
}

.left, .right {
  flex: 1;
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.left {
  background: rgba(0,0,0,0.5);
  color: white;
}

.left h1 {
  font-size: 2.5em;
  margin-bottom: 10px;
}

.left p {
  color: #ffb62c;
  max-width: 400px;
}

.right {
  background: rgba(0,0,0,0.7);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.right h2 {
  color: #fbb034;
  font-size: 2em;
  margin-bottom: 40px;
  text-align: center;
}

form {
  background: transparent;
  display: flex;
  flex-direction: column;
  width: 70%;
}

.input-group {
  display: flex;
  align-items: center;
  background: #e2e2e2;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 15px;
  width: 100%;
}

.input-group i {
  color: #000;
  margin-right: 10px;
}

.input-group input {
  border: none;
  outline: none;
  width: 100%;
  background: transparent;
  font-size: 1em;
  height: 15px;
}

form small {
  font-size: 0.75em;
  margin-bottom: 10px;
}

form a {
  color: #fff;
  text-decoration: underline;
}

form button {
  background: #1532B4;
  color: white;
  border: none;
  padding: 12px;
  border-radius: 5px;
  font-size: 1em;
  cursor: pointer;
  margin-bottom: 10px;
}

.login-text {
  font-size: 0.85em;
  text-align: center;
  margin-top: 20px;
}

.login-text a {
  color: #4285f4;
  text-decoration: none;
}

/* Responsive */
@media (max-width: 768px) {
  .hero {
    flex-direction: column;
  }

  .left, .right {
    padding: 20px;
    text-align: center;
  }

  .left h1 {
    font-size: 1.8em;
  }

  .right h2 {
    font-size: 1.5em;
  }
}

  </style>
</head>
<body>
  <main class="hero">
    <section class="left">
      <h1>Welcome to Your <br><strong>Business Growth Hub</strong></h1>
      <p>Create your company account today and unlock powerful tools to manage, grow, and elevate your business presence.</p>
    </section>
    <section class="right">
      <h2>Ruang Talenta</h2>
      @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
          <ul style="list-style: none; padding-left: 0;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('success'))
        <div style="color: green; margin-bottom: 20px;">
          {{ session('success') }}
        </div>
      @endif
      <form method="POST" action="{{ route('register.perusahaan') }}">
        @csrf
        <div class="input-group">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" viewBox="0 0 24 24" style="margin-right: 10px;">
            <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
          </svg>
          <input type="text" name="name" placeholder="Full name" required>
        </div>

        <div class="input-group">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" viewBox="0 0 24 24" style="margin-right: 10px;">
            <path d="M12 13.065 1.5 6.75V18a1.5 1.5 0 0 0 1.5 1.5h18a1.5 1.5 0 0 0 1.5-1.5V6.75L12 13.065zM12 11 22.5 4.5h-21L12 11z"/>
          </svg>
          <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" viewBox="0 0 24 24" style="margin-right: 10px;">
            <path d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24a11.72 11.72 0 0 0 3.69.59c.55 0 1 .45 1 1v3.5c0 .55-.45 1-1 1C9.39 21.25 2.75 14.61 2.75 6c0-.55.45-1 1-1H7.5c.55 0 1 .45 1 1 0 1.28.21 2.52.59 3.69.11.35.03.75-.24 1.02l-2.23 2.08z"/>
          </svg>
          <input type="text" name="phone" placeholder="Phone number" required>
        </div>

        <small>You agree to Onyx <a href="#">Terms</a> and <a href="#">Privacy</a></small>
        <button type="submit" class="btn">Register</button>
        <p class="login-text">Already have an account? <a href="{{ route('login') }}">Login</a></p>
      </form>

    </section>
  </main>
</body>
</html>
