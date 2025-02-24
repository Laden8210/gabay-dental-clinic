<section id="hero" class="d-flex align-items-center bg-light">

    <div class="container">
        <div class="row">
            <div class="col-lg-7 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1">
                <h1 class="text-dark animate__animated  animate__fadeInDown">Gabay Dental Clinic</h1>
                <h2 class="text-secondary">Bringing joy to every smile, because your oral
                health matters.</h2>


                <div class="d-flex gap-2">
                    <a href="" class="btn btn-primary rounded-pill"><i class="fa fa-download"
                            aria-hidden="true"></i> Download Now</a>

                </div>
            </div>
            <div class="col-lg-5 order-1 order-lg-2 hero-img d-flex justify-content-center align-items-center">
                <div class="position-relative">
                    <!-- Overlayed Card -->
                    <div class="card position-absolute shadow-lg"
                        style="z-index: 2; transform: translate(30px, 20px); top: 30px;
                    right: 150px; overflow: hidden;">
                        <div class="card-body p-2">
                            <img src="assets/img/mobile-login.png" alt="" width="200px"
                                class="overlay-img">
                        </div>
                    </div>

                    <!-- Base Card -->
                    <div class="card shadow-sm overflow-hidden" style="z-index: 1;">
                        <div class="card-body p-2">
                            <img src="assets/img/mobile-login.png" alt="" width="200px"
                                class="overlay-img">
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .overlay-img {
                    transition: transform 0.3s ease-in-out;
                }

                .overlay-img:hover {
                    transform: scale(1.1);
                }
            </style>

        </div>
    </div>

</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-white">
    <div class="container text-center">
        <h2 class="text-primary">App Features</h2>
        <div class="row mt-4">
            <div class="col-lg-4">
                <div class="card p-3 shadow-sm">
                    <i class="fas fa-wifi fa-3x text-primary"></i>
                    <h5 class="mt-3">Offline Mode</h5>
                    <p class="text-muted">Supports offline attendance tracking for areas with low internet connectivity.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-3 shadow-sm">
                    <i class="fa fa-sync fa-3x text-primary"></i>
                    <h5 class="mt-3">Auto-Sync</h5>
                    <p class="text-muted">Attendance data syncs automatically once the device is online.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-3 shadow-sm">
                    <i class="fa fa-file-alt fa-3x text-primary"></i>
                    <h5 class="mt-3">Reports & Insights</h5>
                    <p class="text-muted">Generate real-time attendance reports for better monitoring.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="about" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="assets/img/mobile-login.png" alt="About System" class="img-fluid rounded shadow" width="240px">
            </div>
            <div class="col-lg-6">
                <h2 class="text-primary">About the System</h2>
                <p class="text-muted">
                Elevate your dental experience at Gabay Dental Clinic, your gateway to optimal oral health and radiant smiles. Located at General Recarte St. Brgy. Poblacion Mariveles, Bataan our clinic is a testament to precision, care, and innovation in dentistry. Our clinic welcomes you to a haven where your dental needs are met with unwavering dedication. Beyond providing exceptional clinical care, our clinic is designed to offer a soothing environment that transforms your dental visits into uplifting experiences. Come, contact us now, and be a part of our dental family, where your journey to a brighter smile begins!
                </p>
                <p class="text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus iusto provident id odit? Dolorem libero minus, quas voluptatum ex adipisci praesentium culpa ab delectus laborum magnam officia porro veritatis omnis.
                </p>
                <a href="#" class="btn btn-outline-primary">Learn More</a>
            </div>
        </div>
    </div>
</section>




<!-- Contact Us -->

<section id="contact" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-primary text-center">Contact Us</h2>
        <p class="text-muted text-center">Need help? Get in touch with us!</p>

        <div class="row mt-4">
            <!-- Left Side: Contact Information -->
            <div class="col-lg-6">
                <div class="p-4  rounded">
                    <h4 class="text-primary">Get in Touch</h4>
                    <p class="text-muted">Feel free to reach out to us through any of the channels below.</p>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-phone fa-2x text-primary me-3"></i>
                        <p class="mb-0">+63 912 345 6789</p>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-envelope fa-2x text-primary me-3"></i>
                        <p class="mb-0">support@dental.com</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-map-marker-alt fa-2x text-primary me-3"></i>
                        <p class="mb-0">General Santos City, Philippines</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Contact Form -->
            <div class="col-lg-6">
                <div class="p-4 bg-white shadow-sm rounded">
                    <h4 class="text-primary">Send Us a Message</h4>
                    <form method="POST">
               
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Your Message" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- Footer Section -->
<footer class="bg-light text-light py-4">
    <div class="container">
        <div class="row">
            <!-- About -->
            <div class="col-lg-4">
                <h5 class="text-primary">About Gabay Dental Clinic</h5>
                <p class="text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores quasi ipsam unde laudantium illum, soluta sed? Corporis cumque tempore suscipit maxime consequatur repellat eaque explicabo, repellendus harum, voluptatum saepe!
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-4">
                <h5 class="text-primary">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#hero" class="text-dark">Home</a></li>
                    <li><a href="#features" class="text-dark">Features</a></li>
                    <li><a href="#how-it-works" class="text-dark">How It Works</a></li>
                    <li><a href="#contact" class="text-dark">Contact Us</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4">
                <h5 class="text-primary">Contact Us</h5>
                <p class="mb-1"><i class="fa fa-phone me-2"></i> +63 912 345 6789</p>
                <p class="mb-1"><i class="fa fa-envelope me-2"></i> gabay-dental@gmail.com</p>
                <p><i class="fa fa-map-marker-alt me-2"></i> Philippines</p>

                <!-- Social Media Links -->
                <div class="mt-3">
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-instagram fa-2x"></i></a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-4">
            <p class="mb-0">&copy; 2025 Gabay Dental Clinic. All Rights Reserved.</p>
        </div>
    </div>
</footer>