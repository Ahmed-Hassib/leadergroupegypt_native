<?php if (!true) { ?>
  <div class="container" dir="<?php echo $page_dir ?>">
    <div id="alertsCarouselIndicators" class="carousel carousel-dark slide carousel-alerts-dashboard">

      <div class="carousel-indicators">
        <button type="button" data-bs-target="#alertsCarouselIndicators" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#alertsCarouselIndicators" data-bs-slide-to="1"
          aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#alertsCarouselIndicators" data-bs-slide-to="2"
          aria-label="Slide 3"></button>
      </div>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">مرحباً بكم...</h4>
            <p>هذا تنبيه من مطور البرنامج</p>
            <hr>
            <p class="mb-0">هذا تنبيه من مطور البرنامج</p>
          </div>
        </div>
        <div class="carousel-item">
          <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">مرحباً بكم...</h4>
            <p>هذا تنبيه من مطور البرنامج</p>
            <hr>
            <p class="mb-0">هذا تنبيه من مطور البرنامج</p>
          </div>
        </div>
        <div class="carousel-item">
          <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">مرحباً بكم...</h4>
            <p>هذا تنبيه من مطور البرنامج</p>
            <hr>
            <p class="mb-0">هذا تنبيه من مطور البرنامج</p>
          </div>
        </div>
      </div>


      <button class="carousel-control-prev" type="button" data-bs-target="#alertsCarouselIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#alertsCarouselIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
<?php } ?>