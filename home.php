<section class="text-center position-relative d-flex flex-column justify-content-center align-items-center p-5 bg-transparent" style="height: 100vh;">
    <img src="src/img/logo11.png" alt="" class="img-fluid" style="max-width: 100%; height: auto; max-width: 400px;">
    <div class="position-relative mt-4">
        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#appointmentModal">Make an Appointment</button>
    </div>
</section>


<section class="py-5 service h-100" style="height: 100vh; background-color: rgba(255, 255, 255, 0.7);">
    <div class="container text-center">
        <h2 class="display-4 mb-4 text-info fw-semibold">OUR SERVICES</h2>
        <h1 class="display-3 mb-5">Exceeding expectations, our services are a testament to dedication and excellence.</h1>

        <div class="row g-4">
            <div class="col-md-4 col-12">
                <div class="border-light rounded">
                    <img src="src/img/initialConsultation.png" alt="Consultation" class="service-icon img-fluid">
                    <div class="card-body">
                        <h4 class="service-title">Consultation</h4>
                        <p class="service-text">Our comprehensive consultation services involve thorough oral examinations and personalized treatment plans to address your dental concerns effectively.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 service h-100" style="height: 100vh; background-color: rgba(255, 255, 255, 1); display: flex; justify-content: center; align-items: center;">
    <div class="container text-center">
        <h2 class="display-4 mb-4 text-info fw-semibold">OUR CLINIC</h2>
        <h1 class="display-3 mb-5">Bringing joy to every smile, because your oral health matters.</h1>

        <div class="row g-4 d-flex align-items-center justify-content-center">
            <div class="col-md-6 d-flex justify-content-center">
                <img src="src/img/clinic-img.png" alt="" class="img-fluid">
            </div>

            <div class="col-md-6">
                <p>
                    Elevate your dental experience at Gabay Dental Clinic, your gateway to optimal oral health and radiant smiles. Located at General Recarte St. Brgy. Poblacion Mariveles, Bataan, our clinic is a testament to precision, care, and innovation in dentistry. Our clinic welcomes you to a haven where your dental needs are met with unwavering dedication. Beyond providing exceptional clinical care, our clinic is designed to offer a soothing environment that transforms your dental visits into uplifting experiences. Come, contact us now, and be a part of our dental family, where your journey to a brighter smile begins!
                </p>
            </div>
        </div>
    </div>
</section>


<section class="py-5 service h-100" style="height: 100vh; background-color: rgba(255, 255, 255, 1); display: flex; justify-content: center; align-items: center;">
    <div class="container text-center">
        <h2 class="display-4 mb-4 text-info fw-semibold">CONTACT</h2>
        <h1 class="display-3 mb-5">Bringing joy to every smile, because your oral health matters.</h1>

        <div class="row g-4 d-flex align-items-center">

            <div class="col-md-6 col-12 d-flex justify-content-center flex-column align-items-center">
                <div class="row w-100">
                    <div class="col-12 col-md-4 mb-3  justify-content-center align-items-center">
                        <img src="src/img/location.png" alt="" class="contact-icon mb-2" style="max-width: 50px;">
                        <p>90 General Recarte St., Brgy Poblacion, Mariveles, Bataan, Philippines</p>
                    </div>
                    <div class="col-12 col-md-4 mb-3 justify-content-center align-items-center">
                        <img src="src/img/location.png" alt="" class="contact-icon mb-2" style="max-width: 50px;">
                        <p>+63 (947) 582 0065</p>
                    </div>
                    <div class="col-12 col-md-4 mb-3  justify-content-center align-items-center">
                        <img src="src/img/location.png" alt="" class="contact-icon mb-2" style="max-width: 50px;">
                        <p>Mon-Wed 9:00AM - 5:00PM <br> Sat-Sun 9:00AM - 5:00PM</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3863.89653150632!2d120.4825840737604!3d14.433125981157696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33961f5fcdbe68b5%3A0xb1c8cdb5385d4080!2sGabay%20Dental%20Clinic!5e0!3m2!1sen!2sph!4v1719472296197!5m2!1sen!2sph" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>



<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Select Patient Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-12 ">
                        <button class="btn btn-primary btn-lg w-100 mb-3" data-bs-toggle="modal" data-bs-target="#oldPatientModal" data-bs-dismiss="modal">Old Patient</button>
                    </div>
                    <div class="col-12 ">
                        <button class="btn btn-secondary btn-lg w-100 mb-3" data-bs-toggle="modal" data-bs-target="#newPatientModal" data-bs-dismiss="modal">New Patient</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="oldPatientModal" tabindex="-1" aria-labelledby="oldPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="oldPatientModalLabel">Old Patient Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newPatientModal" tabindex="-1" aria-labelledby="newPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPatientModalLabel">New Patient Signup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/signup" method="POST">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="e.g. Juan" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="e.g. Dela Cruz" required>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" placeholder="e.g. 18" required>
                    </div>
                    <div class="mb-3">
                        <label for="sex" class="form-label">Sex</label>
                        <select class="form-select" id="sex" name="sex" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mobileNumber" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="mobileNumber" name="mobileNumber" placeholder="e.g. 09**-****-***" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="e.g. sample@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="e.g. National Highway, Sta Rita, Batangas City, Batangas, Philippines" required>
                    </div>
                    <div class="mb-3">
                        <label for="occupation" class="form-label">Occupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" placeholder="e.g. Teacher" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordSignup" class="form-label">Password</label>
                        <input type="password" class="form-control" id="passwordSignup" name="password" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="certificationCheck" required>
                            <label class="form-check-label fs-6" for="certificationCheck">
                                Before I proceed to checking time availability of my appointment request, I hereby certify that the information provided is complete, true, and correct to the best of my knowledge.
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</div>