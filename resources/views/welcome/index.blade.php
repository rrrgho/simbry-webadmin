<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<title>Perpustakaan</title>
		<link rel="shortcut icon" href="">
		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/icon.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<!--     Fonts and icons     -->
		<link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <style type="text/css">
            .navbar-custom {
                background-color: #2c8ef8 !important;
            }
            .btn-custom {
                background-color: #2c8ef8 !important;
            }
            .text-tran-box {
                background: #2c8ef8;
                background: -webkit-linear-gradient(to left, #2c8ef8 , #000);
                background: linear-gradient(to left, #2c8ef8 , #000);
            }
        </style>
        <style>
            body { margin:0; padding:0; }
            .overlay {
                width: 100%; height: 500px;
                background: 
                    linear-gradient(
                    rgba(13, 110, 255, 0.7),
                    rgb(148, 0, 211)

                    ),
                    url() no-repeat;
                background-size: cover;
            }
        </style>
	</head>
	<body>
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-default navbar-light navbar-custom sticky" style="background: #02c0ce;">
			<div class="container">
				<a class="navbar-brand logo text-white" href="">
					Perpustakaan				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="nav navbar-nav ml-auto navbar-center" id="mySidenav">
						<li class="nav-item">
							<a href="#home" class="nav-link scroll" style="color: #fff !important">Utama</a>
						</li>
						<li class="nav-item">
							<a href="#about" class="nav-link scroll" style="color: #fff !important">Tentang</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('login') }}" class="nav-link" style="color: #fff !important">Masuk</a>
						</li>
					</ul>
				</div>
			</div>
        </nav>
        {{-- Home --}}
        <section class="section overlay" id="home">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<div class="home-wrapper text-center text-light">
							<p class="text-light">Perpustakaan</p>
							<div class="text-light">
								<h1 class="text-light" style="margin: 20px 0;">Perpustakaan - Medan</h1>
							</div>
							<h2 class="text-light"><span class="typed" data-elements="Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellat facilis suscipit"></span></h1>
							<p class="text-light">
							    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellat facilis suscipit veniam et ullam nisi, itaque asperiores iure nesciunt ex reprehenderit eos rem architecto magni reiciendis nulla esse sapiente recusandae?							</p>
							<p style="margin-top: 20px;">
								<a href="{{ route('login') }}" class="btn btn-custom">Masuk</a> 
							</p>
						</div>
					</div>
				</div>
			</div>
        </section>
        {{-- Pengguna --}}
        <section>
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<div class="facts-box text-center">
							<div class="row">
								<div class="col-lg-4">
									<h2>14.000</h2>
									<p class="text-muted">Total Buku</p>
								</div>
								<div class="col-lg-4">
									<h2>2</h2>
									<p class="text-muted">Total Pengguna</p>
								</div>
								<div class="col-lg-4">
									<h2>10</h2>
									<p class="text-muted">Stok Tersedia</p>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </section>
        {{-- Features --}}
        <section class="section" id="features">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="features-box text-center">
							<div class="feature-icon">
								<span class="material-icons">
									menu_book
									</span>
							</div>
							<h3>Buku Berkualitas</h3>
							<p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis ea perspiciatis deleniti vel fugit, aperiam cumque dolores. Architecto voluptate dignissimos placeat, labore aspernatur alias fugit error cumque aut nostrum expedita!.</p>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="features-box text-center">
							<div class="feature-icon">
								<span class="material-icons">
									support_agent
								</span>
							</div>
							<h3>Pelayanan Bantuan</h3>
							<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis consectetur neque dolorem. Fugit perspiciatis, corporis quae ullam officiis provident vitae quia iste impedit, molestias possimus corrupti excepturi laboriosam suscipit hic!</p>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="features-box text-center">
							<div class="feature-icon">
								<span class="material-icons">
									code
									</span>
							</div>
							<h3>Desain Clean & Responsive</h3>
							<p class="text-muted">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Culpa eius accusantium commodi unde aspernatur quis sequi, aut voluptas. Quos voluptas porro magnam officia blanditiis atque placeat velit saepe excepturi labore..</p>
						</div>
					</div>
				</div>
			</div>
        </section>
        {{-- Books List --}}
        <section>
            <div class="container">
                <div class="row">
					<div class="col-sm-4">
						<div class="card">
							<img src="{{ asset('book-images/1BIMG-1BIMG-1BIMG-1BIMG-ktp.jpg') }}" class="card-img-top" alt="...">
							<div class="card-body">
							  <h5 class="card-title">Card title</h5>
							  <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
							  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="card">
							<img src="{{ asset('book-images/1BIMG-1BIMG-1BIMG-1BIMG-ktp.jpg') }}" class="card-img-top" alt="...">
							<div class="card-body">
							  <h5 class="card-title">Card title</h5>
							  <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
							  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="card">
							<img src="{{ asset('book-images/1BIMG-1BIMG-1BIMG-1BIMG-ktp.jpg') }}" class="card-img-top" alt="...">
							<div class="card-body">
							  <h5 class="card-title">Card title</h5>
							  <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
							  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="card">
							<img src="{{ asset('book-images/1BIMG-1BIMG-1BIMG-1BIMG-ktp.jpg') }}" class="card-img-top" alt="...">
							<div class="card-body">
							  <h5 class="card-title">Card title</h5>
							  <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
							  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="card">
							<img src="{{ asset('book-images/1BIMG-1BIMG-1BIMG-1BIMG-ktp.jpg') }}" class="card-img-top" alt="...">
							<div class="card-body">
							  <h5 class="card-title">Card title</h5>
							  <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
							  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="card">
							<img src="{{ asset('book-images/1BIMG-1BIMG-1BIMG-1BIMG-ktp.jpg') }}" class="card-img-top" alt="...">
							<div class="card-body">
							  <h5 class="card-title">Card title</h5>
							  <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
							  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
					</div>
				</div>
            </div>
        </section>
        <footer class="footer bg-dark mt-3">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<p class="copyright">&copy; 2021 </p>
					</div>
				</div>
			</div>
		</footer>
		
		<script src="{{ asset('template-tools/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
		<script src="{{ asset('assets/js/typed.js') }}"></script>
		<script>
            /* ==============================================
            //Typed
            =============================================== */
            $(".typed").each(function(){
                var $this = $(this);
                $this.typed({
                strings: $this.attr('data-elements').split(','),
                typeSpeed: 100, // typing speed
                backDelay: 3000 // pause before backspacing
                });
            });
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="">
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-162801469-2');
        </script>
	</body>
</html>    