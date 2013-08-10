<?xml version="1.0" encoding="ISO-8859-1"?>

<!DOCTYPE xsl:stylesheet [ 
   <!ENTITY nbsp "&#160;" >
   <!ENTITY bull "&#149;" >
   <!ENTITY copy "&#169;" >
   <!ENTITY amp "&#38;" >
]>
   
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xml:lang="en">

<!--***********************************************-->
<!--***********************************************-->
<!-- Main Layout Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="layout">

    <div class="row-fluid" id="content-wrapper">

	    <xsl:choose>
	    	<xsl:when test="//page/application_data/layout_type = '2col'">
    			<div class="span3" id="col1">
	    			<xsl:call-template name="layout-box">
	    				<xsl:with-param name="title" select="//page/application_data/mod_title1" />
	    				<xsl:with-param name="icon_class" select="//page/application_data/mod_icon_class1" />
	    				<xsl:with-param name="content_template" select="string('col1_content')" />
	    			</xsl:call-template>
    			</div>
    			<div class="span9" id="col2">
	    			<xsl:call-template name="layout-box">
	    				<xsl:with-param name="title" select="//page/application_data/mod_title" />
	    				<xsl:with-param name="icon_class" select="//page/application_data/mod_icon_class" />
	    				<xsl:with-param name="content_template" select="string('mainContent')" />
	    			</xsl:call-template>
    			</div>
	    	</xsl:when>
	    	<xsl:when test="//page/application_data/layout_type = '3col'">
    			<div class="span3" id="col1">
	    			<xsl:call-template name="layout-box">
	    				<xsl:with-param name="title" select="//page/application_data/mod_title1" />
	    				<xsl:with-param name="icon_class" select="//page/application_data/mod_icon_class1" />
	    				<xsl:with-param name="content_template" select="string('col1_content')" />
	    			</xsl:call-template>
    			</div>
    			<div class="span7" id="col2">
	    			<xsl:call-template name="layout-box">
	    				<xsl:with-param name="title" select="//page/application_data/mod_title" />
	    				<xsl:with-param name="icon_class" select="//page/application_data/mod_icon_class" />
	    				<xsl:with-param name="content_template" select="string('mainContent')" />
	    			</xsl:call-template>
    			</div>	    	
    			<div class="span2" id="col3">
	    			<xsl:call-template name="layout-box">
	    				<xsl:with-param name="title" select="//page/application_data/mod_title3" />
	    				<xsl:with-param name="icon_class" select="//page/application_data/mod_icon_class3" />
	    				<xsl:with-param name="content_template" select="string('col3_content')" />
	    			</xsl:call-template>
    			</div>
	    	</xsl:when>
	    	<xsl:otherwise>
    			<div class="span12">
	    			<xsl:call-template name="layout-box">
	    				<xsl:with-param name="title" select="//page/application_data/mod_title" />
	    				<xsl:with-param name="icon_class" select="//page/application_data/mod_icon_class" />
	    				<xsl:with-param name="content_template" select="string('mainContent')" />
	    			</xsl:call-template>
    			</div>	    		    	
	    	</xsl:otherwise>
	    </xsl:choose>

	</div>

</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Layout Box Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="layout-box">
	<xsl:param name="title" />
	<xsl:param name="icon_class" />
	<xsl:param name="content" />
	<xsl:param name="content_template" />

	<div class="layout-box">
		<div class="layout-box-title">
			<span class="icon">
				<i class="icon-th-list">
					<xsl:if test="$icon_class">
						<xsl:attribute name='class'>
							<xsl:value-of select="$icon_class" disable-output-escaping="yes" />
						</xsl:attribute>
					</xsl:if>
				</i>
				<span class="break"></span>
			</span>
			<h2 xml:space="preserve"><xsl:value-of select="$title" disable-output-escaping="yes" /></h2>
			<xsl:call-template name="layout-box-buttons" />
		</div>
		<div class="layout-box-content">
			<xsl:choose>
				<xsl:when test="$content_template = 'mainContent'">
					<xsl:call-template name="mainContent" />
				</xsl:when>
				<xsl:when test="$content_template = 'col1_content'">
					<xsl:call-template name="col1_content" />
				</xsl:when>
				<xsl:when test="$content_template = 'col3_content'">
					<xsl:call-template name="col3_content" />
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="$content" disable-output-escaping="yes" />
				</xsl:otherwise>
			</xsl:choose>
		</div>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Layout Box Buttons Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="layout-box-buttons">

	<!--===============================================-->
	<!-- Back Link -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/back_link">
		<div id="back-btn2" class="right hidden-phone">
			<a class="btn btn-warning">
				<xsl:attribute name="href">
					<xsl:value-of select="//page/application_data/back_link" disable-output-escaping="yes" />
				</xsl:attribute>
				Go Back
			</a>
		</div>
	</xsl:if>

</xsl:template>

</xsl:stylesheet>
