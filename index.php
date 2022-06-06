<?php include("includes/header.php"); ?>
<?php include("includes/dbmethods.php"); ?>

<style>
.carousel-item:after {
  content:"";
  position:absolute;
  top:0;
  bottom:0;
  left:0;
  right:0;
  background:rgba(0,0,0,0.3);
}
</style>

<section class="m-2 probootstrap-bg">
    <div class="row ">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner" style="max-height: 90vh;">
                <div class="carousel-item active ">
                    <img src="img/ssd-image3.jpg" class=" img-fluid w-100" alt="...">
                </div>
                <div class="carousel-item ">
                    <img src="img/ssd-image1.jpg" class="img-fluid w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/ssd-image2.jpg" class="img-fluid w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<section class="probootstrap-section probootstrap-section-colored">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left section-heading probootstrap-animate">
                <h2 style="font-weight: bold;">Hello Welcome to Shetes Skill Development pvt. ltd.</h2>
            </div>
        </div>
    </div>
</section>

<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="probootstrap-flex-block">
                    <div class="probootstrap-text probootstrap-animate">
                        <h3>About SSDIT</h3>
                        <p>
                            SSDIT have many courses for building your better career.
                            We offers two types of courses such as diploma courses and certification courses.
                            Like Mobile Repairing, Electrical Diploma, Computer Hardware, Computer Operating,
                            Finanicial Accounting, Fashion Designing, Tailoring, Automoboiles, etc.
                        </p>
                        <p><a href="./about.php" class="btn btn-primary">Learn More</a></p>
                    </div>
                    <div class="probootstrap-image probootstrap-animate" style="background-image: url(img/slider_3.jpg)">
                        <a href="https://vimeo.com/45830194" class="btn-video popup-vimeo"><i class="icon-play3"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="probootstrap-section" id="probootstrap-counter">
    <div class="container">

        <div class="row ">
            <div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 probootstrap-animate ">
                <div class="probootstrap-counter-wrap">
                    <div class="probootstrap-icon">
                        <i class="icon-users2"></i>
                    </div>
                    <div class="probootstrap-text">
                        <span class="probootstrap-counter">
                            <span class="js-counter" data-from="0" data-to="1000" data-speed="5000" data-refresh-interval="10">1</span>
                        </span>
                        <span class="probootstrap-counter-label">Students Enrolled</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 probootstrap-animate">
                <div class="probootstrap-counter-wrap">
                    <div class="probootstrap-icon">
                        <i class="icon-user-tie"></i>
                    </div>
                    <div class="probootstrap-text">
                        <span class="probootstrap-counter">
                            <span class="js-counter" data-from="0" data-to="20" data-speed="5000" data-refresh-interval="50">1</span>
                        </span>
                        <span class="probootstrap-counter-label">Certified Teachers</span>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-sm-block visible-xs-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 probootstrap-animate">
                <div class="probootstrap-counter-wrap">
                    <div class="probootstrap-icon">
                        <i class="icon-library"></i>
                    </div>
                    <div class="probootstrap-text">
                        <span class="probootstrap-counter">
                            <span class="js-counter" data-from="0" data-to="99" data-speed="5000" data-refresh-interval="50">1</span>%
                        </span>
                        <span class="probootstrap-counter-label">Passing rate</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 probootstrap-animate">

                <div class="probootstrap-counter-wrap">
                    <div class="probootstrap-icon">
                        <i class="icon-smile2"></i>
                    </div>
                    <div class="probootstrap-text">
                        <span class="probootstrap-counter">
                            <span class="js-counter" data-from="0" data-to="100" data-speed="5000" data-refresh-interval="50">1</span>%
                        </span>
                        <span class="probootstrap-counter-label">Parents Satisfaction</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="probootstrap-section probootstrap-section-colored probootstrap-bg probootstrap-custom-heading probootstrap-tab-section" style="background-image: url(img/ssd-image4.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center section-heading probootstrap-animate">
                <h2 class="mb0 h1" style="font-weight: bolder; font-size:44px;">Highlights</h2>
            </div>
        </div>
    </div>

</section>

<!-- Why choose us section start -->

