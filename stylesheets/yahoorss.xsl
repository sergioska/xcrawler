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
      <news>
     	  <xsl:apply-templates />
      </news>
    </xsl:template>
    
    <xsl:template match="rss">
      <xsl:variable name="chunk" select='channel/item'  />
      <xsl:for-each select='$chunk'>
        <adv>
            <title>
                <xsl:value-of select="title/text()" />
            </title>
            <guid>
                <xsl:value-of select="guid/text()" />
            </guid>
        </adv>
      </xsl:for-each>

    </xsl:template>

    <xsl:template match="text()" priority="-1" />

</xsl:stylesheet>