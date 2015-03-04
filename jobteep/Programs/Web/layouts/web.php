<?php 
$controller = $_SESSION['SO']->getController();
?>

<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	    <title><?php echo $program->getInfo('title'); ?></title>
	    <meta name="description" content="<?php echo $program->getInfo('description'); ?>">
		<meta name="keywords" content="<?php echo $program->getInfo('keywords'); ?>">
		<meta name="author" content="Miguel Ángel Muñoz Viejo">
		<link rel="shortcut icon" href="<?php echo $program->getDir() ?>img/favicon.ico">
		<link rel="icon" href="<?php echo $program->getDir() ?>img/favicon.png">
		<link rel="apple-touch-icon-precomposed" href="<?php echo $program->getDir() ?>img/apple.png">
		
		<link rel="stylesheet" href="<?php echo $program->getDir() ?>css/normalize.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/main.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/solido.css">
   		<link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/foundation.css" />
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/isotope.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/responsive.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $program->getDir() ?>css/vegas/jquery.vegas.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/popup/magnific-popup.css">
        
        <!-- Colors Style -->
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/dark.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/black.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/green.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/red.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/yellow.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/purple.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/turquoise.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/orange.css">
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/color/blue.css">
        
        <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/app.css">
        
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <script src="<?php echo $program->getDir() ?>js/vendor/modernizr-2.6.2.min.js"></script>
        <script type="text/javascript">
			$(document).ready(function() {
			    $('#user').change(function(){
			
			        $('#user_error').html('<img src="Programs/Web/img/loader.gif" alt="" width = "20px" />').fadeOut(1000);
			
			        var user = $(this).val();
			
			        $.ajax({
			            type: "POST",
			            url: "ajaxRequests.php",
			            data: {user: user, action : 'register'},
			            success: function(data) {
			                $('#user_error').fadeIn(1).html(data);
			            }
			        });
			    }); 
			    $('#close').click(function() {
			    	var alt = $('#rotate');
				    switch(alt.attr("alt")) {
					    case "abierto":
					    	$('#form_content').slideToggle("slow", function(){
								$('.formulario').toggleClass("formulario_reduced");
								$('#rotate').toggleClass("rotate45");
								alt.attr("alt", "cerrado");
					    	});
						    break;
					    case "cerrado":
					    	$('.formulario').toggleClass("formulario_reduced", function() {
					    		$('#form_content').slideToggle("slow");
								$('#rotate').toggleClass("rotate45");
								alt.attr("alt", "abierto");
								$('#play').show("slow");
						    });
						    break;
				    }
				});             
			});    
		</script>
		<script>
			function avisos (message) {
				$('#message').html(message);
				$('#aviso').foundation('reveal', 'open');
			}
		</script>
		<!-- ANALYTICS -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-60227217-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
	</head>
	<body>
		<div id="videoModal" class="reveal-modal large" data-reveal="" display: block; opacity: 1;">
		  <br>
		  <div class="flex-video widescreen vimeo" style="display: block;">
		    <iframe width="1280" height="720" src="http://www.youtube-nocookie.com/embed/kn-1D5z3-Cs?rel=0" frameborder="0" allowfullscreen="" data-src="http://www.youtube-nocookie.com/embed/kn-1D5z3-Cs?rel=0"></iframe>
		  </div>
		
		  <a class="close-reveal-modal">&#215;</a>
		</div>
		
		<div id="mask">   
            <div class="loader">
              <img src="<?php echo $program->getDir() ?>img/logo.gif" width = "100" alt='loading'>
            </div>
        </div>
        
        <div id="anchor1"></div>
        
		<!-- <section id="home-fullWidth" class="clear"> -->
          
        <section id="home" class="clear">
            <div>
            	<div class="mk-video-mask"></div>
            	<a href="#anchor2" id = "bajar"></a>
            	<a id="video-volume" onclick="$('#bgndVideo').toggleVolume()"><i class="icon-volume-down"></i></a>
            	<!-- Video Background - Here you need to replace the videoURL with your youtube video URL -->
                <a id="bgndVideo" class="player mb_YTVPlayer" data-property="{videoURL:'http://www.youtube.com/watch?v=kn-1D5z3-Cs',containment:'body',autoPlay:true, mute:false, startAt:0, opacity:1}" style="display: none; background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Lamborghini Aventador LP700-4 Official Commercial [1080P]">youtube</a>
            </div>
        </section>
        
        <div class="main-title">
            <div class="title-container">
               	<div class = "formulario">
               		<div id = "form_content">
               			<h1>JOBTeep</h1><br>
               			<?php 
               			if (!isset($_GET['menu']) || $_GET['menu'] == 'login')
               				include $program->getDir().'pages/login.php';
               			else if ($_GET['menu'] == 'register')
               				include $program->getDir().'pages/register.php';
               			else if ($_GET['menu'] == 'passRecover')
               				include $program->getDir().'pages/passRecover.php';
               			else if ($_GET['menu'] == 'changePass')
               				include $program->getDir().'pages/changePass.php';
               			else 
               				include $program->getDir().'pages/login.php';
               			?>
					</div>
					<div class = "show-for-large-up">
						<span id = "close"><img id = "rotate" alt = "abierto" src = "<?php echo $program->getDir() ?>img/close.png" width = "30"></span>
					</div>
               	</div>
               	<!-- <div id = "frases">
               		<div class="welcome">Bienvenido</div>
	                <ul>
	                    <li class="t-current">Estrena tu mejor versión</li>
	                    <li>We Are Smart</li>
	                    <li>We Are Fresh</li>
	                </ul>
               	</div> -->
        	</div>
        </div>
		
		<div id="logx"></div>
        <header class="header">
            <div class="logo"><img src = "<?php echo $program->getDir() ?>img/logo_once.gif" width = "50px">  JOBTEEP</div>
            <nav id="nav2" role="navigation">
                <a class="jump-menu" title="Show navigation">Show navigation</a>
                <ul>
                    <li class="current"><a href="#anchor1">bienvenido</a></li>
                    <li><a href="#anchor2">proyecto</a></li>
                    <li><a href="#anchor3">panel</a></li>
                    <li><a href="#anchor4">Teep</a></li>
                    <li><a href="#anchor5">ADNTeep</a></li>
                    <!-- <li><a href="#">blog</a></li> -->
                    <li><a href="#anchor6">contacto</a></li>
                </ul>
            </nav>
            <nav class="menu">
                <ul id="nav">
                    <li class="current"><a href="#anchor1">bienvenido</a></li>
                    <li><a href="#anchor2">proyecto</a></li>
                    <li><a href="#anchor3">panel</a></li>
                    <li><a href="#anchor4">Teep</a></li>
                    <li><a href="#anchor5">ADNTeep</a></li>
                    <!-- <li><a href="#">blog</a></li> -->
                    <li><a href="#anchor6">contacto</a></li>
                </ul>
            </nav>
        </header>
        
         <article id="anchor2" class="content menu-top dark">
         	<div class = "row  hideme dontHide">
         		<div class = "small-12 columns text-center ">
         			<img src = "<?php echo $program->getDir() ?>img/logo_once.gif" width = "150"><br>
         		</div>
         	</div>
        	<header class="title one">Reinventando el Curriculum</header>
            <div class="spacer"></div>
            <div class="title two hideme dontHide">Piensa en la palabra curriculum. ¿Qué imagen te viene a la cabeza? ¿Un folio en blanco y negro quizás? Bien, ahora piensa en un anuncio que hayas visto hace poco, uno de café, de un coche, lo que sea. ¿Cómo es el anuncio? ¿Un montón de texto describiendo el producto en blanco y negro? No lo creo...<br><br>En Jobteep hemos creado el Teep, un espacio que te da la oportunidad de diferenciarte y sentirte identificado/a, un espacio para venderte.</div>
        </article>
       	<div class = "row hide-for-large-up">
        	<iframe width="100%" height="480" src="https://www.youtube.com/embed/kn-1D5z3-Cs?rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
        
        <div class="clear"></div>
        <article class="parallax p-one">
        	<div class="p-title-one">Nuestro Mantra</div>
            <div class="p-title-two">"Mostrar lo mejor de nuestros usuarios"</div>
            <div class="spacer"></div>
            <div class="p-image-02">
                <div class="p-image-second hideme-slide dontHide delay"><img src="<?php echo $program->getDir() ?>img/parallax/p-image-03.png" alt='img'></div>
                <div class="p-image-first hideme-slide dontHide"><img src="<?php echo $program->getDir() ?>img/parallax/p-image-02.png" alt='img'></div>
            </div>
            <div class="clear"></div>
        </article>
        
        <div class="clear"></div>
        <article id=anchor3 class="content light">
            <div class = "row">
            	<div class = "small-12 columns">
            		<div class = "medium-7 columns text-center doble">
            			<header class="title-one">Gestiona tu Información</header>
                    	<h2 class="subtitulo_black">El Panel</h2>
            			Toda la información que pondrías en tu curriculum y mucho más, la gestionas desde el panel de JOBTeep. Para facilitarte la tarea, puedes importar los datos de tu perfil de Linkedin.
            		</div>
            		<div class = "medium-5 columns hideme dontHide doble">
            			<img src = "<?php echo $program->getDir() ?>img/movil.png" alt = "jobteep movil">
            		</div>
            	</div>
            </div>
        </article>
        
        <div class="clear"></div>
        <article id=anchor4 class="teep">
        	<div class="p-title-one">La mejor forma de venderte</div>
            <h2 class = "subtitulo">Teep</h2>
            <div class="spacer newtr2"></div>
            <div class = "row">
            	<div class = "small-12 columns">
            		<div class="pwhite">Un teep es la reinvención del curriculum, es un espacio personal en el que podrán verte desde cualquier parte y en cualquier momento. Queremos ofrecerte la opción de que lo personalices a tu gusto y sea atractivo para venderte mejor.</div>
            	</div>
            	<div class = "small-12 columns text-center">
            		<div class="hideme dontHide"><img src="<?php echo $program->getDir() ?>img/devices.png" alt='img'></div>
            	</div>
            </div>
        </article>
        
         <article id=anchor5 class="content dark">
        	<header class="title one">ADNTeep</header>
            <div class="spacer"></div>
            <div class="title two">Como todos sabemos, el objetivo final de un curriculum es conseguir un trabajo. Por eso hemos creado ADNTeep, un panel en el que se analizan vuestras competencias, puntos fuertes y compatibilidades con las empresas. De esta forma podemos recomendaros a las empresas interesadas y orientaros sobre como mejorar en vuestro sector.</div>
            <div class = "row">
            	<?php include 'SO/Tests/d3/grafica.html'; ?>
            </div>
        </article>
        
        <article class="content light">
        	<section class="full">
            	<div class="title-full-one">disfrutándo</div>
                <div class="title-full-two">Datos Curiosos</div>
                <div class="f-container">
                    <div class="f-element hideme dontHide">
                        <div class="f-ico s-one"></div>
                        <div class="milestone-counter" data-perc="63<?php /*echo $controller->getNumTweets ()*/ ?>">
                       		<span class="milestone-count highlight">0</span> <!-- Initial Value = 0 -->
                            <div class="milestone-details">Tweets</div>
                        </div>
                    </div>
                    <div class="f-element hideme dontHide">
                        <div class="f-ico s-two"></div>
                        <div class="milestone-counter" data-perc="<?php echo $controller->getNumUsers () ?>">
                       		<span class="milestone-count highlight">0</span> <!-- Initial Value = 0 -->
                            <div class="milestone-details">Usuarios</div>
                        </div>
                    </div>
                    <?php 
                    $datetime1 = new DateTime('2015-03-04');
                    $datetime2 = new DateTime('now');
                    $interval = $datetime1->diff($datetime2);
                    $dias = $interval->format('%R%a');
                    ?>
                    <div class="f-element hideme dontHide">
                        <div class="f-ico s-three"></div>
                        <div class="milestone-counter" data-perc="<?php echo $dias; ?>">
                       		<span class="milestone-count highlight">0</span> <!-- Initial Value = 0 -->
                            <div class="milestone-details">Días de Vida</div>
                        </div>
                    </div>
                    <div class="f-element hideme dontHide">
                        <div class="f-ico s-four"></div>
                        <div class="milestone-counter" data-perc="184">
                       		<span class="milestone-count highlight">0</span> <!-- Initial Value = 0 -->
                            <div class="milestone-details">Tazas de Café</div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="clear"></div>
        </article>
        
        <article class="content dark">
        	<section class="img-spacer">
            	<div class="img-item hideme dontHide"><img src="<?php echo $program->getDir() ?>img/imac.png" alt='img'></div>
            </section>
        </article>
        
        <footer id=anchor6 class="footer light">
            <div class="footer-container">
            	<div class="title one no-top">Contacto</div>
                <div class="spacer"></div>
                <div class="title two f-bottom">Estamos encantados de recibir sugerencias para poder mejorar y adaptar JOBTeep lo máximo posible a vuestras necesidades!</div>
                <div class="email hideme dontHide"><a href = "mailto:hi@jobteep.com">hi@jobteep.com</a></div>
            </div>
        </footer>
        <a href="#" class="scrollup">^</a>
        <div class="socialFooter">
        	<!-- <div class="social-icons">
                <div class="social">
                    <a href="https://es-es.facebook.com/" target="_blank"><div class="face"></div></a>
                    <a href="https://twitter.com/" target="_blank"><div class="twitt"></div></a>
                    <a href="https://plus.google.com/" target="_blank"><div class="plus"></div></a>
                </div>
            </div>
            <div class="clear"></div> -->
            <div class="copy">2015 © JOBTeep. Todos los derechos reservados.</div>            
        </div>
        
        
        <script>window.jQuery || document.write('<script src="<?php echo $program->getDir() ?>js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script type="text/javascript" src="<?php echo $program->getDir() ?>js/jquery.carouFredSel-6.2.1-packed.js"></script>
        <script src="<?php echo $program->getDir() ?>js/jquery.smoothwheel.js"></script>
        <script src="<?php echo $program->getDir() ?>js/main.js"></script>
        <script src="<?php echo $program->getDir() ?>js/jquery.inview.js"></script>
        <script type="text/javascript" 	src="<?php echo $program->getDir() ?>js/jquery.sticky.js"></script>
        <script type="text/javascript" src="<?php echo $program->getDir() ?>js/caroussel/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="<?php echo $program->getDir() ?>js/vegas/jquery.vegas.js"></script>
        <script type="text/javascript" src="<?php echo $program->getDir() ?>js/jquery.hoverdir.js"></script>
        <script src="<?php echo $program->getDir() ?>js/jquery.nav.js"></script>
        <script src="<?php echo $program->getDir() ?>js/popup/jquery.magnific-popup.js"></script>
		<script type="text/javascript" src="<?php echo $program->getDir() ?>js/caroussel/jquery.contentcarousel.js"></script>
		<script src="<?php echo $program->getDir() ?>js/jquery.isotope.min.js"></script>
        <script src="<?php echo $program->getDir() ?>js/plugins.js"></script>
        <script src="<?php echo $program->getDir() ?>js/video/jquery.mb.YTPlayer.js"></script>
        <script src="<?php echo $program->getDir() ?>js/jquery.validate.js"></script>
        <script src="<?php echo $program->getDir() ?>js/jquery.form.js"></script>            
        <script src="<?php echo $program->getDir() ?>js/test.js"></script>
        
        <script src="<?php echo $program->getDir() ?>js/vendor/fastclick.js"></script>
	    <script src="<?php echo $program->getDir() ?>js/foundation.min.js"></script>
	    <script>
	      $(document).foundation();
	    </script>
	</body>
</html>