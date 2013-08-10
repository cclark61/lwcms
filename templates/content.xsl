<?xml version="1.0" encoding="ISO-8859-1"?>

<!DOCTYPE xsl:stylesheet [ 
   <!ENTITY nbsp "&#160;" >
   <!ENTITY bull "&#149;" >
   <!ENTITY copy "&#169;" >
   <!ENTITY amp "&#38;" >
]>
   
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl">

<!--
<xsl:output method='xml' version='1.0' encoding='UTF-8' indent='yes'/>
-->
<xsl:output method="html" encoding="utf-8" indent="yes" />

<!--***********************************************-->
<!--***********************************************-->
<!-- Content Header Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="content_header">

	<!--===============================================-->
	<!-- Timer Message -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/timer_message">
		<xsl:call-template name="timer_message"/>
	</xsl:if>

	<!--===============================================-->
	<!-- Error Message -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/error_message">
		<xsl:call-template name="error_message"/>
	</xsl:if>
	
	<!--===============================================-->
	<!-- Warn Message -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/warn_message">
		<xsl:call-template name="warn_message"/>
	</xsl:if>
	
	<!--===============================================-->
	<!-- Action Message -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/action_message">
		<xsl:call-template name="action_message"/>
	</xsl:if>
	
	<!--===============================================-->
	<!-- General Message -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/gen_message">
		<xsl:call-template name="gen_message"/>
	</xsl:if>

	<!--===============================================-->
	<!-- Content Header -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/content_header">
		<div id="content_header">
			<xsl:value-of select="//page/application_data/content_header" disable-output-escaping="yes"/>
		</div>
	</xsl:if>

	<!--===============================================-->
	<!-- Back Link -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/back_link">
		<div id="back-btn" class="center">
			<a class="btn btn-warning hidden-desktop hidden-tablet">
				<xsl:attribute name="href">
					<xsl:value-of select="//page/application_data/back_link" disable-output-escaping="yes" />
				</xsl:attribute>
				Go Back
			</a>
		</div>
	</xsl:if>

</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Main Content Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="mainContent">

    <xsl:if test="content">

    	<!--===============================================-->
		<!-- Breadcrumbs -->
    	<!--===============================================-->
    	<!--
		<xsl:call-template name="breadcrumbs">
			<xsl:with-param name="base" select="//page/application_data/breadcrumbs" />
			<xsl:with-param name="id" select="'module_path_breadcrumbs'" />
		</xsl:call-template>
		-->

    	<!--===============================================-->
		<!-- Current Path Breadcrumbs -->
    	<!--===============================================-->
		<xsl:call-template name="breadcrumbs">
			<xsl:with-param name="base" select="//page/application_data/current_path" />
			<xsl:with-param name="id" select="'current_path_breadcrumbs'" />
			<xsl:with-param name="separator" select="'/'" />
		</xsl:call-template>

    	<!--===============================================-->
		<!-- Page Message -->
    	<!--===============================================-->
		<xsl:if test="//page/application_data/page_message">
			<xsl:call-template name="page_message"/>
		</xsl:if>
		
    	<!--===============================================-->
		<!-- Top Mod Links -->
    	<!--===============================================-->
		<xsl:if test="//page/application_data/top_mod_links">
			<xsl:call-template name="top_mod_links"/>
		</xsl:if>

    	<!--===============================================-->
		<!-- Content Data -->
    	<!--===============================================-->
		<xsl:if test="//page/content/content_data">
        	<div id="content_data">
            	<xsl:value-of select="//page/content/content_data" disable-output-escaping="yes" />
        	</div>
    	</xsl:if>

    </xsl:if>

</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Content Footer Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="content_footer">

	<!--===============================================-->
	<!-- Bottom Message -->
	<!--===============================================-->
	<xsl:if test="//page/application_data/bottom_message">
		<xsl:call-template name="bottom_message"/>
	</xsl:if>

