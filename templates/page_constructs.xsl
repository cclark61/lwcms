<?xml version="1.0" encoding="ISO-8859-1"?>

<!DOCTYPE xsl:stylesheet [ 
   <!ENTITY nbsp "&#160;" >
   <!ENTITY bull "&#149;" >
   <!ENTITY copy "&#169;" >
   <!ENTITY amp "&#38;" >
   <!ENTITY mdash "&#8212;" >
]>
   
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output method="html" encoding="utf-8" indent="yes" />

<!--***********************************************-->
<!--***********************************************-->
<!-- Title Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="title">
	<title>
		<xsl:choose>
			<xsl:when test="//page/application_data/site_title != ''">
				<xsl:value-of select="//page/application_data/site_title" disable-output-escaping="yes" />
			</xsl:when>
			<xsl:otherwise>
				LWCMS
			</xsl:otherwise>
		</xsl:choose>
	</title>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Meta Headers Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="meta_headers">
	<meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Page HTML Header Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="page_html_header">
	<xsl:call-template name="meta_headers"/>
	<xsl:call-template name="title"/>

	<!--=============================================-->
	<!-- Add-in CSS Files -->
	<!--=============================================-->
	<xsl:for-each select="//page/css_files/css_file">
	  <link>
		  <xsl:for-each select="*">
			  <xsl:variable name="tagname" select="name(.)" />
			<xsl:attribute name="{$tagname}"><xsl:value-of select="." /></xsl:attribute>
		</xsl:for-each>
	</link>
	</xsl:for-each>

	<!--=============================================-->
	<!-- Standalone Web App JavaScript for Safari -->
	<!--=============================================-->
	<!--
	<script src="/javascript/stay_standalone.js" type="text/javascript"></script>
	-->

	<!--=============================================-->
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--=============================================-->
	<xsl:value-of select="string('&lt;!--[if lt IE 9]&gt;')" disable-output-escaping="yes" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<xsl:value-of select="string('&lt;![endif]--&gt;')" disable-output-escaping="yes" />

	<!--=============================================-->
	<!-- Add-in JavaScript Files -->
	<!--=============================================-->
	<xsl:for-each select="//page/js_files/js_file">
		<script type="text/javascript">
			<xsl:attribute name="src">
				<xsl:choose>
					<xsl:when test="substring(., 1, 1) = '/'">
						<xsl:value-of select="." disable-output-escaping="yes"  />
					</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="concat(//page/html_path, '/javascript/', .)" disable-output-escaping="yes"  />
					</xsl:otherwise>
				</xsl:choose>
			</xsl:attribute>
		</script>
	</xsl:for-each>

	<!--=============================================-->
	<!-- Fav and touch icons -->
	<!--=============================================-->
    <link rel="shortcut icon" href="/img/logos/lwcms_icon_trans_128.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="/img/logos/lwcms_icon_white_256.png" />
    
 	<!--=============================================-->
 	<!-- Android versions 1.5 and 1.6 (newer versions accept the apple-touch-icon above) -->
	<!--=============================================-->
    <link rel="apple-touch-icon-precomposed" href="/img/logos/lwcms_icon_white_256.png"/>

</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Page Header Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="page_header">

	<xsl:variable name="mod_args" select="/page/current_module" />
	<xsl:variable name="selected_index" select="/page/current_module_args/module_arg[@index=1]" />

	<div id="device-check" style="height: 0;">
		<div class="visible-xs"></div>
		<div class="visible-sm"></div>
		<div class="visible-md"></div>
		<div class="visible-lg"></div>
	</div>

	<div id="header" class="navbar navbar-default navbar-fixed-top">
		<div class="navbar-header">
			<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="/" class="navbar-brand">
				<xsl:choose>
					<xsl:when test="/page/application_data/site_logo_icon">
						<img class="gen_icon3">
							<xsl:attribute name="src">
								<xsl:value-of select="/page/application_data/site_logo_icon" disable-output-escaping="yes" />
							</xsl:attribute>
						</img>
					</xsl:when>
					<xsl:otherwise>
						<img src="/img/logos/lwcms_icon_trans_128.png" />
					</xsl:otherwise>
				</xsl:choose>
				<xsl:choose>
					<xsl:when test="//page/application_data/site_header != ''">
						<span>
							<xsl:value-of select="//page/application_data/site_header" disable-output-escaping="yes" />
						</span>
						<!--
						<xsl:value-of select="/page/application_data/header_title" disable-output-escaping="yes" />
						-->
					</xsl:when>
					<xsl:otherwise>
						<span>LWCMS</span>
					</xsl:otherwise>
				</xsl:choose>
			</a>
		</div>
		<div class="navbar-collapse collapse">

			<!--*******************************************-->
			<!-- Main Menu -->
			<!--*******************************************-->
			<xsl:if test="string-length(/page/application_data/main_menu) > 0">
				<ul class="nav navbar-nav home_nav">

					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" role="button" id="main_menu" href="#">
							<i class="fa fa-th-large"></i>Menu<b class="caret"></b>
						</a>
						<ul aria-labelledby="main_menu" role="menu" class="dropdown-menu">
							<xsl:value-of select="/page/application_data/main_menu" disable-output-escaping="yes" />
						</ul>
					</li>

					<!--*******************************************-->
					<!-- Current Module Sub-Menu -->
					<!--*******************************************-->
					<xsl:for-each select="/page/application_data/sub_menus/menus/*">
						<li class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" role="button" id="sub_menu" href="#">
								<xsl:if test="./data/module_image != ''">
									<i>
										<xsl:attribute name="class">
											<xsl:value-of select="./data/module_image" disable-output-escaping="yes" />
										</xsl:attribute>
									</i>
								</xsl:if>
								<xsl:value-of select="./data/modules_name" disable-output-escaping="yes" /><b class="caret"></b>
							</a>
							<ul aria-labelledby="sub_menu" role="menu" class="dropdown-menu">
								<xsl:value-of select="./items" disable-output-escaping="yes" />
							</ul>
						</li>
					</xsl:for-each>

				</ul>
			</xsl:if>

			<!--*******************************************-->
			<!-- Sub-modules Menu -->
			<!--*******************************************-->
			<!--
			<xsl:call-template name="sub-modules"/>
			-->

			<!--*******************************************-->
			<!-- Right Menus -->
			<!--*******************************************-->
			<ul class="nav navbar-nav pull-right">

				<!--*******************************************-->
				<!-- User Menu List -->
				<!--*******************************************-->
				<li class="dropdown" id="fat-menu">
					<a data-toggle="dropdown" class="dropdown-toggle" role="button" id="user_nav" href="#">
						<i class="fa fa-user"></i>
						<xsl:value-of select="/page/user/name" disable-output-escaping="yes" />
						<b class="caret"></b>
					</a>
					<ul aria-labelledby="user_nav" role="menu" class="dropdown-menu dropdown-menu-right">
						<xsl:value-of select="/page/application_data/user_menu" disable-output-escaping="yes" />
						<xsl:if test="//page/application_data/lwcms_admin_status > 0">
							<li>
								<xsl:if test="//page/application_data/segment_1 = 'admin'">
						    		<xsl:attribute name="class">active</xsl:attribute>
					    		</xsl:if>
								<a href="/admin/" tabindex="-1"><i class="fa fa-lock"></i>Admin</a>
							</li>
						</xsl:if>
						<li>
							<a tabindex="-1">
								<xsl:attribute name="href">
									<xsl:value-of select="concat(//page/application_data/base_url, 'change_pass/')" />
								</xsl:attribute>
								<i class="fa fa-asterisk"></i>Change Password
							</a>
						</li>
						<li>
							<a href="/?mod=logout" tabindex="-1"><i class="fa fa-sign-out"></i>Logout</a>
						</li>
					</ul>
				</li>
			</ul>

        </div><!--/.navbar-collapse -->
    </div>

