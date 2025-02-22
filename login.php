<?php

session_start();


if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin');
        exit;
    } else if ($_SESSION['role'] === 'employee') {
        header('Location: employee');
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>


    <link href="src/css/app.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="src/js/app.js"></script>
</head>

<body>

    <div id="preloader">
        <div class="loader-container">
            <img src="src/img/logo11.png" alt="Lakbay Philippine Logo" class="loader-logo">
            <p class="loader-text">Gabay Dental Clinic</p>
        </div>
    </div>


    <section class="d-flex align-items-center vh-100">
        <div class="filter"></div>
        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Left Side: Carousel -->
                <div class="col-lg-6  d-flex flex-column justify-content-center align-items-center p-0 position-relative">

                    <div class="carousel-login w-100 h-100 position-relative">
                        <!-- Overlay with Opacity -->
                        <div class="carousel-overlay"></div>

                        <div class="carousel-slide active" style="background-image: url('src/img/background.png');"></div>



                        <div class="carousel-quote text-white text-center px-4 d-none">
                            <h2 class="fw-bold">Discover Your Dream Stay with Lakbay PH</h2>
                            <p class="mt-2">
                                Looking for the perfect getaway? <strong>Lakbay PH</strong> connects you with stunning vacation rentals, unique stays, and short-term accommodations across the Philippines.
                                Whether it’s a beachfront villa, a cozy cabin, or a city escape, find your ideal stay in just a few clicks.
                                Start your journey today and experience hassle-free booking like never before!
                            </p>
                        </div>

                    </div>
                </div>


                <div class="col-lg-6 d-flex justify-content-center align-items-center ">
                    <div class="login-form bg-white rounded w-100" style="max-width: 400px;">
                        <div class="text-center mb-2">
                            <img src="src/img/logo11.png" alt="Logo" class="img-fluid " style="max-width: 170px;">
                        </div>

                        <form id="login-form" class="text-start">
                            <div id="login-alert" class="alert d-none"></div>

                            <div class="mb-2">
                                <label for="email" class="form-label text-black">Email</label>
                                <div class="input-group">

                                    <input type="email" class="form-control" id="email" placeholder="Enter your email">
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label text-black">Password</label>
                                <div class="input-group">

                                    <input type="password" class="form-control" id="password" placeholder="Enter your password">
                                </div>
                            </div>




                            <div class="d-grid">
                                <button type="submit" id="login-btn" class="btn btn-primary">Login</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function sanitizeInput(input) {
            return $("<div>").text(input).html();
        }
        $(document).ready(function() {
            $("#login-form").submit(function(e) {
                e.preventDefault();



                let email = sanitizeInput($("#email").val().trim());
                let password = sanitizeInput($("#password").val().trim());

                let loginBtn = $("#login-btn");
                let alertBox = $("#login-alert");

                if (email === "" || password === "") {
                    showMessage("danger", "Both fields are required.");
                    return;
                }

                loginBtn.prop("disabled", true).text("Logging in...");

                $.ajax({
                    url: "login-process.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        email: email,
                        password: password
                    }),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showMessage("success", response.success);
                            setTimeout(() => {
                                if (response.role === "Admin") {
                                    window.location.href = "admin";
                                } else if (response.role === "Employee") {
                                    window.location.href = "employee";
                                } else {
                                    window.location.href = "index.php";
                                }
                            }, 1500);
                        } else {
                            showMessage("danger", response.error);
                            loginBtn.prop("disabled", false).text("Login");
                        }
                    },

                    error: function(xhr, status, error) {
                        let errorMessage = "An error occurred. Please try again.";
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        showMessage("danger", errorMessage);
                        loginBtn.prop("disabled", false).text("Login");
                    }
                });
            });

            function showMessage(type, message) {
                let alertBox = $("#login-alert");
                alertBox.removeClass("d-none alert-success alert-danger").addClass("alert-" + type).text(message);
            }
        });
    </script>


</body>

</html>