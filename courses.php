<?php include("includes/header.php") ?>
<?php include("includes/dbmethods.php"); ?>

<section class="probootstrap-section probootstrap-section-colored">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left section-heading probootstrap-animate">
                <h1>Our Courses</h1>
            </div>
        </div>
    </div>
</section>


<section class=" probootstrap-section probootstrap-bg-white probootstrap-border-top">

    <!-- <div class="row">
        <div class=" text-center section-heading probootstrap-animate">
            <h2>Our Featured Courses</h2>
        </div>
    </div> -->
    <div class=" row justify-content-center">
        <div class="row text-center probootstrap-animate">
            <h4 class="text-muted">Diploma Courses</h4>
        </div>
        <?php
        $dipCourses = DB::query("SELECT * FROM courses WHERE cstatus='Active' AND type='Diploma'");
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
        $certCourses = DB::query("SELECT * FROM courses WHERE cstatus='Active' AND type='Certification'");
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

<?php include("includes/footer.php") ?>