<!doctype html>
<html lang="en">
  <head>
  	<title>Login 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="../login-template/css/style.css">

	</head>
	<body class="img js-fullheight" style="background-image: url(../login-template/images/pln.jpeg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Sistem Laporan Pemeliharaan</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Login Sistem</h3>
		      	<form method="POST" action="{{ route('login') }}" class="signin-form">
		      		@csrf
		      		<div class="form-group">
		      			<input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" required autocomplete="nip" autofocus placeholder="NIPEG" required>
		      			@error('nip')
                	<span class="invalid-feedback" role="alert">
                    	<strong>{{ $message }}</strong>
                	</span>
           	 		@enderror
		      		</div>
	            <div class="form-group">
	              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	              @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}  checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									@if (Route::has('password.request'))
									<a href="{{ route('password.request') }}" style="color: #fff">Forgot Password</a>
									@endif
								</div>
	            </div>
	          </form>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="../login-template/js/jquery.min.js"></script>
  <script src="../login-template/js/popper.js"></script>
  <script src="../login-template/js/bootstrap.min.js"></script>
  <script src="../login-template/js/main.js"></script>

	</body>
</html>

