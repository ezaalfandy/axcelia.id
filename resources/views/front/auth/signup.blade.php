<!DOCTYPE html>
<html lang="en">

<head>
    @extends('front.layouts.head')
</head>

<body class="signup-page">
    <div class="page-header header-filter" filter-color="black">
        <div class="page-header-image" style="background-image:url({{ asset('storage/front/') }}img/bg18.jpg)"></div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 ml-auto mr-auto">
                        <div class="info info-horizontal">
                            <div class="icon icon-primary">
                                <i class="now-ui-icons media-2_sound-wave"></i>
                            </div>
                            <div class="description">
                                <h5 class="info-title">Marketing</h5>
                                <p class="description">
                                    We've created the marketing campaign of the website. It was a very interesting
                                    collaboration.
                                </p>
                            </div>
                        </div>
                        <div class="info info-horizontal">
                            <div class="icon icon-primary">
                                <i class="now-ui-icons media-1_button-pause"></i>
                            </div>
                            <div class="description">
                                <h5 class="info-title">Fully Coded in HTML5</h5>
                                <p class="description">
                                    We've developed the website with HTML5 and CSS3. The client has access to the code
                                    using
                                    GitHub.
                                </p>
                            </div>
                        </div>
                        <div class="info info-horizontal">
                            <div class="icon icon-info">
                                <i class="now-ui-icons users_single-02"></i>
                            </div>
                            <div class="description">
                                <h5 class="info-title">Built Audience</h5>
                                <p class="description">
                                    There is also a Fully Customizable CMS Admin Dashboard for this product.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mr-auto">
                        <div class="card card-signup">
                            <div class="card-body">
                                <h4 class="card-title text-center">Register</h4>
                                <div class="social text-center">
                                    <button class="btn btn-icon btn-round btn-twitter">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button class="btn btn-icon btn-round btn-dribbble">
                                        <i class="fab fa-dribbble"></i>
                                    </button>
                                    <button class="btn btn-icon btn-round btn-facebook">
                                        <i class="fab fa-facebook"> </i>
                                    </button>
                                    <h5 class="card-description"> or be classical </h5>
                                </div>
                                <form class="form" method="" action="">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="now-ui-icons users_circle-08"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="First Name..."
                                            autocomplete="fullname">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="now-ui-icons text_caps-small"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Last Name..."
                                            autocomplete="name">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="now-ui-icons ui-1_email-85"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Your Email..."
                                            autocomplete="email">
                                    </div>
                                    <!-- If you want to add a checkbox to this form, uncomment this code -->
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox">
                                            <span class="form-check-sign"></span>
                                            I agree to the terms and
                                            <a href="#something">conditions</a>.
                                        </label>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#pablo" class="btn btn-primary btn-round btn-lg">Get Started</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src=" {{ asset('storage/front/js/app.js') }}" type="text/javascript"></script>
</body>

</html>
