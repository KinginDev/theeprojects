@php
    $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Eproject is a payment solution that helps individuals to make and receive payment, pay bills and manage their finances across multiple banks on a single platform.">
    <title>{{ $configuration->site_name }}</title>
    <link rel="stylesheet" href="/assets/style/landpage.css">
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>


<body>

    <div class="main-body p-3">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-white">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('storage/' . $configuration->site_logo) }}" alt="Logo" width="150"
                        class="d-inline-block align-text-top">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto ms-0 ms-md-5 mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#service">Service</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact Us</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        <a href="#" class="btn p-2" style="color: {{ $configuration->template_color }};">Login</a>
                        <a href="#" class="btn text-white p-2"
                            style="background-color: {{ $configuration->template_color }};">Register</a>
                    </span>
                </div>
            </div>
        </nav>

        <div class="container mt-md-5">
            <br>
            <section id="home" class="mt-1 mt-md-3">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="hero-head" style="color: {{ $configuration->test_color }};">
                            {{ $configuration->site_name }} Easy <br>Payment
                        </div>
                        <p class="mt-3">Top up phone airtime or internet data. Pay electricity bills; renew TV
                            subscriptions. Buy quality insurance covers, pay education bills, transfer funds and do more
                            ...</p>

                        <a href="#" class="btn text-white get-started mt-3"
                            style="background-color: {{ $configuration->template_color }};">Login</a>
                        <a href="#" class="btn text-white get-started mt-3"
                            style="background-color: {{ $configuration->template_color }};">Register</a>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="h6 text-center mt-5 mt-md-0" style="color: {{ $configuration->test_color }};">Quick
                            Action</div>
                        <div class="qa mt-5">
                            <div class="row">
                                <!-- Quick Action Cards -->
                                <div class="col-4">
                                    <div class="card p-2 br-2">
                                        <a href="#" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center1"
                                            class="qbox">
                                            <div class="item-box">
                                                <i class="ri-phone-line"
                                                    style="color: {{ $configuration->template_color }};"></i>
                                            </div>
                                            <div class="text mt-2">
                                                <p class="text-dark">Airtime</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="card p-2 br-2">
                                        <a href="#" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center2"
                                            class="qbox">
                                            <div class="item-box">
                                                <i class="ri-wifi-line"
                                                    style="color: {{ $configuration->template_color }};"></i>
                                            </div>
                                            <div class="text mt-2">
                                                <p class="text-dark">Data</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="card p-2 br-2">
                                        <a href="#" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center3"
                                            class="qbox">
                                            <div class="item-box">
                                                <i class="ri-lightbulb-flash-line"
                                                    style="color: {{ $configuration->template_color }};"></i>
                                            </div>
                                            <div class="text mt-2">
                                                <p class="text-dark">Electricity</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="card p-2 br-2">
                                        <a href="#" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center4"
                                            class="qbox">
                                            <div class="item-box">
                                                <i class="ri-tv-line"
                                                    style="color: {{ $configuration->template_color }};"></i>
                                            </div>
                                            <div class="text mt-2">
                                                <p class="text-dark">Tv</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="card p-2 br-2">
                                        <a href="#" class="qbox">
                                            <div class="item-box">
                                                <i class="ri-grid-line"
                                                    style="color: {{ $configuration->template_color }};"></i>
                                            </div>
                                            <div class="text mt-2">
                                                <p class="text-dark">More</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <br>
            <section id="service" class="mt-5">
                <div class="h6 text-center hold-sub">
                    <div class="sub-title">Our Service</div>
                </div>
                <div class="h2 text-center mt-3" style="color: {{ $configuration->test_color }};">Explore Our endless
                    <span class="fw-bold">possibilities</span> of a payment <br>innovation.
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 sec2">
                        <img src="/assets/images/img2.png" width="550" id="sec2-img" alt="">
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <br>
                        <div class="h4 rt" style="color: {{ $configuration->test_color }};">Access to all Services</div>
                        <p class="mt-3">Access all VTU services, tools, analytics, support and many more from a single
                            dashboard as a normal user, reseller etc.</p>
                        <a href="#" class="btn text-white get-started mt-3"
                            style="background-color: {{ $configuration->template_color }};">Get Started</a>
                    </div>
                </div>

                <div class="row mt-5 flex-column-reverse flex-sm-row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="h4 rt" style="color: {{ $configuration->test_color }};">Achieve much more. Reach a
                            wider market</div>
                        <p class="mt-3">Provide your goods and services to an extended target of customers and
                            prospects, while monitoring all transactions from initiation to payment.</p>
                        <a href="{#" class="btn text-white get-started mt-3"
                            style="background-color: {{ $configuration->template_color }};">Get Started</a>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12 sec3">
                        <img src="/assets/images/Vector.png" alt="" class="mt-4 mt-md-0">
                    </div>
                </div>
            </section>

            <br>
            <section id="features" class="mt-5">
                <div class="h6 text-center hold-sub">
                    <div class="sub-title">Features</div>
                </div>
                <div class="h2 text-center mt-3" style="color: {{ $configuration->test_color }};">Pay bills and send
                    money without <span class="fw-bold">stress</span></div>
                <br>
                <p class="text-center text-gray">Securely make payments to suppliers, vendors, staff and other billers
                    into their accounts in any bank or mobile wallets, around-the-clock, including after official work
                    hours, weekends and public holidays.</p>
                <div class="text-center feature">
                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/aedc.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/dstv.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/eedc.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/ekiti.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/gotv.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/ikeja.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/ibedc.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/jos.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/phedc.png" alt="">
                    </div>
                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/startimes.png" alt="">
                    </div>

                    <div class="card p-2 fea-item">
                        <img src="/assets/images/companies/swift.png" alt="">
                    </div>
                </div>
            </section>

            <br>
            <section id="contact" class="mt-5">
                <div class="container">
                    <div class="text-center mb-4">
                        <h2 class="sub-title text-uppercase fw-bold"
                            style="color: {{ $configuration->template_color }};">Contact Us</h2>
                        <p>We have provided multiple support channels to help you get what you need.</p>
                    </div>
                    <div class="row">
                        <!-- Contact Form -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <form class="p-4 border rounded shadow-sm"
                                style="border-color: {{ $configuration->template_color }};">
                                <div class="mb-3">
                                    <label for="contactName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="contactName" placeholder="Your Name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="contactEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="contactEmail" placeholder="Your Email"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="contactMessage" class="form-label">Message</label>
                                    <textarea class="form-control" id="contactMessage" rows="4"
                                        placeholder="Your Message" required></textarea>
                                </div>
                                <button type="submit" class="btn w-100"
                                    style="background-color: {{ $configuration->template_color }}; color: white;">Send
                                    Message</button>
                            </form>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="p-4 border rounded shadow-sm h-100"
                                style="border-color: {{ $configuration->template_color }};">
                                <h4 class="fw-bold" style="color: {{ $configuration->template_color }};">Get in Touch
                                </h4>
                                <p>We'd love to hear from you! Whether you have a question, feedback, or need support,
                                    feel free to reach out.</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"
                                            style="color: {{ $configuration->template_color }};"></i><strong>Address:</strong>
                                        {{$configuration->company_address}}</li>
                                    <li class="mb-2"><i class="bi bi-envelope-fill me-2"
                                            style="color: {{ $configuration->template_color }};"></i><strong>Email:</strong>
                                        {{$configuration->company_email}}</li>
                                    <li class="mb-2"><i class="bi bi-telephone-fill me-2"
                                            style="color: {{ $configuration->template_color }};"></i><strong>Phone:</strong>
                                        {{$configuration->company_phone}}</li>
                                </ul>
                                <div class="social-links mt-3">
                                    <a href="#" class="text-dark me-3"><i class="bi bi-facebook"
                                            style="color: {{ $configuration->template_color }};"></i></a>
                                    <a href="#" class="text-dark me-3"><i class="bi bi-twitter"
                                            style="color: {{ $configuration->template_color }};"></i></a>
                                    <a href="#" class="text-dark"><i class="bi bi-instagram"
                                            style="color: {{ $configuration->template_color }};"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="text-white py-4 mt-5" style="background-color: {{ $configuration->template_color }};">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">&copy; 2025 {{ $configuration->site_name }}. All Rights Reserved.</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="#" class="text-white me-2">Privacy Policy</a>
                            <a href="#" class="text-white">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Bootstrap JS and other scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
            integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
    </div>
</body>

</html>