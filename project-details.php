<?php
session_start();
include('dashboard/root/db.php');
$url = $_GET['url'];

$currentUrl = $_SERVER['REQUEST_URI'];
$pathParts = explode('/', $currentUrl);
// Get the third element (index 2) after splitting the path
$thirdWord = isset($pathParts[3]) ? $pathParts[3] : '';
$category= $thirdWord;
$table = 'project';

$query = $mysqli->prepare('SELECT * FROM project WHERE `url`= ?');
$query->bind_param('s', $url);
$query->execute();
$query_result = $query->get_result();

$query_data = $query_result->fetch_assoc();

// Get all URLs from your database based on your logic
$allUrlsQuery = $mysqli->prepare('SELECT url FROM '.$table);
$allUrlsQuery->execute();
$allUrlsResult = $allUrlsQuery->get_result();
$allUrls = [];
while ($row = $allUrlsResult->fetch_assoc()) {
    $allUrls[] = $row['url'];
}

// Find the index of the current URL in the array
$currentUrlIndex = array_search($url, $allUrls);

// Calculate the index of the next URL considering the looping
$nextUrlIndex = ($currentUrlIndex + 1) % count($allUrls);
$prevUrlIndex = ($currentUrlIndex - 1 + count($allUrls)) % count($allUrls);


// Get the next URL
$nextUrl = $allUrls[$nextUrlIndex];
$prevUrl = $allUrls[$prevUrlIndex];

// Store the next URL in the session
$_SESSION['next_url'] = $nextUrl;
$_SESSION['prev_url'] = $prevUrl;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>archidecorsa</title>
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo BASE_URL; ?>/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASE_URL; ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL; ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo BASE_URL; ?>/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php echo BASE_URL; ?>/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- bootsrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- css -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style-2.css">

    <!-- font-awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- header -->
    <header>
        <!-- navbar -->
<nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?php echo BASE_URL; ?>/home"><img src="<?php echo BASE_URL; ?>/assets/img/logo/archidecorsa-logo.png" class="logo-img" alt="" srcset=""></a>

      <div class="sandwitch-icon" onclick="showNav()">
        <svg id="hamburger-minified" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 142 142" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" style="cursor:pointer"><path id="hamburger-minified-u-first" d="M43,50.28h70c9,0,18.79-2,18.79-11.81c0-6.9-7.25-12.84-17.41-9.08C106,32.49,97.7,44.3,91.72,50.28L50.28,91.72" fill="none" stroke="#fff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="208.02" stroke-dasharray="56,152.02"/><path id="hamburger-minified-u-second" d="M113,83v-42c0-6.627417-5.372583-12-12-12h-60c-6.627417,0-12,5.372583-12,12v60c0,6.627417,5.372583,12,12,12h60c6.627417,0,12-5.372583,12-12v-18c0-6.627417-5.372583-12-12-12h-58" fill="none" stroke="#fff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="56" stroke-dasharray="56,336.26"/><path id="hamburger-minified-u-third" d="M99,91.72h-56c-24.45,0-37.24-12.28-37.24-28.13c0-19.66,24.08-33.75,44.52-13.31L91.72,91.72" fill="none" stroke="#fff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="227.77" stroke-dasharray="56,171.77"/>
          <script><![CDATA[(function(s,i,u,o,c,w,d,t,n,x,e,p,a,b){(a=document.getElementById(i.root)).svgatorPlayer={ready:(function(a){b=[];return function(c){return c?(b.push(c),a.svgatorPlayer):b}})(a)};w[o]=w[o]||{};w[o][s]=w[o][s]||[];w[o][s].push(i);e=d.createElementNS(n,t);e.async=true;e.setAttributeNS(x,'href',[u,s,'.','j','s','?','v','=',c].join(''));e.setAttributeNS(null,'src',[u,s,'.','j','s','?','v','=',c].join(''));p=d.getElementsByTagName(t)[0];p.parentNode.insertBefore(e,p);})('91c80d77',{"root":"hamburger-minified","version":"2022-05-04","animations":[{"elements":{"hamburger-minified-u-first":{"stroke-dashoffset":[{"t":0,"v":208.02,"e":[0.645,0.045,0.355,1]},{"t":800,"v":58.61}],"stroke-dasharray":[{"t":0,"v":[56,152.02],"e":[0.645,0.045,0.355,1]},{"t":800,"v":[58.61,149.41]}]},"hamburger-minified-u-second":{"stroke-dashoffset":[{"t":0,"v":56,"e":[0.325,0.005,0.9,0.995]},{"t":800,"v":392.26}],"stroke-dasharray":[{"t":0,"v":[56,336.26],"e":[0.325,0.005,0.9,0.995]},{"t":800,"v":[315.41,76.85]}]},"hamburger-minified-u-third":{"stroke-dashoffset":[{"t":0,"v":227.77,"e":[0.645,0.045,0.355,1]},{"t":800,"v":58.61}],"stroke-dasharray":[{"t":0,"v":[56,171.77],"e":[0.645,0.045,0.355,1]},{"t":800,"v":[58.61,169.16]}]}},"s":"MDPA1YzhhMzE3MYzg0RzgxNzA4CMzc4N2U3ZDMDxQTQ5NDdSM2HYzZkEzYjMxNKzM3ODgxNzQ3CMjgzNzhJN2VMJN2QzMTQ5NDGBTM2IzMTc4OHDM3NDgxNzA4GMzc4N2U3ZDgFyMzE0OTQwQzRNiWDMxNzU3OPDdiN2IzMTQ5FNDAzYjMxNzAV3YjgzSzc0STRgxN2Q3MFI4MJzc0MzE0OTc1ENzA3YjgyNzQLzYjMxODI3ZjHc0NzQ3MzMxNJDk0MDNiMzE3INTdmODIzMTQV5NDBHM2YzZjAhj"}],"options":"MDDAyMzgzMmE3YAjdjNjk3YTdjCMmE0MjJhNmJTTNzQ3MTZiNzEMyYTM0MmE2YKjc0NzE2YjczCTzJhNDIyYTdOhNmQ3ZTZkN2KE3YjZkMmE4NUVk/"},'https://cdn.svgator.com/ply/','__SVGATOR_PLAYER__','2022-05-04',window,document,'script','http://www.w3.org/2000/svg','http://www.w3.org/1999/xlink')]]></script>

          </svg>
      </div>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link home" aria-current="page" href="<?php echo BASE_URL; ?>/home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link about" href="<?php echo BASE_URL; ?>/about">about</a>
          </li>
          <li class="nav-item">
            <a class="nav-link services" href="<?php echo BASE_URL; ?>/services">services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link projects" href="<?php echo BASE_URL; ?>/projects">projects</a>
          </li>
          <li class="nav-item">
            <a class="nav-link blog" href="<?php echo BASE_URL; ?>/blog">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link contact" href="<?php echo BASE_URL; ?>/contactus">contact</a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li> -->
          
        </ul>
      </div>
    </div>
  </nav>
<!-- navbar-collapse in medium/small devices -->
<div class="navbarCollapseMd hide-on-lg" id="navbarCollapseMd">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
  <li class="nav-item">
    <a class="nav-link home" aria-current="page" href="<?php echo BASE_URL; ?>/home">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link about" href="<?php echo BASE_URL; ?>/about">about</a>
  </li>
  <li class="nav-item">
    <a class="nav-link services" href="<?php echo BASE_URL; ?>/services">services</a>
  </li>
  <li class="nav-item">
    <a class="nav-link projects" href="<?php echo BASE_URL; ?>/projects">projects</a>
  </li>
  <li class="nav-item">
    <a class="nav-link blog" href="<?php echo BASE_URL; ?>/blog">Blog</a>
  </li>
  <li class="nav-item">
    <a class="nav-link contact" href="<?php echo BASE_URL; ?>/contactus">contact</a>
  </li>
  <!-- <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      Dropdown
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li><a class="dropdown-item" href="#">Action</a></li>
      <li><a class="dropdown-item" href="#">Another action</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="#">Something else here</a></li>
    </ul>
  </li> -->
  
</ul>
</div>


    </header>
    <!-- header END -->
    
<!--==================================================================
      section-1
==================================================================-->
<style>
  .content p{
    color:#515157c5;
  }
</style>
<section class="project-details">
  <div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="img-div">
            <img src="<?php echo BASE_URL; ?>/dashboard/images/project/<?php echo $query_data['images']; ?>" class="w-100 " alt="">
        </div>
        </div>
        <div class="col-lg-6 cnt-col">
            <h2 class="title"><?php echo $query_data['title']; ?></h2>
            <h4 class="sub-title"><?php echo $query_data['subtitle']; ?></h4>
            <div class="content">
            <?php echo $query_data['txt']; ?>
            </div>
            
        </div>
    </div>
  </div>
