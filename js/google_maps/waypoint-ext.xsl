<?xml version="1.0" encoding="utf-8" ?>
<!-- arch-tag: 752d7fe0-4c26-4b2a-b2ea-00d4e207c722
     (do not change this comment) -->
<!--
    Stylesheet to extract XHTML content from the
    extensions element of a GPX wpt.
-->
<xsl:stylesheet version="1.0"
  xmlns:gpx="http://www.topografix.com/GPX/1/1"
  xmlns:xh="http://www.w3.org/1999/xhtml"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  exclude-result-prefixes="gpx xh">
  <xsl:output method="html" indent="yes"/>

  <xsl:template match="/">
    <xsl:apply-templates select="//gpx:wpt"/>
  </xsl:template>

  <xsl:template match="gpx:wpt">
    <div class="info">
      <div class="wptitle">
	<xsl:value-of select="./gpx:desc"/>
      </div>
      <xsl:apply-templates select="./gpx:extensions"/>
    </div>
  </xsl:template>

  <xsl:template match="gpx:extensions">
    <xsl:apply-templates/>
  </xsl:template>

  <xsl:template match="*">
    <xsl:element name="{local-name()}">
      <xsl:copy-of select="@*"/>
      <xsl:apply-templates/>
    </xsl:element>
  </xsl:template>

</xsl:stylesheet>
