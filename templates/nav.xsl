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

<!--***********************************************-->
<!-- Primary Template -->
<!--***********************************************-->
<xsl:template name="primary_nav">
	<xsl:variable name="mod_args" select="/page/current_module" />
	<xsl:variable name="selected_index" select="/page/current_module_args/module_arg[@index=1]" />

	<div id="primary_nav">
		<ul class="nav nav-list">
			<li class="nav-header">Home Menu</li>
			<xsl:for-each select="/page/nav/module[@index=0]/sub_modules/*">
				<xsl:choose>
					<xsl:when test="count(/page/current_module_args/*) > 1">
						<xsl:call-template name="nav_item">
							<xsl:with-param name="base" select="." />
							<xsl:with-param name="selected_index" select="$selected_index" />
						</xsl:call-template>
					</xsl:when>
					<xsl:otherwise>
						<xsl:call-template name="nav_item">
							<xsl:with-param name="base" select="." />
						</xsl:call-template>
					</xsl:otherwise>
				</xsl:choose>
			</xsl:for-each>
		</ul>
	</div>
</xsl:template>

<!--***********************************************-->
<!-- Sub Navs Template -->
<!--***********************************************-->
<xsl:template name="sub_navs">
	<xsl:call-template name="primary_nav"/>

	<xsl:for-each select="/page/current_module_args/*">
		<xsl:call-template name="print_nav">
			<xsl:with-param name="curr_mod" select="." />
			<xsl:with-param name="stop_depth" select="@index" />
			<xsl:with-param name="curr_depth" select="0" />
			<xsl:with-param name="base" select="/page/nav/module[@index=0]" />
		</xsl:call-template>
	</xsl:for-each>
</xsl:template>

<!--***********************************************-->
<!-- Print Nav Template -->
<!--***********************************************-->
<xsl:template name="print_nav">
	<xsl:param name="curr_mod" />
	<xsl:param name="stop_depth" />
	<xsl:param name="curr_depth" />
	<xsl:param name="base" />

	<xsl:variable name="mod_arg_index" select="/page/current_module_args/module_arg[@index=$curr_depth+1]" />

	<xsl:choose>
		<xsl:when test="$stop_depth = $curr_depth">
			<xsl:if test="$base/sub_modules">
				<hr/>
				<ul class="nav nav-list">
					<li class="nav-header"><xsl:value-of select="$base/title" disable-output-escaping="yes" /></li>
					<xsl:for-each select="$base/sub_modules/*">
						<xsl:call-template name="nav_item">
							<xsl:with-param name="base" select="." />
							<xsl:with-param name="curr_mod_arg_index" select="$mod_arg_index" />
							<xsl:with-param name="curr_depth" select="($curr_depth + 1) * 2" />
						</xsl:call-template>
					</xsl:for-each>
				</ul>
			</xsl:if>
		</xsl:when>
		<xsl:otherwise>
			<xsl:call-template name="print_nav">
				<xsl:with-param name="curr_mod" select="$curr_mod" />
				<xsl:with-param name="stop_depth" select="$stop_depth" />
				<xsl:with-param name="curr_depth" select="$curr_depth + 1" />
				<xsl:with-param name="base" select="$base/sub_modules/module[@index=$mod_arg_index]" />
			</xsl:call-template>
		</xsl:otherwise>
	</xsl:choose>
	
</xsl:template>

<!--**************************************************-->
<!-- Nav Item Template -->
<!--**************************************************-->
<xsl:template name="nav_item">
    <xsl:param name="base" />
    <xsl:param name="curr_mod_arg_index" />
    <xsl:param name="curr_depth" />
    <xsl:param name="selected_index" />

    <li>
    	<xsl:choose>
	        <xsl:when test="$selected_index != '' and $selected_index = $base/@index">
	            <xsl:attribute name="class">active_parent</xsl:attribute>
	        </xsl:when>
	        <xsl:when test="$base/mod_string = /page/current_module">
	            <xsl:attribute name="class">active</xsl:attribute>
	        </xsl:when>
	        <xsl:when test="$curr_mod_arg_index = $base/@index and $curr_depth = $base/@depth">
	            <xsl:attribute name="class">active_parent</xsl:attribute>
	        </xsl:when>
    	</xsl:choose>
        <a>
            <xsl:attribute name="href"><xsl:value-of select="concat(/page/html_path, $base/url)"/></xsl:attribute>
            <xsl:value-of select="$base/title" />
        </a>
    </li>
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
					<xsl:if test="$separator != ''">
						<span class="divider"><xsl:value-of select="$separator" disable-output-escaping="yes" /></span>
					</xsl:if>
					<xsl:value-of select="." disable-output-escaping="yes" />
				</li>
			</xsl:for-each>
		</ul>
	</xsl:if>
</xsl:template>

<!--***********************************************-->
<!-- Sub Modules Template -->
<!--***********************************************-->
<xsl:template name="sub-modules">
	<xsl:if test="/page/application_data/sub_modules/nav_items">
	    <ul class="nav navbar-nav">
			<xsl:for-each select="/page/application_data/sub_modules/nav_items/*">
				<xsl:call-template name="sm_nav_item">
					<xsl:with-param name="desc" select="./desc" />
					<xsl:with-param name="link" select="./link" />
					<xsl:with-param name="image" select="./image" />
					<xsl:with-param name="class" select="./class" />			
					<xsl:with-param name="page_key" select="./page_key" />
					<xsl:with-param name="curr_page" select="./curr_page" />
				</xsl:call-template>
			</xsl:for-each>
	    </ul>
	</xsl:if>
</xsl:template>

<!--***********************************************-->
<!-- Sub-module Nav Item Template -->
<!--***********************************************-->
<xsl:template name="sm_nav_item">
	<xsl:param name="desc" />
	<xsl:param name="link" />
	<xsl:param name="image" />
	<xsl:param name="class" />
	<xsl:param name="page_key" />
	<xsl:param name="curr_page" />

	<li>
		<xsl:choose>
			<xsl:when test="$class">
				<xsl:attribute name="class">
					<xsl:value-of select="$class" disable-output-escaping="yes" />
					<xsl:if test="$curr_page != '' and $curr_page = $page_key">
						<xsl:value-of select="' selected'" disable-output-escaping="yes" />
					</xsl:if>
				</xsl:attribute>
			</xsl:when>
			<xsl:otherwise>
				<xsl:if test="$curr_page != '' and $curr_page = $page_key">
					<xsl:attribute name="class">
						<xsl:value-of select="'selected'" disable-output-escaping="yes" />
					</xsl:attribute>
				</xsl:if>			
			</xsl:otherwise>
		</xsl:choose>
		<a>
			<xsl:attribute name="href">
				<xsl:value-of select="$link"/>
			</xsl:attribute>
			<xsl:if test="$image">
				<i>
					<xsl:attribute name="class">
						<xsl:value-of select="$image" disable-output-escaping="yes" />
					</xsl:attribute>
				</i>
			</xsl:if>
			<xsl:value-of select="$desc" disable-output-escaping="yes" />
		</a>
	</li>
</xsl:template>

</xsl:stylesheet>
