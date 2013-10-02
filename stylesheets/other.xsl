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
      <xsl:variable name="org" select='div[@class="container-out listing"]/div[@class="container-skin"]/div[@class="container"]/div[@class="content list-main"]/div[@class="list-left"]/div'  />
      <xsl:for-each select='$org/div[@class="container-prio"]/div[@class="prio"]/div'> 
      <azienda>
        <xsl:variable name="name" select='normalize-space(div[@class="item_sx"]/div[@class="item_head"]/div[@class="org fn"]/h2/a/text())' />
        <xsl:variable name="address" select='normalize-space(div[@class="item_sx"]/div[@class="address"]/span[@class="street-address"]/text())' />
        <xsl:if test="string-length($name)">
          <nome><xsl:value-of select='$name' /></nome>
        </xsl:if>
        <xsl:if test="string-length($address)">
          <address><xsl:value-of select='$address' /></address>
        </xsl:if>
      </azienda>
      </xsl:for-each>
      
      <xsl:for-each select='$org'> 
      <azienda>
        <xsl:variable name="name" select='normalize-space(div[@class="item clearfix contextual contextuallight"]/div[@class="item_sx vcard"]/div[@class="item_head"]/div[@class="org fn"]/h2/a/text())' />
        <xsl:if test="string-length($name)">
          <nome><xsl:value-of select='$name' /></nome>
        </xsl:if>
      </azienda>
      </xsl:for-each>

      <xsl:for-each select='$org/div[@class="item clearfix"]'> 
      <azienda>
        <xsl:variable name="name" select='normalize-space(div[@class="item_sx"]/div[@class="item_head"]/div[@class="org fn"]/h2/a/text())' />
        <xsl:if test="string-length($name)">
          <nome><xsl:value-of select='$name' /></nome>
        </xsl:if>
      </azienda>
      </xsl:for-each>
    </xsl:template>

    <xsl:template match="text()" priority="-1" />

</xsl:stylesheet>