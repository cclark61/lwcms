<?xml version="1.0" encoding="ISO-8859-1"?>

<!DOCTYPE xsl:stylesheet [ 
   <!ENTITY nbsp "&#160;" >
   <!ENTITY bull "&#149;" >
   <!ENTITY copy "&#169;" >
   <!ENTITY amp "&#38;" >
]>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xml:lang="en">

<xsl:import href="page_constructs.xsl"/>
<xsl:import href="nav.xsl"/>
<xsl:import href="content.xsl"/>
<xsl:import href="layout.xsl"/>

<xsl:output method="html" encoding="utf-8" indent="yes" />

<!--*********************************************************************-->
<!--*********************************************************************-->
<!-- Page Template -->
<!--*********************************************************************-->
<!--*********************************************************************-->
<xsl:template match="page">
	<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
    <html>
        <head>
			<xsl:call-template name="page_html_header"/>
        </head>

        <body>
	        <div id="page_wrapper">

		        <!--=========================================-->
				<!-- Header -->
				<!--=========================================-->
				<xsl:call-template name="page_header"/>
	
				<!--=========================================-->
				<!-- Content -->
				<!--=========================================-->
				<div id="main" class="container-fluid">
					<xsl:call-template name="content_header"/>
					<xsl:call-template name="layout"/>
					<xsl:call-template name="content_footer"/>
				</div>
					
	        </div>

	        <!--=========================================-->
			<!-- Footer -->
			<!--=========================================-->
			<xsl:call-template name="footer"/>

		</body>
	</html>
</xsl:template>

</xsl:stylesheet>
