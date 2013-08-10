<?xml version="1.0" encoding="ISO-8859-1"?>

<!DOCTYPE xsl:stylesheet [ 
   <!ENTITY nbsp "&#160;" >
   <!ENTITY bull "&#149;" >
   <!ENTITY copy "&#169;" >
   <!ENTITY amp "&#38;" >
]>
   
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!--
<xsl:output method="xml" omit-xml-declaration="yes" 
doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" 
doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" indent="yes"/>
-->
<xsl:output method="html" encoding="utf-8" indent="yes" />

<!--******************************************************************************-->
<!-- Login Template -->
<!--******************************************************************************-->
<xsl:template name="login">
	<xsl:param name="hide_form_header" />

	<form class="form-signin" action="/" method="post">
		<xsl:if test="$hide_form_header != 1">
			<h3 class="form-signin-heading">Please sign in</h3>
		</xsl:if>
		<input type="text" class="input-block-level" placeholder="User ID" name="user" autocapitalize="off"/>
		<input type="password" class="input-block-level" placeholder="Password" name="pass" />
<!--
		<label class="checkbox">
			<input type="checkbox" value="remember-me" /> Remember me
		</label>
-->
		<button class="btn btn-large btn-primary" type="submit">Sign in</button>
	</form>

</xsl:template>

<!--******************************************************************************-->
<!-- Message Template -->
<!--******************************************************************************-->
<xsl:template name="message">
    <xsl:param name="msg_code" select="'default-value'"/>
    <xsl:variable name="msg_base" select="//page/message/message_list/msg[@code=$msg_code]" />

    <div>

    	<xsl:attribute name="class">
    		<xsl:value-of select="'message_block alert'" disable-output-escaping="yes" />
	    	<xsl:choose>
	    		<xsl:when test="$msg_base[@type='success']">
	    			<xsl:value-of select="string(' alert-success')" disable-output-escaping="yes" />    		
	    		</xsl:when>
	    		<xsl:when test="$msg_base[@type='error']">
	    			<xsl:value-of select="string(' alert-error')" disable-output-escaping="yes" />    		
	    		</xsl:when>
	    		<xsl:otherwise>
	    			<xsl:value-of select="string(' alert-block')" disable-output-escaping="yes" />    		
	    		</xsl:otherwise>
	    	</xsl:choose>
    	</xsl:attribute>

	    <xsl:if test="//page/message/message_list/msg[@code=$msg_code]">

            <xsl:for-each select="$msg_base/text">
                <div class="message"><xsl:value-of select="." disable-output-escaping="yes"/></div>
            </xsl:for-each>

            <xsl:if test="$msg_base/login_desc">
	            <img alt="Message" title="Message" class="gen_icon">
					<xsl:attribute name="src">
						<xsl:value-of select="concat(//page/html_path, '/img/icons/information.png')" disable-output-escaping="yes" />
					</xsl:attribute>
				</img>
                <a>
                    <xsl:attribute name="href"><xsl:value-of select="//page/message/login_link"/></xsl:attribute>
                    <xsl:value-of select="$msg_base/login_desc" disable-output-escaping="yes" />    
                </a>
            </xsl:if>

            <xsl:if test="$msg_base/back_desc">
                <a>
                    <xsl:attribute name="href"><xsl:value-of select="//page/message/back_link"/></xsl:attribute>
                    <xsl:value-of select="$msg_base/back_desc" disable-output-escaping="yes" />    
                </a>
            </xsl:if>

        </xsl:if>

    </div>

    <xsl:if test="$msg_base/@show_login">
    	<xsl:call-template name="login">
    		<xsl:with-param name="hide_form_header" select="1" />
    	</xsl:call-template>
    </xsl:if>

</xsl:template>

</xsl:stylesheet>
