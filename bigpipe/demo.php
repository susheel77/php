<html style="" class=" js no-touch svg inlinesvg svgclippaths no-ie8compat"><!--<![endif]--><head>
<title>bigpipe测试</title>
<meta charset="utf-8">

<link href="./css/foundation.min.css" rel="stylesheet">
<link href="./css/superfish.css" rel="stylesheet">
<link href="./css/stylesheet.css" rel="stylesheet">
<link href="./js/slider/flexslider.css" rel="stylesheet">
<link href="./js/slider/flexcar.css" rel="stylesheet">

<script src="js/placeholder.min.js"></script><script src="./js/jquery.min.js"></script>
<script src="./js/vendor/custom.modernizr.js"></script>
<script src="./js/function.js"></script>
<script src="./js/hoverIntent.js"></script>
<script src="./js/superfish.js"></script>
<script src="./js/slider/jquery.flexslider.js"></script>

<script>
Modernizr.load({
    // test if browser understands media queries
    test: Modernizr.mq('only all'),
    // if not load ie8-grid
    nope: 'css/ie8-grid-foundation-4.css'
});

function viewer(data){
	var domid	= data.domid;
	var html	= data.html;
	$('#'+domid).html(html);
}
</script>

<!--[if lt IE 9]>
<link rel="stylesheet" href="css/ie-fixes.css">
<![endif]-->
</head>

<body>

	<div id="pl_header" class="header"><div class="row">
	<div class="columns large-12">
		<div class="row header-inner">
			<div class="columns large-4 small-12"> <a href="index.html"><img class="logo" alt="" src="./images/logo.png"></a> </div>
			<div class="columns large-8">
				<nav>
					<section>
						<ul class="sf-menu large-12 sf-js-enabled sf-arrows">
							<li class="active"><a href="index.html">Home</a></li>
							<li><a href="about.html">About us</a></li>
							<li><a href="blog.html">Blog</a></li>
							<li><a href="gallery.html">Gallery</a></li>
							<li class="has-dropdown"><a href="services.html" class="sf-with-ul">Services</a>
								<ul class="dropdown" style="display: none;">
									<li class="has-dropdown"><a href="#" class="sf-with-ul">Dropdown Level 1a</a>
										<ul class="dropdown" style="display: none;">
											<li><a href="#">Dropdown Level 2a</a></li>
											<li><a href="#">Dropdown Level 2b</a></li>
										</ul>
									</li>
									<li><a href="#">Dropdown Level 1b</a></li>
									<li><a href="#">Dropdown Level 1c</a></li>
									<li><a href="#">Dropdown Level 1d</a></li>
									<li><a href="#">See all →</a></li>
								</ul>
							</li>
							<li><a href="contact.html">Contact Us</a></li>
						</ul>
					</section>
				</nav>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="columns large-12 small-top-menu">
		<div class="row">
			<div class="columns large-12 plr0 top-nav">
				<form action="#" class="dropdown" name="dropdown">
					<nav>
						<section>
							<select onchange="goToNewPage(document.dropdown.selected)" accesskey="E" id="target" name="selected">
								<option value="index.html">home</option>
								<option value="about.html">about us</option>
								<option value="blog.html">blog</option>
								<option value="gallery.html">gallery</option>
								<option value="services.html">services</option>
								<option value="contact.html">contact us</option>
							</select>
						</section>
					</nav>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="copyrights">Collect from <a title="网站模板" href="http://www.cssmoban.com/">网站模板</a></div>

<div class="slider">
	<div class="row">
		<div class="columns large-12">
			<div class="row flexslider-row">
				<div class="columns large-12">
					<div class="flexslider">
						<ul class="slides">
							<li style="width: 100%; float: left; margin-right: -100%; position: relative; display: none;" class=""> <img alt="" src="./images/slide1.jpg"> </li>
							<li style="width: 100%; float: left; margin-right: -100%; position: relative; display: none;" class=""> <img alt="" src="./images/slide2.jpg"> </li>
							<li style="width: 100%; float: left; margin-right: -100%; position: relative; display: list-item;" class="flex-active-slide"> <img alt="" src="./images/slide1.jpg"> </li>
							<li style="width: 100%; float: left; margin-right: -100%; position: relative; display: none;" class=""> <img alt="" src="./images/slide2.jpg"> </li>
						</ul>
					<ol class="flex-control-nav flex-control-paging"><li><a class="">1</a></li><li><a class="">2</a></li><li><a class="flex-active">3</a></li><li><a class="">4</a></li></ol><ul class="flex-direction-nav"><li><a href="#" class="flex-prev">Previous</a></li><li><a href="#" class="flex-next">Next</a></li></ul></div>
				</div>
			</div>
		</div>
	</div>
