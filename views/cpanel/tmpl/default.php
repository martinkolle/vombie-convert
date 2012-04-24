<?php

defined('_JEXEC') or die('Restricted access');

$version = "0.1 Beta";

?>
<style>
/* standard form style table */
table.cpanel_about {
	background-color: #F7F8F9;
	border: solid 1px #d5d5d5;
	width: 100%;
	padding: 10px;
	border-collapse: collapse;
}
table.cpanel_about tr.row0 {
	background-color: #F7F8F9;
}
table.cpanel_about tr.row1 {
	background-color: #eeeeee;
}
table.cpanel_about th {
	font-size: 20px;
	font-weight:normal;
	font-variant:small-caps;
	padding-top: 6px;
	padding-bottom: 2px;
	padding-left: 4px;
	padding-right: 4px;
	text-align: left;
	height: 25px;
	color: #666666;
	background: url(../images/background.gif);
	background-repeat: repeat;
}
table.cpanel_about td {
	padding: 3px;
	text-align: left;
	border: 1px;
	border-style:solid;
	border-bottom-color:#EFEFEF;
	border-right-color:#EFEFEF;
	border-left-color:#EFEFEF;
	border-top-color:#EFEFEF;
}

table.cpanel_icon {
	background-color: #F7F8F9;
	border: solid 1px #d5d5d5;
	width: 100%;
	padding: 5px;
}
table.cpanel_icon td {
	padding: 5px;
	text-align: center;
	border: 1x;
	border-style: solid;
	border-bottom-color:#EFEFEF;
	border-right-color:#EFEFEF;
	border-left-color:#EFEFEF;
	border-top-color:#EFEFEF;
}
.cpanel_icon td:hover {
	background-color: #B5CDE8;
	border:	1px solid #30559C;
}
</style>
<table class="cpanel_about">
<tr class="cpanel_about">
	<td width="50%" valign="top" class="cpanel_about">
    <table width="100%" class="cpanel_icon">
    <tr class="cpanel_icon">
        <td align="center" height="100px" width="33%" class="cpanel_icon">
        	<a href="index.php?option=com_jconverter&amp;view=migrate" style="text-decoration:none;" onClick="confirm('Please wait. This process can take time depending on size of your WordPress database.');">
            	<img src="templates/bluestork/images/header/icon-48-install.png" align="middle" border="0" />
            	<br />
            	<?php echo JText::_( "Start Conversion!") ;?>
        </td>
    	</a>
		</tr>
	 </table>
      </td>
      <td width="30%" valign="top" align="center">
      <table border="1" width="100%" class="cpanel_about">
         <tr class="cpanel_about">
            <th class="cpanel" colspan="2">Vombie Convert - Wordpress users to Joomla</th></td>
         </tr>
      </td>
         <tr class="cpanel_about">
            <td width="120" bgcolor="#FFFFFF">Installed version:</td>
            <td bgcolor="#FFFFFF"><?php echo $version;?></td>
         </tr>
         <tr class="cpanel_about">
            <td bgcolor="#FFFFFF">Copyright:</td>
            <td bgcolor="#FFFFFF">&copy; 2012 <a href="http://martiinkolle.dk">http://martiinkolle.dk</a></td>
         </tr>
         <tr class="cpanel_about">
            <td bgcolor="#FFFFFF">License:</td>
            <td bgcolor="#FFFFFF"><a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU/GPL v.3</a></td>
         </tr>
      </table>
      </td>
   </tr>
</table>
