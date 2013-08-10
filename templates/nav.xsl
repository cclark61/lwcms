<?xml version="1.0" encoding="ISO-8859-1"?>

<!DOCTYPE xsl:stylesheet [ 
   <!ENTITY nbsp "&#160;" >
   <!ENTITY bull "&#149;" >
   <!ENTITY copy "&#169;" >
   <!ENTITY amp "&#38;" >
   <!ENTITY raquo "&#187;" >
]>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:dyn="http://exslt.org/dynamic" extension-element-prefixes="dyn">

<xsl:output method="html" encoding="utf-8" indent="yes" />

<!--***************************************************************-->
<!--***************************************************************-->
<!-- Top Left Nav Template -->
<!--***************************************************************-->
<!--***************************************************************-->
<xsl:template name="top_left_nav">
	<ul class="nav">
    	<li>
    		<xsl:if test="//page/application_data/segment_1 = ''">
	    		<xsl:attribute name="class">active</xsl:attribute>
    		</xsl:if>
    		<a href="/">Home</a>
    	</li>

    	<!--===============================================-->
		<!-- Top Level Breadcrumbs -->
    	<!--===============================================-->
		<xsl:for-each select="//page/application_data/breadcrumbs/*">
			<li>
				<xsl:value-of select="." disable-output-escaping="yes" />
			</li>
		</xsl:for-each>
    </ul>
</xsl:template>

<!--***************************************************************-->
<!--***************************************************************-->
<!-- Breadcrumbs Template -->
<!--***************************************************************-->
<!--***************************************************************-->
<xsl:template name="breadcrumbs">
	<xsl:param name="base" />
	<xsl:param name="id" />
	<xsl:param name="separator" />

	<xsl:if test="$base/.">
		<ul class="breadcrumb">
			<xsl:if test="$id">
				<xsl:attribute name="id"><xsl:value-of select="$id" disable-output-escaping="yes" /></xsl:attribute>
			</xsl:if>
			<xsl:for-each select="$base/*">
				<li>
					<xsl:choose>
						<xsl:when test="$separator != ''">
							<span class="divider"><xsl:value-of select="$separator" disable-output-escaping="yes" /></span>
						</xsl:when>
						<xsl:otherwise>
							<span class="divider">&raquo;</span>
						</xsl:otherwise>
					</xsl:choose>
					<xsl:value-of select="." disable-output-escaping="yes" />
				</li>
			</xsl:for-each>
		</ul>
	</xsl:if>
</xsl:template>

</xsl:stylesheet>
