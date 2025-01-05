<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Login</title>
    <script src="https://kit.fontawesome.com/8d62d56333.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<style>

</style>

<body class="bg-light p-0 m-0">

    <main>
        <div class="row w-100 justify-content-center align-items-center p-10">

            <div class="col-md-6">
                <div class="w-75 m-auto">
                    <div class="card shadow-lg ">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-4">Login</h3>

                            <form class="login-form" action="admin">
                                <!-- Username -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-user "></i>
                                        </span>

                                        <input type="text" class="form-control" id="username" placeholder="Enter username" required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-user "></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Remember Me and Forgot Password -->
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <input type="checkbox" id="rememberMe"> <label for="rememberMe">Remember Me</label>
                                    </div>
                                    <a href="#">Forgot Password?</a>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Section (Hidden on Small Screens) -->
            <div class="col-md-6 d-none d-md-block bg-info text-center">
                <img src="src/img/heroClinic.png" alt="Login Image" class="img-fluid"> <!-- Replace with your image path -->
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>

</body>

</html>