<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center section-heading probootstrap-animate">
                <h2>Why Choose Shetes Skill Development pvt. ltd.</h2>
                <p class="lead">Skills development is the process of identifying your skill gaps, and developing and honing these skills.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="service left-icon probootstrap-animate">
                    <div class="icon"><i class="icon-checkmark"></i></div>
                    <div class="text">
                        <h3>Our Mission</h3>
                        <p>Our mission is to lead community development by providing socially inclusive learning programs and opportunities that enable enriched and enterprising lives.</p>
                    </div>
                </div>
                <div class="service left-icon probootstrap-animate">
                    <div class="icon"><i class="icon-checkmark"></i></div>
                    <div class="text">
                        <h3>Quality</h3>
                        <p>As a Registered Training Organisation we provide quality workplace training and assessment that meets the strict standards. This ensures quality business and consistently high standards of service delivery.</p>
                    </div>
                </div>
                <div class="service left-icon probootstrap-animate">
                    <div class="icon"><i class="icon-checkmark"></i></div>
                    <div class="text">
                        <h3>Choices</h3>
                        <p>We offer a wealth of educational and training opportunities with 22 qualifications and associated units.Our workplace training and education service covers a range of industry areas including Business Services, Childrens Services, Hospitality, Horticulture, Financial Services, Community Services, Information Technology and Training and Assessment.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service left-icon probootstrap-animate">
                    <div class="icon"><i class="icon-checkmark"></i></div>
                    <div class="text">
                        <h3>Customer Service</h3>
                        <p>The institute is committed to providing the highest possible standard of service and attention to all customers. We strive to exceed your expectations and seek regular feedback to inform and improve our services.</p>
                    </div>
                </div>

                <div class="service left-icon probootstrap-animate">
                    <div class="icon"><i class="icon-checkmark"></i></div>
                    <div class="text">
                        <h3>Support</h3>
                        <p>We provide a range of support services to meet the individual needs of students. We ensure that all teaching, learning and assessment activities are tailored to the learning needs of the individual. Where necessary, course delivery incorporates specific workplace communication, literacy and numeracy skills.</p>
                    </div>
                </div>

                <div class="service left-icon probootstrap-animate">
                    <div class="icon"><i class="icon-checkmark"></i></div>
                    <div class="text">
                        <h3>Flexibility</h3>
                        <p>The institute is flexible, innovative and responsive to client needs. Our extensive range of programs and services provide flexible learning solutions that are tailored to suit the needs of community and business clients.</p>
                    </div>
                </div>

            </div>
        </div>
        <!-- END row -->
    </div>
</section>

<!-- Why choose us section end -->


<section class=" probootstrap-section probootstrap-bg-white probootstrap-border-top">

    <div class="row">
        <div class=" text-center section-heading probootstrap-animate">
            <h2>Our Featured Courses</h2>
        </div>
    </div>
    <div class=" row justify-content-center">
        <div class="row text-center probootstrap-animate">
            <h4 class="text-muted">Diploma Courses</h4>
        </div>
        <?php
        $dipCourses = DB::query("SELECT * FROM courses WHERE cstatus='Active' AND onHomepage=1 AND type='Diploma'");
        foreach ($dipCourses as $course) {
        ?>
            <div class="col-md-5">
                <div class="probootstrap-service-2 probootstrap-animate m-3">
                    <div class="image">
                        <img class="img-fluid w-100" src="<?php echo $course['image'] ?>" alt="Course Image">
                    </div>
                    <div class="text">
                        <!-- <span class="probootstrap-meta"><i class="icon-calendar2"></i> July 10, 2017</span> -->
                        <h3 class="show-more-less-title"><?php echo $course['name'] ?></h3>
                        <p class="show-more-less" data-options="150"><?php echo $course['description'] ?></p>
                        <p><a href="register.php?x_token=<?php echo $course['id'] ?>" class="btn btn-primary">Enroll now</a> </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="mt-5  row justify-content-center  ">
        <div class="text-center probootstrap-animate">
            <h4 class="text-muted">Certificate Courses</h4>
        </div>
        <?php
        $certCourses = DB::query("SELECT * FROM courses WHERE cstatus='Active' AND onHomepage=1 AND type='Certification'");
        foreach ($certCourses as $course) {
        ?>
            <div class="col-md-5">
                <div class="probootstrap-service-2 probootstrap-animate m-3">
                    <div class="image img-fluid">
                        <img class="img-fluid w-100" src="<?php echo $course['image'] ?>" alt="Course Image">
                    </div>
                    <div class="text">
                        <!-- <span class="probootstrap-meta"><i class="icon-calendar2"></i> July 10, 2017</span> -->
                        <h3 class="show-more-less-title"><?php echo $course['name'] ?></h3>
                        <p class="show-more-less" data-options="150"><?php echo $course['description'] ?></p>
                        <p><a href="register.php?x_token=<?php echo $course['id'] ?>" class="btn btn-primary">Enroll now</a></p>
                    </div>
                </div>
            </div>
            
        <?php } ?>
    </div>
</section>


<!-- franchise panel start -->

<iframe class="franchise" src="includes/franchise.php" scrolling="no" frameboreder="0"></iframe>
<!-- franchise panel end -->

<!-- Contact panel start -->
<iframe src="includes/contact.php" style="width:100%; min-height:820px; border:none;padding:0px;
  margin:0px;" scrolling="no" frameboreder="0"></iframe>
<!-- contact panel end -->



<?php include "includes/footer.php"; ?>
