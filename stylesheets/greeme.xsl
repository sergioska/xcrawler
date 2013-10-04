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
            <xsl:variable name="activities" select='div[@class="sp-wrap main-bg clearfix"]/div[@class="clearfix"]/div[@id="sp-maincol"]/div[@id="inner_content"]/div[@class="sp-component-area clearfix"]/div[@class="sp-inner clearfix"]/div[@class="sp-component-area-inner clearfix"]/div[@id="category"]/div[@id="listings"]' />
            <xsl:for-each select='$activities/div[@class="listing-summary"]'>
                <name>
                    <xsl:value-of select='./div[@class="header"]/h3/a/span/text()' />
                </name>
                <address>
                    <xsl:value-of select='./p[@class="address"]/text()' />
                    <xsl:value-of select='./p[@class="address"]/a/text()' />
                </address>
                <site>
                    <xsl:value-of select='./p[@class="website"]/a/text()' />
                </site>
                <category>
                    <xsl:value-of select='./p[3]/text()' />
                </category>
                <tel>
                    <xsl:value-of select='./div[@class="fields"]/div[@class="row0"]/div[@id="field_9"]/span[@class="output"]/a/text()' />
                </tel>
                <fax>
                    <xsl:value-of select='./div[@class="fields"]/div[@class="row0"]/div[@id="field_10"]/span[@class="output"]/text()' />
                </fax>
                <email>
                    <xsl:value-of select='./div[@class="fields"]/div[@class="row0"]/div[@id="field_11"]/span[@class="output"]/a/text()' />
                </email>
            </xsl:for-each>
        </result>
    </xsl:template>
    

    <xsl:template match="text()" priority="-1" />
    
</xsl:stylesheet>