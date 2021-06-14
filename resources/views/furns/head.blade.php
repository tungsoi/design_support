<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ config('admin.name') ." - ". config('admin.sologan') }}</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="all,follow">
<!-- Bootstrap CSS-->
<link rel="stylesheet" href="{{ asset('assets/furn/bootstrap/css/bootstrap.min.css') }}">
<!-- Google fonts-->
{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo:400,400i"> --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
<!-- Lightbox-->
{{-- <link rel="stylesheet" href="{{ asset('assets/furn/lightbox2/css/lightbox.min.css') }}"> --}}
<!-- Font Awesome-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<!-- Parallax-->
{{-- <link rel="stylesheet" href="{{ asset('assets/furn/onepage-scroll/onepage-scroll.css') }}"> --}}
<!-- theme stylesheet-->
{{-- <link rel="stylesheet" href="{{ asset('assets/furn/css/style.default.css') }}" id="theme-stylesheet"> --}}
<!-- Custom stylesheet - for your changes-->
<link rel="stylesheet" href="{{ asset('assets/furn/fullPage/fullpage.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('assets/furn/fullPage/examples.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/furn/css/custom.css') }}">
<!-- Favicon-->
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<style>

	/* Style for our header texts
	* --------------------------------------- */
	h1{
		font-size: 5em;
		font-family: arial,helvetica;
		color: #fff;
		margin:0;
		padding:0;
	}
	.intro p{
		color: #fff;
	}

	/* Centered texts in each section
	* --------------------------------------- */
	.section{
		text-align:center;
	}

	/* Fixed header and footer.
	* --------------------------------------- */
	#header, #footer{
		position:fixed;
		display:block;
		width: 100%;
		background: #333;
		z-index:9;
		text-align:center;
		color: #f2f2f2;
	}

	#header{
		top:0px;
	}
	#footer{
		bottom:0px;
	}


	/* Bottom menu
	* --------------------------------------- */
	#infoMenu {
		bottom: 80px;
	}
	#infoMenu li a {
		color: #fff;
		z-index: 999;
	}

    #myVideo{
		position: absolute;
		right: 0;
		bottom: 0;
		top:0;
		width: 100%;
		height: 100%;
		background-size: 100% 100%;
 		background-color: black; /* in case the video doesn't fit the whole page*/
  		background-image: /* our video */;
  		background-position: center center;
  		background-size: contain;
   		object-fit: cover; /*cover video background */
   		z-index:3;
	}



	/* Layer with position absolute in order to have it over the video
	* --------------------------------------- */
	#section0 .layer{
		position: absolute;
		z-index: 4;
		width: 100%;
		left: 0;
		top: 43%;

		/*
		* Preventing flicker on some browsers
		* See http://stackoverflow.com/a/36671466/1081396  or issue #183
		*/
		-webkit-transform: translate3d(0,0,0);
		-ms-transform: translate3d(0,0,0);
		transform: translate3d(0,0,0);
	}

	/*solves problem with overflowing video in Mac with Chrome */
	#section0{
		overflow: hidden;
	}


	/* Bottom menu
	* --------------------------------------- */
	#infoMenu li a {
		color: #fff;
	}


	/* Hiding video controls
	* See: https://css-tricks.com/custom-controls-in-html5-video-full-screen/
	* --------------------------------------- */
	video::-webkit-media-controls {
	  display:none !important;
	}

    .card {
        border: none;
    }
    .card-img-top {
        height: 250px;
        width: 250px;
    }
</style>
