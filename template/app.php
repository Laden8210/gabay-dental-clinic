<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>


    <link href="src/css/app.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="src/js/app.js"></script>
</head>

<body style="background-image: url('src/img/background.png'); background-size: cover;background-attachment: fixed;">

    <div id="preloader">
        <div class="loader-container">
            <img src="src/img/logo11.png" alt="Lakbay Philippine Logo" class="loader-logo">
            <p class="loader-text">Gabay Dental Clinic</p>
        </div>
    </div>

    <header id="header" class="fixed-top animate__animated  animate__fadeInDown shadow">
        <div class="container d-flex align-items-center justify-content-between px-4">
            <div>
                <a href="/" class="d-flex align-items-center">
                    <img src="src/img/logo11.png" alt="Logo" style="height: 32px;">

                </a>
            </div>


            <nav class="d-none d-md-flex">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold"
                            href="#">Home</a>
                    </li>
              
                    <li class="nav-item border-r-1">
                        <a class="nav-link  fw-semibold'"
                            href="#">About</a>
                    </li>
                </ul>
            </nav>


            <div class="d-flex align-items-center">
                <a href="login.php" class="btn btn-primary rounded-pill ">Login Now</a>
            </div>

        </div>
    </header>


    <main>
        <?php require_once $content; ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>