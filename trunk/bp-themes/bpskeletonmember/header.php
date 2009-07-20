<?php
/*
 * /header.php
 * Loaded at the beginning of every page.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bp_page_title() ?></title>
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

	<?php bp_styles(); ?>
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/reset.css" type="text/css" media="screen" title="no title" charset="utf-8" />
  
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/fancybox.css" type="text/css" media="screen" title="no title" charset="utf-8" />
  
  
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <!--[if lte IE 8]>

  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styleIE.css" type="text/css" media="screen" />

  <![endif]-->

  <!--[if lte IE 7]>

  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styleIE6.css" type="text/css" media="screen" />

  <![endif]-->

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8" ></script>
  <script src="<?php bloginfo('template_url'); ?>/js/jquery.fancybox-1.2.1.pack.js" type="text/javascript" charset="utf-8" ></script>

  <!--[if !IE]><!-->

    <script src="<?php bloginfo('template_url'); ?>/js/site.js" type="text/javascript" charset="utf-8" ></script>

  <!-- <![endif]-->


  <!--[if lte IE 8]>

    <script src="<?php bloginfo('template_url'); ?>/js/siteie.js" type="text/javascript" charset="utf-8" ></script>

  <![endif]-->

	
	<?php wp_head(); ?>

</head>

<body>

  <div id="top_menu">
    <p>
      <span class="left">resistencia ciudadana | mi&eacute;rcoles, 29 de abril de 2009</span>
      <span class="right">        
        <a href="http://lamula.pe/wp-login.php">inicia sesi&oacute;n</a>        
        <a href="http://lamula.pe/crear-blog/">crea tu blog</a>
        <a href="http://lamula.pe/mimula">mándanos tu noticia</a>
      </span>
    </p>
  </div> <!-- top_menu -->

  <div id="wrapper">

       <div id="top_ad">
         <!-- <img src="<?php bloginfo('template_url'); ?>/images/ad_bcp.png" alt="Ad BCP" title="AD BCP"/> -->
       </div> <!-- top_ad -->

       <div id="logo_bar">

         <h1><a href="<?php bloginfo('siteurl'); ?>">La Mula</a></h1> 

         <div id="search_bar">
             <form action="#">
               <input type="text" name="busqueda" value="" id="busqueda" />
               <input type="submit" value="buscar" />
             </form>
         </div> <!-- search_bar -->

       </div> <!-- logo_bar -->

       <div id="status_bar">
           <?php bp_login_bar() ?>        
         	<ul id="menu_bar">
         		<li<?php if ( bp_is_page( 'home' ) ) : ?> class="selected"<?php endif; ?>>
         			<a href="<?php echo get_option('home') ?>" title="<?php _e( 'LaMula', 'buddypress' ) ?>"><?php _e( 'Principal', 'buddypress' ) ?></a>
         		</li>

         		<li<?php if ( bp_is_page( BP_MEMBERS_SLUG ) ) : ?> class="selected"<?php endif; ?>>
         			<a href="<?php echo get_option('home') ?>/members" title="<?php _e( 'Muleros', 'buddypress' ) ?>"><?php _e( 'Muleros', 'buddypress' ) ?></a>
         		</li>

         		<?php if ( function_exists( 'groups_install' ) ) : ?>
         			<li<?php if ( bp_is_page( BP_GROUPS_SLUG ) ) : ?> class="selected"<?php endif; ?>>
         				<a href="<?php echo get_option('home') ?>/<?php echo BP_GROUPS_SLUG ?>" title="<?php _e( 'Grupos', 'buddypress' ) ?>"><?php _e( 'Grupos', 'buddypress' ) ?></a>
         			</li>
         		<?php endif; ?>

         		<?php if ( function_exists( 'bp_blogs_install' ) ) : ?>
         			<li<?php if ( bp_is_page( BP_BLOGS_SLUG ) ) : ?> class="selected"<?php endif; ?>>
         				<a href="<?php echo get_option('home') ?>/<?php echo BP_BLOGS_SLUG ?>" title="<?php _e( 'Blogs', 'buddypress' ) ?>"><?php _e( 'Blogs', 'buddypress' ) ?></a>
         			</li>
         		<?php endif; ?>

         		<?php do_action( 'bp_nav_items' ); ?>
         	</ul>

       </div> <!-- status_bar -->

	
	

<?php load_template ( TEMPLATEPATH . '/userbar.php' ) ?>
<?php load_template ( TEMPLATEPATH . '/optionsbar.php' ) ?>
