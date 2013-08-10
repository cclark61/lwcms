<?xml version="1.0" encoding="ISO-8859-1"?>

<!DOCTYPE xsl:stylesheet [ 
   <!ENTITY nbsp "&#160;" >
   <!ENTITY bull "&#149;" >
   <!ENTITY copy "&#169;" >
   <!ENTITY amp "&#38;" >
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
				LWCMS - <xsl:value-of select="//page/application_data/site_title" disable-output-escaping="yes" />
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
	<script src="/javascript/stay_standalone.js" type="text/javascript"></script>

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
					<xsl:when test="substring(., 1, 5) = '/cdn/'">
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
	<!-- jQuery / Bootstrap JS -->
	<!--=============================================-->
	<script type="text/javascript" src="/themes/bootstrap/js/bootstrap.min.js" />

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

	<div id="header" class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a href="/" class="brand">
					<xsl:choose>
						<xsl:when test="//page/application_data/site_header != ''">
							<xsl:value-of select="//page/application_data/site_header" disable-output-escaping="yes" />
						</xsl:when>
						<xsl:otherwise>
							LWCMS
						</xsl:otherwise>
					</xsl:choose>
				</a>
				<div class="nav-collapse collapse">

		            <xsl:call-template name="top_left_nav" />

					<ul class="nav pull-right">

						<!-- ******************************************* -->
						<!-- Admin Link -->
						<!-- ******************************************* -->
						<xsl:if test="//page/application_data/lwcms_admin_status > 0">
							<li>
								<xsl:if test="//page/application_data/segment_1 = 'admin'">
						    		<xsl:attribute name="class">active</xsl:attribute>
					    		</xsl:if>
								<a href="/admin/" tabindex="-1">Admin</a>
							</li>
						</xsl:if>

						<!-- ******************************************* -->
						<!-- User Menu List -->
						<!-- ******************************************* -->
						<li class="dropdown" id="fat-menu">
							<a data-toggle="dropdown" class="dropdown-toggle" role="button" id="user_nav" href="#">
								<xsl:choose>
									<xsl:when test="//page/user/name">
										<xsl:value-of select="//page/user/name" />
									</xsl:when>
									<xsl:otherwise>
										<xsl:value-of select="//page/user/userid" />
									</xsl:otherwise>
								</xsl:choose>
								<b class="caret"></b>
							</a>
							<ul aria-labelledby="user_nav" role="menu" class="dropdown-menu">
								
								<xsl:if test="//page/application_data/change_password = '1'">
									<li>
										<a><xsl:attribute name="href"><xsl:value-of select="concat(//page/application_data/base_url, 'change_pass/')" /></xsl:attribute>Change Password</a>
									</li>
								</xsl:if>
								
								<li><a href="/?mod=logout" tabindex="-1">Logout</a></li>
							</ul>
						</li>
					</ul>
	            </div><!--/.nav-collapse -->
	        </div>
	    </div>
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
	<link href="/themes/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="/themes/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
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
	<!-- jQuery / Bootstrap JS -->
	<!--=============================================-->
	<!-- <script type="text/javascript" src="/themes/bootstrap/js/bootstrap.min.js" /> -->

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
	<xsl:if test="//page/application_data/msg_logo_url != ''">
		<div id="logo_wrapper">
			<xsl:value-of select="//page/application_data/msg_logo_url" disable-output-escaping="yes" />
		</div>
	</xsl:if>
	<h2 id="header">
		<xsl:choose>
			<xsl:when test="//page/application_data/msg_header != ''">
				<xsl:value-of select="//page/application_data/msg_header" disable-output-escaping="yes" />
			</xsl:when>
			<xsl:otherwise>
				LWCMS
			</xsl:otherwise>
		</xsl:choose>
	</h2>
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
				<xsl:if test="//page/application_data/msg_footer != ''">
					<xsl:value-of select="//page/application_data/msg_footer" disable-output-escaping="yes" />
				</xsl:if>
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
				<xsl:choose>
					<xsl:when test="//page/application_data/site_footer != ''">
						<xsl:value-of select="//page/application_data/site_footer" disable-output-escaping="yes" />
						- Built using <a href="http://www.emonlade.net/lwcms/" target="_blank">LWCMS</a> v<xsl:value-of select="//page/application_data/version" disable-output-escaping="yes" />
					</xsl:when>
					<xsl:otherwise>
						<a href="http://www.emonlade.net/lwcms/" target="_blank">LWCMS</a> v<xsl:value-of select="//page/application_data/version" disable-output-escaping="yes" />
						- Licensed under the <a href="http://www.gnu.org/licenses/gpl-2.0.txt" target="_blank">GNU General Public License (GPL) v2.0</a>
					</xsl:otherwise>
				</xsl:choose>
			</p>
		</div>
	</div>
</xsl:template>

</xsl:stylesheet>
