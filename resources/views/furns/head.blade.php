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
{{--<link rel="stylesheet" href="{{ asset('assets/furn/lightallery/lightgallery.css') }}">--}}
<link rel="stylesheet" href="{{ asset('assets/furn/lightallery/lightgallery.css') }}">
{{--<script type="text/javascript" src="{{ asset('assets/furn/lightallery/lightgallery-all.min.js') }}"></script>--}}




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
    .image-detail:hover {
        border: 1px solid black !important;
    }
    .image-avatar:hover {
        cursor: pointer;
        border: 1px solid black !important;
    }
    .image-avatar {
        border: 1px solid #c7c7c7 !important;
    }

    /* preview image avatar */

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 1000px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)}
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 100px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
