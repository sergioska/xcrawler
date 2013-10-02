<?xml version="1.0" encoding="UTF-8" ?>
<!--
    Created by Sergio Sicari
    Copyright (c) 2013 . All rights reserved.
-->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:php="http://php.net/xsl"
                xmlns:dyn="http://exslt.org/dynamic"
                extension-element-prefixes="dyn"
                exclude-result-prefixes="php">
    <xsl:output encoding="utf-8" indent="yes" method="xml" />
    
    <xsl:template match="/">
      <annunci>
     	<xsl:apply-templates />
      </annunci>
    </xsl:template>
    
    <xsl:template match="body">
        <result>
            <xsl:text>true</xsl:text>
        </result>
    </xsl:template>
    

    <xsl:template match="text()" priority="-1" />
    
</xsl:stylesheet>