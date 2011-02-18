<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>TriCoreTraining.com</title>
   <style type="text/css" media="screen">

      body {

         background-color: #e6e6e6;
         margin: 0;
         padding: 0;
         font-size: 12px;
         
         font-family: Arial, 'Helvetica Neue', 'Liberation Sans', FreeSans, sans-serif;
      }

      ol {
         color: #333333;
         font-size: 12px;
         font-family: Arial, 'Helvetica Neue', 'Liberation Sans', FreeSans, sans-serif;
      }
      
      ul {
         color: #333333;
         font-size: 12px;
         font-family: Arial, 'Helvetica Neue', 'Liberation Sans', FreeSans, sans-serif;
      }

      a {
         font-size: 12px;
         font-weight: normal;
         color: #6cb9ce;
      }

      a img {
         border: none;
      }

      table.main {
         background-color: #ffffff;
         font-family: Arial, 'Helvetica Neue', 'Liberation Sans', FreeSans, sans-serif;
         font-size: 12px;
      }

      th {
         border: 1px; border-style: solid;
      }

      td.permission {
         padding: 10px 0 10px 0;
      }

      td.permission p {
         font-size: 11px;
         font-weight: normal;
         color: #333333;
         margin: 0;
         padding: 0;
      }

      td.permission p a {
         font-size: 11px;
         font-weight: normal;
         color: #333333;
      }

      td.date {
         padding: 8px 0 8px 0;
      }

      td.date p {
         font-size: 12px;
         font-weight: normal;
         color: #666666;
         margin: 0;
         padding: 0;
      }

      td.header {
         background-color: #FFAE00; /**#4babc5;**/
         padding: 0 0 2px 0;
      }

      td.header h1 {
         font-size: 35px;
         font-weight: bold;
         color: #ffffff;
         margin: 0 0 0 10px;
         padding: 0;
         display: inline;
      }

      td.sidebar ul {
         font-size: 12px;
         font-weight: normal;
         color: #FFAE00;
         margin: 10px 0 10px 24px;
         padding: 0;
      }

      td.sidebar ul li a {
         font-size: 12px;
         font-weight: normal;
         color: #FFAE00;
         text-decoration: none;
      }

      td.sidebar p {
         font-size: 12px;
         font-weight: normal;
         color: #4c4c4c;
         margin: 10px 0 0 0;
         padding: 0;
      }

      td.sidebar p a {
         font-size: 12px;
         font-weight: normal;
         color: #6cb9ce;
      }

      td.mainbar h2 {
         background-color: #FFAE00; /**#4babc5;**/
         font-size: 18px;
         font-weight: bold;
         color: #ffffff;
         margin: 0;
         padding: 0;
      }

      td.mainbar h2 a {
         font-size: 18px;
         font-weight: bold;
         color: #ffffff;
         text-decoration: none;
      }

      td.sideHeader h3 {
         background-color: #FFAE00; /**#4babc5;**/
         font-size: 18px;
         font-weight: bold;
         color: #ffffff;
         margin: 0;
         padding: 0;
      }

      td.sidebar h4 {
         font-size: 13px;
         font-weight: bold;
         color: #333333;
         margin: 14px 0 0 0;
         padding: 0;
      }

      td.mainbar p {
         font-size: 12px;
         font-weight: normal;
         color: #4c4c4c;
         margin: 10px 0 0 0;
         padding: 0;
      }

      td.mainbar p a {
         font-size: 12px;
         font-weight: normal;
         color: #6cb9ce;
      }

      td.mainbar p img {
         border-bottom: 4px solid #edc913;
      }

      td.mainbar p.more {
         padding: 0 0 10px 0;
      }

      td.mainbar ul {
         font-size: 12px;
         font-weight: normal;
         color: #4c4c4c;
         margin: 10px 0 10px 0;
         padding: 0;
         list-style-position: inside;
      }

      td.footer {
         padding: 10px 0 10px 0;
      }

      td.footer p {
         font-size: 11px;
         font-weight: normal;
         color: #333333;
         margin: 0;
         padding: 0;
      }

      td.footer p a {
         font-size: 11px;
         font-weight: normal;
         color: #6cb9ce;
      }

      /**
       * Tables
       */
      
      td.tab, th.tab {
        padding: 7px;
      }
      
      tr.tab:nth-child(odd) { 
        background: -webkit-gradient(
            linear,
            left bottom,
            left top,
            color-stop(0, #efefef),
            color-stop(1, rgb(255,255,255))
        );
        background: -moz-linear-gradient(
            center bottom,
            #efefef 0%,
            rgb(255,255,255) 100%
        );
      }
      
      tr.tab {
        border-bottom: 1px dotted #ccc;
      }
      
      th.tab {
        padding: 10px 7px;
        border: 1px solid #ccc;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        background: -webkit-gradient(
            linear,
            left bottom,
            left top,
            color-stop(0, #efefef),
            color-stop(1, rgb(255,255,255))
        );
        background: -moz-linear-gradient(
            center bottom,
            #efefef 0%,
            rgb(255,255,255) 100%
        );
        
        text-shadow: 1px 1px 1px white;
      }
      
      td.nobg {
        background: white;
      }

   </style>

</head>
<body>

<table width="100%" cellspacing="10" cellpadding="0">
   <tr>
      <td align="center" valign="top">

         <table width="580" border="0" cellspacing="0" cellpadding="0" class="main">
<!--
            <tr>
               <td align="center" class="permission">
                  <p><?php __("You're receiving this notification because you are registered at TriCoreTraining.com."); ?></p>
               </td>
            </tr>
-->
            <tr>
               <td height="90" valign="bottom" align="left" class="header">
                  <img src="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/img/header.gif" width="580" height="90" alt="TriCoreTraining.com" />
               </td>
            </tr>
            <tr>
               <td align="center">

                  <table width="550" cellspacing="0" cellpadding="0">
                     <tr>
                        <td width="192"></td>
                        <td></td>
                        <td class="date"><p><?php date('YYYY-mm-dd', time()); ?></p></td>
                     </tr>
                     <tr align="left" rowspan="3" valign="top">

                        <td width="330" valign="top" class="mainbar" align="left">