</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Timer Message Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="timer_message">
	<div class="alert alert-success top">
		<xsl:call-template name="output_messages">
			<xsl:with-param name="base" select="//page/application_data/timer_message" />
			<xsl:with-param name="base_messages" select="//page/application_data/timer_message/messages" />
			<xsl:with-param name="img_src" select="string('/img/icons/clock.png')" />
			<xsl:with-param name="img_alt" select="string('[->]')" />
		</xsl:call-template>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Error Message Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="error_message">
	<div class="alert alert-error top">
		<xsl:call-template name="output_messages">
			<xsl:with-param name="base" select="//page/application_data/error_message" />
			<xsl:with-param name="base_messages" select="//page/application_data/error_message/messages" />
			<xsl:with-param name="img_src" select="string('/img/icons/exclamation.png')" />
			<xsl:with-param name="img_alt" select="string('[!!!]')" />
		</xsl:call-template>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Warning Message Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="warn_message">
	<div class="alert top">
		<xsl:call-template name="output_messages">
			<xsl:with-param name="base" select="//page/application_data/warn_message" />
			<xsl:with-param name="base_messages" select="//page/application_data/warn_message/messages" />
			<xsl:with-param name="img_src" select="string('/img/icons/error.png')" />
			<xsl:with-param name="img_alt" select="string('[!]')" />
		</xsl:call-template>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Action Message Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="action_message">
	<div class="alert alert-success top">
		<xsl:call-template name="output_messages">
			<xsl:with-param name="base" select="//page/application_data/action_message" />
			<xsl:with-param name="base_messages" select="//page/application_data/action_message/messages" />
			<xsl:with-param name="img_src" select="string('/img/icons/tick.png')" />
			<xsl:with-param name="img_alt" select="string('[*]')" />
		</xsl:call-template>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- General Message Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="gen_message">
	<div class="alert alert-info top">
		<xsl:call-template name="output_messages">
			<xsl:with-param name="base" select="//page/application_data/gen_message" />
			<xsl:with-param name="base_messages" select="//page/application_data/gen_message/messages" />
			<xsl:with-param name="img_src" select="string('/img/icons/information.png')" />
			<xsl:with-param name="img_alt" select="string('[->]')" />
		</xsl:call-template>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Page Message Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="page_message">
	<div class="alert alert-info">
		<xsl:call-template name="output_messages">
			<xsl:with-param name="base" select="//page/application_data/page_message" />
			<xsl:with-param name="base_messages" select="//page/application_data/page_message/messages" />
			<xsl:with-param name="img_src" select="string('/img/icons/information.png')" />
			<xsl:with-param name="img_alt" select="string('[->]')" />
		</xsl:call-template>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Bottom Message Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="bottom_message">
	<div class="alert alert-info">
		<xsl:call-template name="output_messages">
			<xsl:with-param name="base" select="//page/application_data/bottom_message" />
			<xsl:with-param name="base_messages" select="//page/application_data/bottom_message/messages" />
			<xsl:with-param name="img_src" select="string('/img/icons/information.png')" />
			<xsl:with-param name="img_alt" select="string('[->]')" />
		</xsl:call-template>
	</div>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Output Messages Template -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="output_messages">
	<xsl:param name="base" />
	<xsl:param name="base_messages" />
	<xsl:param name="img_src" />
	<xsl:param name="img_alt" />
	
	<xsl:for-each select="$base_messages/*">
		<div class="text_block">
			<img src="/img/icons/action.png" alt="[*] " class="gen_icon">
				<xsl:attribute name="src"><xsl:value-of select="concat(//page/html_path, $img_src)" /></xsl:attribute>
				<xsl:attribute name="alt"><xsl:value-of select="$img_alt" /></xsl:attribute>
			</img>
			<xsl:value-of select="string('&amp;nbsp;')" disable-output-escaping="yes" />
        	<xsl:value-of select="." disable-output-escaping="yes" />
		</div>
	</xsl:for-each>
</xsl:template>

<!--***********************************************-->
<!--***********************************************-->
<!-- Top Links -->
<!--***********************************************-->
<!--***********************************************-->
<xsl:template name="top_mod_links">
	<div class="top_mod_links">
		<xsl:for-each select="//page/application_data/top_mod_links">
			<ul>
				<xsl:for-each select="./links/*">
					<li>
						
						<a class="btn">
							<xsl:if test="./class">
								<xsl:attribute name="class"><xsl:value-of select="./class"/></xsl:attribute>
							</xsl:if>
							<xsl:attribute name="href"><xsl:value-of select="./link"/></xsl:attribute>
							<xsl:if test="./image"><xsl:value-of select="./image" disable-output-escaping="yes" /></xsl:if>
							<xsl:value-of select="./desc" disable-output-escaping="yes"/>
						</a>
					</li>
				</xsl:for-each>
			</ul>
		</xsl:for-each>
	</div>
</xsl:template>


</xsl:stylesheet>
