
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Private Placement Memorandum | Olympus Asset Limited</title>
    
    @include('site.Elements.header')
</head>
<body>
<!--PreLoader-->
<div class="loader">
    <div class="loader-inner">
        <div class="cssload-loader"></div>
    </div>
</div>


@include('site.Elements.menu')


<!--Page Header-->
<section id="main-banner-page" class="position-relative page-header bg-private-placement-memorandum section-nav-smooth parallax padding_half">
    <div class="overlay overlay-dark opacity-5 z-index-1"></div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-9">
                <div class="page-titles whitecolor text-center padding_top padding_bottom">
                    <h2 class="font-bold mt-md-5 mt-lg-5 wow fadeInUp">PRIVATE PLACEMENT MEMORANDUM of Olympus Asset Ltd </h2>
                    {{-- <h3 class="font-light pt-2 wow fadeInUp">Also known as an Offering Memorandum or “PPM”. A document that outlines the terms of securities to be offered in a private placement. </h3> --}}
                </div>
            </div>
        </div>
    </div>
</section>
<!--Page Header ends -->

<section id="sign-in" class="bglight position-relative padding">
    <div class="container whitebox">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 text-center wow fadeInUp">
                <h3 class="heading bottom30 darkcolor font-light2">
                    OAL Private Placement Memorandum
                    <span class="divider-center"></span>
                </h3>

                <h5 class="text-success"> <a href="{{ asset('admin/images/docs/private-placement-memorandum-signed.pdf') }}">Click to download the document</a></h5>
            </div>
        </div>
    </div>
</section>

<section id="sign-in" class="position-relative padding">
    <div class="container whitebox">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 text-center wow fadeInUp">
                <h3 class="heading bottom30 darkcolor font-light2">
                    Class B Supplementary PPM
                    <span class="divider-center"></span>
                </h3>
                
                <h5 class="text-success"> <a href="{{ asset('admin/images/docs/class-b-participating-shares-prospectus-supplement.pdf') }}">Click to download the document</a></h5>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@include('site.Elements.footer')

</body>
</html>