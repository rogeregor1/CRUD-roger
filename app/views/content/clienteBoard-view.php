<br><br>
<h1 class="title">Servicio de Atencion al Cliente</h1>
<div class="columns is-flex is-justify-content-center">
  <figure class="image is-64x64">
    <?php
    if (is_file("./assets/img/" . $_SESSION['foto'])) {
      echo '<img class="is-rounded" src="' . APP_URL . 'assets/img/' . $_SESSION['foto'] . '">';
    } else {
      echo '<img class="is-rounded" src="' . APP_URL . 'assets/img' . $_SESSION['foto'] . '">';
    }
    ?>
  </figure>
</div>
<div class="columns is-flex is-justify-content-center">
  <h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?>!</h2>
</div>

<!-- ======= Services Section ======= -->

<!-- Content -->
<div class="main-container">

  <div class="row g-5">
    <div class="col-md-6 col-lg-4 wow bounceInUp" data-aos-delay="100">
      <div class="box">
        <img src="<?php echo APP_URL; ?>assets/img/portfolio/web3.jpg" alt="">
        <a href="<?php echo APP_URL; ?>ofiInformatica/" class="card">
          <div class="tile-tittle">INFORMATICA</div>
          <div class="tile-icon">
            <div class="icon" style="background: #fceef3;"><i class="bi bi-briefcase" style="color: #ff689b;"></i>
            </div>
            <p>5 Registrados</p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-lg-4" data-aos-delay="200">
      <div class="box">
        <img src="<?php echo APP_URL; ?>assets/img/portfolio/web1.jpg" alt="">
        <a href="<?php echo APP_URL; ?>ofiElectronica/" class="card">
          <div class="tile-tittle">ELECTRONICA</div>
          <div class="tile-icon">
            <div class="icon" style="background: #fff0da;"><i class="bi bi-card-checklist" style="color: #e98e06;"></i>
            </div>
            <p>9 Registrados</p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-lg-4" data-aos-delay="300">
      <div class="box">
        <a href="<?php echo APP_URL; ?>ofiCarpinteria/" class="card">
          <img src="<?php echo APP_URL; ?>assets/img/portfolio/app2.jpg" alt="">
          <div class="tile-tittle">CARPINTERIA</div>
          <div class="tile-icon">
            <div class="icon" style="background: #e6fdfc;"><i class="bi bi-bar-chart" style="color: #3fcdc7;"></i>
            </div>
            <p>30 Registradas</p>
          </div>
        </a>
      </div>
    </div>

    <div class="col-md-6 col-lg-4 wow" data-aos-delay="100">
      <div class="box">
        <a href="<?php echo APP_URL; ?>ofiLimpieza/" class="card">
          <img src="<?php echo APP_URL; ?>assets/img/portfolio/app3.jpg" alt="">
          <div class="tile-tittle">LIMPIEZA</div>
          <div class="tile-icon">
            <div class="icon" style="background: #eafde7;"><i class="bi bi-binoculars" style="color:#41cf2e;"></i>
            </div>
            <p>200 Registrados</p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-lg-4" data-aos-delay="200">
      <div class=" box">
        <a href="<?php echo APP_URL; ?>ofiRefrigeracion/" class="card">
          <img src="<?php echo APP_URL; ?>assets/img/portfolio/app1.jpg" alt="">
          <div class="tile-tittle">REFRIGERACION</div>
          <div class="tile-icon">
            <div class="icon" style="background: #e1eeff;"><i class="bi bi-brightness-high" style="color: #2282ff;"></i>
            </div>
            <p>700 Registrados</p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-lg-4" data-aos-delay="300">
      <div class="box">
        <a href="<?php echo APP_URL; ?>ofiReformas/" class="card">
          <img src="<?php echo APP_URL; ?>assets/img/portfolio/app1.jpg" alt="">
          <div class="tile-tittle">REFORMAS</div>
          <div class="tile-icon">
            <div class="icon" style="background: #ecebff;"><i class="bi bi-calendar4-week" style="color: #8660fe;"></i>
            </div>
            <p>50 Registrados</p>
          </div>
        </a>
      </div>
    </div>
  </div>
  
  <br><br>
  <div class="row">
    <div class="col-md-6 col-lg-4 wow" data-aos-delay="100">
      <div class="box">
        <a href="<?php echo APP_URL; ?>company/" class="card">
          <div class="tile-tittle">Empresa</div>
          <div class="tile-icon">
            <div class="icon" style="background:d#ecebff;"><i class="bi bi-calendar4-week" style="color: #8660fe;"></i>
            </div>
            <p>1 Registrada</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- End Services Section -->