<?php 
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: edit_icalevent.edit_page.php 2091 2011-05-16 09:12:40Z geraintedwards $
 * @package     JEvents
 * @copyright   Copyright (C)  2008-2009 GWE Systems Ltd
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */

defined('_JEXEC') or die('Restricted access');

// Disable for now

?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><?php echo JText::_("JEV_PLUGIN_INSTRUCTIONS",true);?></td>
		<td><select id="jevdefaults" onchange="defaultsEditorPlugin.insert('value','jevdefaults' )" ></select></td>
	</tr>
</table>

<script type="text/javascript">
defaultsEditorPlugin.node($('jevdefaults'),"<?php echo JText::_("JEV_PLUGIN_SELECT",true);?>","");
// built in group
var optgroup = defaultsEditorPlugin.optgroup($('jevdefaults') , "<?php echo JText::_("JEV_CORE_DATA",true);?>");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_TAB_START",true);?>", "TABSTART#name");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_END_TABS",true);?>", "TABSEND");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_MESSAGE",true);?>", "MESSAGE");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_TITLE",true);?>", "TITLE");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_TITLE_LABEL",true);?>", "TITLE_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_CREATOR",true);?>", "CREATOR");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_CREATOR_LABEL",true);?>", "CREATOR_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_CATEGORY",true);?>", "CATEGORY");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_CATEGORY_LABEL",true);?>", "CATEGORY_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_ICAL",true);?>", "ICAL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_ICAL_LABEL",true);?>", "ICAL_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_ACCESS",true);?>", "ACCESS");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_ACCESS_LABEL",true);?>", "ACCESS_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_DESCRIPTION",true);?>", "DESCRIPTION");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_DESCRIPTION_LABEL",true);?>", "DESCRIPTION_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_LOCATION",true);?>", "LOCATION");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_LOCATION_LABEL",true);?>", "LOCATION_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_CONTACT",true);?>", "CONTACT");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_CONTACT_LABEL",true);?>", "CONTACT_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_EXTRAINFO",true);?>", "EXTRAINFO");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_EXTRAINFO_LABEL",true);?>", "EXTRAINFO_LBL");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_CUSTOMFIELDS",true);?>", "CUSTOMFIELDS");
defaultsEditorPlugin.node(optgroup , "<?php echo JText::_("JEV_FIELD_CALTAB",true);?>", "CALTAB");
//
Joomla.submitbutton = function (pressbutton){

    if(pressbutton == "defaults.apply" || pressbutton == "defaults.save")
    {
        <?php $editor =  JFactory::getEditor("none");?>
                    
       <?php 
       $requiredfields = "'CALTAB','TITLE','CATEGORY','ICAL','MESSAGE'";
       if(!empty($this->requiredfields))
       {
                $requiredfields .= ",".$this->requiredfields;
       }
       ?>
        var requiredFields = [<?php echo $requiredfields; ?>];
        var defaultsLayout = <?php echo $editor->getContent('value'); ?>;
        if(defaultsLayout == '')
        {
                if( !confirm ('<?php echo JText::_("JEV_LAYOUT_DEFAULTS_EMPTY_ALERT",true);?>'))
                {                                      
                    return;
                }
                else
                {
                    submitform(pressbutton);
                }
        }
        else
        {
                var missingFields = [];
                //We check tabs closing if necessary:
                var tabStart =  "\{\{.*:TABSTART#.*\}\}";
                var tabsEnd =  "\{\{.*:TABSEND.*\}\}";
                if (defaultsLayout.test(tabStart) && !defaultsLayout.test(tabsEnd))
                {
                    missingFields.push('TABSEND');
                }
                requiredFields.each(function(requiredField, index){
                    var requiredFieldRE = "\{\{.*:"+requiredField+"\}\}";                    
                    if(!defaultsLayout.test(requiredFieldRE))
                    {
			 var options = Array.from($('jevdefaults').options);
			 options.each (function(opt){
				 if ((opt.value+"}}").contains(":"+requiredField+"}}")){
					 missingFields.push(opt.value);
				 }
			 })
                            
                    }
                });
                    if (missingFields.length >0){
			var message = '<?php echo JText::_("JEV_LAYOUT_MISSING_FIELD",true);?>'+'\n';
			missingFields.each (function (msg, index){
				message +=  msg +'\n';
			});
			alert(message);
                    }
                    else
                    {
                        submitform(pressbutton);
                    }
        }
        
    }
    else
    {
        submitform(pressbutton);
    }
}
<?php
// get list of enabled plugins
$jevplugins = JPluginHelper::getPlugin("jevents");
foreach ($jevplugins as $jevplugin){
	if (JPluginHelper::importPlugin("jevents", $jevplugin->name)){
		// At present ony customfields and rsvp pro support secondary tabs and special input formats
		if (!in_array($jevplugin->name, array("jevcustomfields", "jevrsvppro", "jevpeople" , "agendaminutes", "jevfiles", "jevcck", "jevusers", "jevtags", "jevmetatags", "jevanonuser"))){
			continue;
		}
		$classname = "plgJevents".ucfirst($jevplugin->name);
		if (is_callable(array($classname,"fieldNameArray"))){
			$lang = JFactory::getLanguage();
			$lang->load("plg_jevents_".$jevplugin->name,JPATH_ADMINISTRATOR);
			$fieldNameArray = call_user_func(array($classname,"fieldNameArray"), "edit");
			if (!isset($fieldNameArray['labels'])) continue;
			?>
			optgroup = defaultsEditorPlugin.optgroup($('jevdefaults') , '<?php echo $fieldNameArray["group"];?>');
			<?php
			for ($i=0;$i<count($fieldNameArray['labels']);$i++) {
				if ($fieldNameArray['labels'][$i]=="" || $fieldNameArray['labels'][$i]==" Label")  continue;
				?>
				defaultsEditorPlugin.node(optgroup , "<?php echo $fieldNameArray['labels'][$i];?>", "<?php echo $fieldNameArray['values'][$i];?>");
				<?php
			}
		}
	}
}
?>
</script>
