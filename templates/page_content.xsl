<?xml version="1.0" encoding="ISO-8859-1"?>

<!DOCTYPE xsl:stylesheet [ 
   <!ENTITY nbsp "&#160;" >
   <!ENTITY bull "&#149;" >
   <!ENTITY copy "&#169;" >
   <!ENTITY amp "&#38;" >
]>
   
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method='xml' omit-xml-declaration="yes" version='1.0' encoding='UTF-8' indent='yes' />

<!--***********************************************-->
<!-- Page Menu Links -->
<!--***********************************************-->
<xsl:template match="page_links_list">
	<ul class="nav nav-tabs nav-stacked">
		<xsl:if test="./class">
			<xsl:attribute name="class"><xsl:value-of select="concat(./class, ' nav nav-tabs nav-stacked')"/></xsl:attribute>
		</xsl:if>
		<xsl:for-each select="./links/*">
			<li>
				<a>
					<xsl:if test="./class">
						<xsl:attribute name="class"><xsl:value-of select="./class"/></xsl:attribute>
					</xsl:if>
					<xsl:attribute name="href"><xsl:value-of select="./link"/></xsl:attribute>
					<xsl:if test="./image"><xsl:value-of select="./image" disable-output-escaping="yes" /></xsl:if>
					<xsl:value-of select="./desc"/>
				</a>
			</li>
		</xsl:for-each>
	</ul>
</xsl:template>


</xsl:stylesheet>