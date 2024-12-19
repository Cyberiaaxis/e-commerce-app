<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>The Daily Dose Cafe</title>
    <!--
    
TemplateMo 558 Klassy Cafe

https://templatemo.com/tm-558-klassy-cafe

-->
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.css') }}">

    <link rel="stylesheet" href="{{ asset('css/templatemo-klassy-cafe.css') }}">

    <link rel="stylesheet" href="{{ asset('css/owl-carousel.css') }}">

    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
    <style>
        .hover-scale:hover {
            transform: scale(1.05);
            /* Slightly enlarge the image */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            /* Add shadow effect */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* Smooth transition */
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        @include('Customer.partials.header')
    </header>
    <!-- ***** Header Area End ***** -->
    <!-- ***** Main Banner Area Start ***** -->
    <div id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="left-content">
                        <div class="inner-content">
                            <h4>The Daily Dose Cafe</h4>
                            <h6>THE BEST EXPERIENCE</h6>
                            <div class="main-white-button scroll-to-section">
                                <a href="#reservation">Make A Reservation</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="main-banner header-text">
                        <div class="Modern-Slider">
                            @foreach($sliders as $slider)
                            <div class="item">
                                <div class="img-fill">
                                    <img src="{{ asset( $slider->image_path) }}" alt="{{ $slider->title }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** About Area Starts ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>About Us</h6>
                            <h2>We Leave A Delicious Memory For You</h2>
                        </div>
                        <p>The Daily Dose Cafe is one of the best
                            <a href="https://dailydosecafe.com" target="_blank" rel="sponsored">restaurant</a>
                        </p>

                        <div class="row border rounded shadow p-5 bg-light">
                            @foreach($topOrderedProducts as $topOrderedProduct)
                            <div class="col-4">
                                <div class="ratio ratio-4x3">
                                    <img src="{{ asset('storage/images/' . $topOrderedProduct['image']) }}" alt="" class="img-fluid border rounded shadow transition hover-scale">
                                </div>
                            </div>
                            @endforeach
                        </div>



                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="right-content">
                        <div class="thumb">
                            <a rel="nofollow" href="http://youtube.com"><i class="fa fa-play"></i></a>
                            <img src="{{ asset('images/about-video-bg.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** About Area Ends ***** -->

    <!-- ***** Menu Area Starts ***** -->
    <section class="section" id="menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-heading">
                        <h6>Our Menu</h6>
                        <h2>Our selection with quality taste</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="owl-menu-item owl-carousel">
            @foreach($products as $product)
            <div class="item">
                <div class="card card3" style="background-image: url('{{ asset('storage/images/' . $product->image) }}');">

                    <div class="price">
                        <h6>${{ number_format($product->price, 2) }}</h6>
                    </div>
                    <div class="info">
                        <h1 class="title">{{ $product->name }}</h1>
                        <p class="description">{{ $product->description }}</p>
                        <div class="main-text-button">
                            <div class="scroll-to-section">
                                <a href="#reservation">Make Reservation <i class="fa fa-angle-down"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </section>
    <!-- ***** Menu Area Ends ***** -->

    <!-- ***** Chefs Area Starts ***** -->
    <section class="section" id="chefs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4 text-center">
                    <div class="section-heading">
                        <h6>Our Chefs</h6>
                        <h2>We offer the best ingredients for you</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($chefs as $chef)
                <div class="col-lg-4">
                    <div class="chef-item">
                        <div class="thumb">
                            <div class="overlay"></div>
                            <ul class="social-icons">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                            <img src="{{ asset('storage/' . $chef->image) }}" alt="{{ $chef->name }}">
                        </div>
                        <div class="down-content">
                            <h4>{{ $chef->name }}</h4>
                            <span>{{ $chef->specialty }}</span>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- ***** Chefs Area Ends ***** -->

    <!-- ***** Reservation Us Area Starts ***** -->
    <section class="section" id="reservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Contact Us</h6>
                            <h2>Here You Can Make A Reservation Or Just walkin to our cafe</h2>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="phone">
                                    <i class="fa fa-phone"></i>
                                    <h4>Phone Numbers</h4>
                                    <span><a href="#">+91-9873251605</a><br><a href="#">+91-9354447905</a></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="message">
                                    <i class="fa fa-envelope"></i>
                                    <h4>Emails</h4>
                                    <span><a href="#">dailydose.vrs@gmail.com</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="alert alert-success">
                            {{ session('error') }}
                        </div>
                        @endif
                        <form id="contact" action="{{ route('reservations.store') }}" method="post">
                            @csrf <!-- CSRF token for security -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>Table Reservation</h4>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" id="name" placeholder="Your Name*" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email Address" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="phone" type="text" id="phone" placeholder="Phone Number*" required="">
                                    </fieldset>
                                </div>
                                <!-- Table Number Dropdown -->
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        @php
                                        $tableNumbers = range(1, 10); // Creates an array [1, 2, ..., 10]
                                        @endphp

                                        <select name="table_number" id="table_number" required>
                                            <option value="" disabled selected>Select Table Number</option>
                                            @foreach ($tableNumbers as $number)
                                            <option value="{{ $number }}">Table {{ $number }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        @php
                                        $guestNumbers = range(1, 12); // Creates an array [1, 2, ..., 12]
                                        @endphp

                                        <select name="number_guests" id="number-guests" required>
                                            <option value="" disabled selected>Number Of Guests</option>
                                            @foreach ($guestNumbers as $number)
                                            <option value="{{ $number }}">{{ $number }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <div id="filterDate2">
                                        <div class="input-group date" data-date-format="dd/mm/yyyy">
                                            <input name="date" id="date" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <select value="time" name="time" id="time">
                                            <option value="time">Time</option>
                                            <option name="Breakfast" id="Breakfast">Breakfast</option>
                                            <option name="Lunch" id="Lunch">Lunch</option>
                                            <option name="Dinner" id="Dinner">Dinner</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" id="message" placeholder="Message" required=""></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="main-button-icon">Make A Reservation</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Reservation Area Ends ***** -->

    <!-- ***** Menu Area Starts ***** -->
    <section class="section bg-light" id="offers">
        <div class="container">
            <!-- Section Heading -->
            <div class="row">
                <div class="col-lg-4 offset-lg-4 text-center">
                    <div class="section-heading mb-5">
                        <h6 class="text-uppercase text-primary">The Daily Dose Cafe Week</h6>
                        <h2 class="fw-bold">This Week’s Special Meal Offers</h2>
                    </div>
                </div>
            </div>
            <!-- Tabs -->
            <div class="row">
                <div id="tabs">
                    <!-- Centered Tabs Navigation -->
                    <div class="d-flex justify-content-center mb-4">
                        <ul class="list-inline nav nav-tabs" id="tabMenu">
                            @foreach($categories as $category)
                            <li class="list-inline-item mx-2">
                                <a href='#tabs-{{ $category->id }}'
                                    class="nav-link text-decoration-none px-4 py-2 border rounded-pill shadow-sm bg-light">
                                    {{ $category->category_name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Tabs Content -->
                    <section class="tab-content">
                        @foreach($categories as $category)
                        <article id='tabs-{{$category->id}}' class="tab-pane fade show">
                            <div class="row gy-4">
                                <!-- Left List -->
                                <div class="col-lg-6">
                                    <div>
                                        @foreach($category->products->take(ceil($category->products->count() / 2)) as $product)
                                        <div class="tab-item d-flex align-items-center p-3 border rounded shadow-sm bg-white">
                                            <!-- Image Section -->
                                            <div class="tab-item-image me-3">
                                                <img src="{{ asset('storage/images/' . $product->image) }}"
                                                    alt="{{ $product->name }}"
                                                    class="img-fluid rounded-circle shadow"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            </div>
                                            <!-- Text Details Section -->
                                            <div class="tab-item-details flex-grow-1">
                                                <h4 class="mb-1 fw-bold text-dark">{{ $product->name }}</h4>
                                                <p class="mb-1 text-muted small">{{ $product->description }}</p>
                                            </div>
                                            <!-- Price Section -->
                                            <div class="tab-item-price text-end">
                                                <div class="price-circle d-inline-block p-3 text-center shadow-sm rounded-circle"
                                                    style="background-color: #28a745; animation: pulse 1s infinite;">
                                                    <h6 class="text-white fw-bold">${{ $product->price }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Right List -->
                                <div class="col-lg-6">
                                    @foreach($category->products->skip(ceil($category->products->count() / 2)) as $product)
                                    <div class="tab-item d-flex align-items-center p-3 border rounded shadow-sm bg-white">
                                        <!-- Image Section -->
                                        <div class="tab-item-image me-3">
                                            <img src="{{ asset('storage/images/' . $product->image) }}"
                                                alt="{{ $product->name }}"
                                                class="img-fluid rounded-circle shadow"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                        <!-- Text Details Section -->
                                        <div class="tab-item-details flex-grow-1">
                                            <h4 class="mb-1 fw-bold text-dark">{{ $product->name }}</h4>
                                            <p class="mb-1 text-muted small">{{ $product->description }}</p>
                                        </div>
                                        <!-- Price Section -->
                                        <div class="tab-item-price text-end">
                                            <div class="price-circle d-inline-block p-3 text-center shadow-sm rounded-circle"
                                                style="background-color: #28a745; animation: pulse 1s infinite;">
                                                <h6 class="text-white fw-bold">${{ $product->price }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </section>
                </div>
            </div>
        </div>
    </section>





    <!-- ***** Chefs Area Ends ***** -->

    <!-- ***** Footer Start ***** -->
    <footer>
        @include('Customer.partials.footer')
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-2.1.0.min.js') }}"></script>

    <!-- Bootstrap -->
    <!-- <script src="{{ asset('js/popper.js') }}assets/js/popper.js"></script> -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('js/owl-carousel.js') }}"></script>
    <script src="{{ asset('js/accordions.js') }}"></script>
    <script src="{{ asset('js/datepicker.js') }}"></script>
    <script src="{{ asset('js/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('js/imgfix.min.js') }}"></script>
    <script src="{{ asset('js/slick.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script src="{{ asset('js/isotope.js') }}"></script>

    <!-- Global Init -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $(function() {
            var selectedClass = "";
            $("p").click(function() {
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("." + selectedClass).fadeOut();
                setTimeout(function() {
                    $("." + selectedClass).fadeIn();
                    $("#portfolio").fadeTo(50, 1);
                }, 500);

            });
        });
    </script>
</body>

</html>