</div>

header</div>

	<div id="pl_tagline" class="tagline"><div class="row">
	<div class="columns large-12">
		<div class="center">
			<h1>WELCOME TO OUR WEBSITE</h1>
			<p> Diam in turpis ut mauris, hac vel pulvinar, lacus lundium lectus, placerat? A aenean! Lectus sed phasellus montes? Velit aenean elit, ut aenean tempor! Ac turpis ac integer augue, rhoncus pid augue dignissim. Lectus rhoncus urna lectus in est integer amet? </p>
		</div>
	</div>
</div></div>

	<div id="pl_service" class="service-box"><div class="row service">

	<div class="columns large-4">
		<h1 class="service-subtitle">Scelerisque aliquet adipiscing</h1>
		<p><img class="threeUp" alt="" src="./images/3up1.jpg"></p>
		<p> scelerisque pellentesque duis nascetur crasamet sitter sit eros egestas eu? Aliquet pid porta elit acniitem esm Risus arcu augue lorem ipsum sit dolor esmet duiscra sit eros egestas eu? Aliquet pid porta elit acnisitem sit Risus arcu augue lorem ipsum sit dolor esmet </p>
		<p> <a class="button custom">details</a> </p>
	</div>

	<div class="columns large-4">
		<h1 class="service-subtitle">Scelerisque aliquet adipiscing</h1>
		<p><img class="threeUp" alt="" src="./images/3up2.jpg"></p>
		<p> scelerisque pellentesque duis nascetur crasamet sitter sit eros egestas eu? Aliquet pid porta elit acniitem esm Risus arcu augue lorem ipsum sit dolor esmet duiscra sit eros egestas eu? Aliquet pid porta elit acnisitem sit Risus arcu augue lorem ipsum sit dolor esmet </p>
		<p> <a class="button custom">details</a> </p>
	</div>

	<div class="columns large-4">
		<h1 class="service-subtitle">Scelerisque aliquet adipiscing</h1>
		<p><img class="threeUp" alt="" src="./images/3up1.jpg"></p>
		<p> scelerisque pellentesque duis nascetur crasamet sitter sit eros egestas eu? Aliquet pid porta elit acniitem esm Risus arcu augue lorem ipsum sit dolor esmet duiscra sit eros egestas eu? Aliquet pid porta elit acnisitem sit Risus arcu augue lorem ipsum sit dolor esmet </p>
		<p> <a class="button custom">details</a> </p>
	</div>