</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Message Page HTML Header Templates -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="msg_html_header">
	<xsl:call-template name="meta_headers"/>
	<xsl:call-template name="title"/>

	<!--=============================================-->
	<!-- Base CSS -->
	<!--=============================================-->
	<link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="/bower_components/AppJack/appjack.css" rel="stylesheet" type="text/css" />
	<link href="/themes/default/msg_page.css" rel="stylesheet" type="text/css" media="all" />

	<!--=============================================-->
	<!-- Standalone Web App JavaScript for Safari -->
	<!--=============================================-->
	<script src="/javascript/stay_standalone.js" type="text/javascript"></script>

	<!--=============================================-->
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--=============================================-->
	<xsl:value-of select="string('&lt;!--[if lt IE 9]&gt;')" disable-output-escaping="yes" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<xsl:value-of select="string('&lt;![endif]--&gt;')" disable-output-escaping="yes" />

	<!--=============================================-->
	<!-- Fav and touch icons -->
	<!--=============================================-->
    <link rel="shortcut icon" href="/img/logos/lwcms_icon_trans_128.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="/img/logos/lwcms_icon_white_256.png" />
    
	<!--=============================================-->
    <!-- Android versions 1.5 and 1.6 (newer versions accept the apple-touch-icon above) -->
	<!--=============================================-->
    <link rel="apple-touch-icon-precomposed" href="/img/logos/lwcms_icon_white_256.png"/>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Message Page Header Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="msg_page_header">
	<div id="logo_wrapper">
		<xsl:choose>
			<xsl:when test="//page/application_data/msg_logo_url != ''">
				<img>
					<xsl:attribute name="src">
						<xsl:value-of select="//page/application_data/msg_logo_url" disable-output-escaping="yes" />
					</xsl:attribute>			
				</img>
			</xsl:when>
			<xsl:otherwise>
				<img src="/img/logos/lwcms_icon_trans_128.png" />
			</xsl:otherwise>
		</xsl:choose>
	</div>
	<xsl:if test="//page/application_data/msg_header != ''">
		<h2 id="header" class="center">
			<xsl:value-of select="//page/application_data/msg_header" disable-output-escaping="yes" />
		</h2>
	</xsl:if>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Message Footer Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="msg_footer">
	<div id="footer_wrapper">
		<div id="footer">
			<p class="credit muted">
				<a href="http://www.emonlade.net/lwcms/" target="_blank">lwcms</a> v<xsl:value-of select="//page/application_data/version" disable-output-escaping="yes" />
				&mdash; &copy; <xsl:value-of select="//page/application_data/curr_year" disable-output-escaping="yes" />&nbsp;<a href="http://www.emonlade.net" target="_blank">Christian J. Clark</a>
			</p>
		</div>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Footer Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="footer">
	<div id="footer">
		<div class="container">
			<p class="credit muted">
				<a href="http://www.emonlade.net/lwcms/" target="_blank">lwcms</a> v<xsl:value-of select="//page/application_data/version" disable-output-escaping="yes" />
				&mdash; &copy; <xsl:value-of select="//page/application_data/curr_year" disable-output-escaping="yes" />&nbsp;<a href="http://www.emonlade.net" target="_blank">Christian J. Clark</a>
			</p>
		</div>
	</div>
</xsl:template>

</xsl:stylesheet>
