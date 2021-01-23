<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Yinka Enoch Adedokun">
  <title>Login Page</title>
  <link href="{{asset('out-template/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <style>
    .main-content{
	width: 90%;
	border-radius: 20px;
	box-shadow: 0 5px 5px rgba(0,0,0,.4);
	margin: 5em auto;
	display: flex;
}
.company__info{
	background-color: #fff;
	border-top-left-radius: 20px;
	border-bottom-left-radius: 20px;
	display: flex;
	flex-direction: column;
	justify-content: center;
	color: #fff;
}
.fa-android{
	font-size:3em;
}
@media screen and (max-width: 640px) {
	.main-content{width: 90%;}
	.company__info{
		display: none;
	}
	.login_form{
		border-top-left-radius:20px;
		border-bottom-left-radius:20px;
	}
}
@media screen and (min-width: 642px) and (max-width:800px){
	.main-content{width: 70%;}
}
.row > h2{
	color:#008080;
}
.login_form{
  widows: 100%;
	background-color: #fff;
	border-top-right-radius:20px;
	border-bottom-right-radius:20px;
	border-top:1px solid #ccc;
	border-right:1px solid #ccc;
}
form{
	padding: 0 2em;
}
.form__input{
	width: 100%;
	border:0px solid transparent;
	border-radius: 0;
	border-bottom: 1px solid #aaa;
	padding: 1em .5em .5em;
	padding-left: 2em;
	outline:none;
	margin:1.5em auto;
	transition: all .5s ease;
}
.form__input:focus{
	border-bottom-color: #008080;
	box-shadow: 0 0 5px rgba(0,80,80,.4); 
	border-radius: 4px;
}
.btn{
	transition: all .5s ease;
	width: 70%;
	border-radius: 30px;
	color:#008080;
	font-weight: 600;
	background-color: #fff;
	border: 1px solid #008080;
	margin-top: 1.5em;
	margin-bottom: 1em;
}
.btn:hover, .btn:focus{
	background-color: #008080;
	color:#fff;
}
  </style>
</head>
<body>
	<!-- Main Content -->
	<div class="container-fluid">
		<div class="row main-content bg-success text-center">
			<div class="col-lg-8 col-md-12 text-center company__info p-2">
				<span class="company__logo"><h2><span class="fa fa-android"></span></h2></span>
				<h4 class="company_title">
          <img src="{{asset('images/e-library.jpg')}}" style="width:100%;" alt="">
        </h4>
			</div>
			<div class="col-lg-4 col-md-12 login_form " style="border-left: 1px solid #ccc !important;">
				<div class="container-fluid">
					<div class="row mt-4">
            <h2>Log In</h2>
            <p>Selamat datang di e-library {{env('APP_NAME')}}</p>
					</div>
					<div class="row">
						<form id="login-form" class="form-group">@csrf
							<div class="row">
								<input type="text" name="username" id="username" class="form__input" placeholder="Username">
							</div>
							<div class="row">
								<!-- <span class="fa fa-lock"></span> -->
								<input type="password" name="password" id="password" class="form__input" placeholder="Password">
							</div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary m-auto" id="btn-login" type="button">Masuk</button>
              </div>
						</form>
					</div>
					<div class="row">
						<p>Don't have an account? <a href="#">Register Here</a></p>
					</div>
				</div>
			</div>
		</div>
  </div>
  
  <script src="{{asset('out-template/jquery.js')}}"></script>
</body>
<script>
  $(document).ready(function(){
    $('#login-form').submit(function (e){
        e.preventDefault()
        $('#btn-login').text('Menghubungkan ...').prop('disabled', true)
        var formData = new FormData(this)
        $.ajax({
            type: 'POST', cache: false, contentType: false, processData: false,
            url: '{{route('login')}}',
            data: formData,
            success:function(response){
              if(response.error != true){
                document.location.href = '{{url('/')}}'
                $('#btn-login').text('Masuk').prop('disabled', false)
              }
            }
        })
    })
  })
</script>
</html>