</div></div>

	<div id="pl_testimonial" class="front-testimonial"><div class="row">
	<div class="columns large-12">
		<div class="flexcar">
			<ul class="slides">

			<li style="width: 100%; float: left; margin-right: -100%; position: relative; display: none;" class="">
				<div class="row">
					<div class="columns large-3"> <img class="test-img" alt="" src="./images/test.jpg"> </div>
					<div class="columns large-9">
						<h1>Elementum phasellus, diam tempor ultrices a mauris </h1>
						<p> Elementum phasellus, diam tempor ultrices a mauris, placerat odio nunc turpis? Aenean facilisis nisi turpis parturient sed pid massa et in est, et magna turpis ac a dapibus urna </p>
						<div class="row">
							<div class="columns large-12">
								<p class="test-credit"><span class="name">Rebecca Jones,</span><span class="profession"> Seo Consultant</span>, <span class="company">XYZ Pvt Ltd</span></p>
							</div>
						</div>
					</div>
				</div>
			</li>

			<li style="width: 100%; float: left; margin-right: -100%; position: relative; display: none;" class="">
				<div class="row">
					<div class="columns large-3"> <img class="test-img" alt="" src="./images/test1.jpg"> </div>
					<div class="columns large-9">
						<h1>Elementum phasellus, diam tempor ultrices a mauris </h1>
						<p> Elementum phasellus, diam tempor ultrices a mauris, placerat odio nunc turpis? Aenean facilisis nisi turpis parturient sed pid massa et in est, et magna turpis ac a dapibus urna </p>
						<div class="row">
							<div class="columns large-12">
								<p class="test-credit"><span class="name">Ricky David,</span><span class="profession"> Seo Consultant</span>, <span class="company">XYZ Pvt Ltd</span></p>
							</div>
						</div>
					</div>
				</div>
			</li>

			<li style="width: 100%; float: left; margin-right: -100%; position: relative; display: list-item;" class="flex-active-slide">
				<div class="row">
					<div class="columns large-3"> <img class="test-img" alt="" src="./images/test1.jpg"> </div>
					<div class="columns large-9">
						<h1>Elementum phasellus, diam tempor ultrices a mauris </h1>
						<p> Elementum phasellus, diam tempor ultrices a mauris, placerat odio nunc turpis? Aenean facilisis nisi turpis parturient sed pid massa et in est, et magna turpis ac a dapibus urna </p>
						<div class="row">
							<div class="columns large-12">
								<p class="test-credit"><span class="name">Rani Malik,</span><span class="profession"> Seo Consultant</span>, <span class="company">XYZ Pvt Ltd</span></p>
							</div>
						</div>
					</div>
				</div>
			</li>

			</ul>

			<div class="test-nav"> 
				<span class="leftarrow"><img alt="" src="./images/leftarrow.png"></span>
				<span class="rightarrow"><img alt="" src="./images/rightarrow.png"></span>
			</div>
		<ol class="flex-control-nav flex-control-paging"><li><a class="">1</a></li><li><a class="">2</a></li><li><a class="flex-active">3</a></li></ol><ul class="flex-direction-nav"><li><a href="#" class="flex-prev">Previous</a></li><li><a href="#" class="flex-next">Next</a></li></ul></div>
	</div>
</div></div>

	<div id="pl_footer" class="footer"><div class="row">

	<div class="columns large-12 footer-inner">

		<div class="row">

			<div class="columns large-4 useful-links">
				<div>
					<h2 class="footer-title">Quick links</h2>
					<ul class="footer-list">
						<li><a href="#">Home</a></li>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Products</a></li>
						<li><a href="#">Gallery</a></li>
						<li><a href="#">Contact Us</a></li>
					</ul>
				</div>
			</div>

			<div class="columns large-4 contact">
				<div>
					<h2 class="footer-title">Contactus</h2>
					<ul class="footer-list">
						<li><span class="small-icon"><img alt="" src="./images/address.png"></span>255, Willson Street,Caulfield, Melbourne</li>
						<li><span class="small-icon"><img alt="" src="./images/phone.png"></span>Tel:(122)3456789, (121)3456079, (121)2341234</li>
						<li><span class="small-icon"><img alt="" src="./images/fax.png"></span>(121)5647289, (122)34526589</li>
						<li><span class="small-icon"><img alt="" src="./images/email.png"></span>email@domain.com</li>
						<li><span class="social-media"><a href="#">t</a></span><span class="social-media"><a href="#">f</a></span><span class="social-media"><a href="#">y</a></span><span class="social-media"><a href="#">g</a></span></li>
					</ul>
				</div>
			</div>

			<div class="columns large-4 about">
				<div>
					<h2 class="footer-title">Aboutus</h2>
					<p><img alt="" src="./images/about.png"></p>
					<p>Placerat urna et tristique in! Scelerisque integer nisi pha sellus, nec phasellus arcualiquet etiam magna massa sit cursus adipiscing sed, nec? Aenean odio! Cumac dolor dapibus tincidunt lorem ipsum dolor sit esmet placerat urna et tristique in! Scelerisque integer nisi phasellus</p>
				</div>
			</div>

		</div>

	</div>

</div>
</div>







<div class="copyrights">Collect from <a title="网站模板" href="http://www.cssmoban.com/">网站模板</a></div>


</body></html>