</section>
<!--==================================================================
      section-1
==================================================================-->





<!--==================================================================
   footer
==================================================================-->
<footer class="footer-section" >
<div class="container">
    <div class="footer-cta pt-5 pb-5">
        <div class="row">
            <div class="col-xl-4 col-md-4 mb-30">
                <div class="single-cta">
                    <i class="fas fa-phone"></i>
                    <div class="cta-text">
                        <h4>Call us</h4>
                        <span>+966 53 555 0736</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 mb-30">
                <div class="single-cta">
                    <i class="fas fa-phone"></i>
                    <div class="cta-text">
                        <h4>Call us</h4>
                        <span>+91 8129 466 183</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 mb-30">
                <div class="single-cta">
                    <i class="far fa-envelope-open"></i>
                    <div class="cta-text">
                        <h4>Mail us</h4>
                        <span>info@archidecorsa.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-content pt-5 pb-5">
        <div class="row">
            <div class="col-xl-3 col-lg-3 mb-50" style="display: flex;flex-direction: column;justify-content: space-between;">
                <div class="footer-widget">
                    <div class="footer-logo">
                        <a href="home"><img src="<?php echo BASE_URL; ?>/assets/img/logo/archidecorsa-logo-white.png" class="img-fluid" alt="logo"></a>
                    </div>
                    <div class="footer-text">
                        <p></p>
                    </div>
                </div>
                <div class="footer-social-icons">
                  <ul>
                    <li>
                      <a class="facebook" href="https://www.facebook.com/archidecor.sa/">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <i class="fa-brands fa-square-facebook"></i>
                      </a>
                    </li>
                    <li>
                      <a class="youtube" href="https://www.youtube.com/channel/UCaWQY56iAAo4gkezyIH5NSA?view_as=subscriber">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <i class="fa-brands fa-youtube"></i>
                      </a>
                    </li>
                    <li>
                      <a class="instagram" href="https://www.instagram.com/archidecor.sa">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <i class="fa-brands fa-square-instagram"></i>
                      </a>
                    </li>
                  </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-30">
                <div class="footer-widget a">
                    <div class="footer-widget-heading">
                        <h3>Useful Links</h3>
                    </div>
                    <ul>
                      <li><a href="<?php echo BASE_URL; ?>/home" data-replace="Home" ><span>Home</span></a></li>
                      <li><a href="<?php echo BASE_URL; ?>/about" data-replace="About" ><span>About</span></a></li>
                      <li><a href="<?php echo BASE_URL; ?>/services" data-replace="Services" ><span>Services</span></a></li>
                      <li><a href="<?php echo BASE_URL; ?>/projects" data-replace="Projects" ><span>Projects</span></a></li>
                      <li><a href="<?php echo BASE_URL; ?>/blog" data-replace="Blog" ><span>Blog</span></a></li>
                      <li><a href="<?php echo BASE_URL; ?>/contactus" data-replace="Contact" ><span>Contact</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-50">
                <div class="footer-widget a">
                    <div class="footer-widget-heading">
                        <h3>Head Office</h3>
                    </div>
                    <ul>
                      <li>🏠 53, 80 Feet Road Koramangala, Bangalore , India - 560034</li>
                      <li><a href="tel:+91 8042107382">Tel +91 8042107382</a></li>
                      <li><a href="tel:+91 8042107382">Fax +91 8042107372</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-50">
                <div class="footer-widget a">
                    <div class="footer-widget-heading">
                        <h3>Office</h3>
                    </div>
                    <ul>
                      <li>🏠 Al Madeena Al Munawwarah Road Next to Sari street flyover, Faisaliyyah Dist. P.O Box : 2150 Jeddah 23442, KSA</li>
                        <hr style="opacity: 1;background: white;">
                      <li>🏠 Al Sheikh Salman Bin Hamad Al Khalifa street Al Malaz, Riyadh</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="copyright-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                <div class="copyright-text">
                    <p>Copyright &copy; 2024, All Right Reserved <!-- <a href="https://codepen.io/anupkumar92/">Anup</a> --></p>
                </div>
            </div>
        </div>
    </div>
</div>



</footer>
    <!-- swiper -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Then include Slick slider script -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
    <!-- bootsrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>