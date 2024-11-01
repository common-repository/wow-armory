<?php
/* 
Plugin Name: WoW Armory 
Plugin URI: http://timsworld.nfshost.com/wordpress-plugins/wow-armory-wp-plugin/ 
Description: Shows your character's Armory info  
Version: 8.4.3
Author: Tim (SeiferTim) Hely
Author URI: http://timsworld.nfshost.com
*/ 

class WoWArmory extends WP_Widget {
	var $plugin_folder = '';
	public static $armoryPathUS = "http://www.wowarmory.com/_images";
	public static $armoryPathEU = "http://eu.wowarmory.com/images";
	public static $modelNames = array(
		1 => array(
				0 => 'humanmale',
				1 => 'humanfemale',
			),
		2 => array(
				0 => 'orcmale',
				1 => 'orcfemale',
			),
		3 => array(
				0 => 'dwarfmale',
				1 => 'dwarffemale',
			),
		4 => array(
				0 => 'nightelfmale',
				1 => 'nightelffemale',
			),
		5 => array(
				0 => 'scourgemale',
				1 => 'scourgefemale',
			),
		6 => array(
				0 => 'taurenmale',
				1 => 'taurenfemale',
			),
		7 => array(
				0 => 'gnomemale',
				1 => 'gnomefemale',
			),
		8 => array(
				0 => 'trollmale',
				1 => 'trollfemale',
			),
		10 => array(
				0 => 'bloodelfmale',
				1 => 'bloodelffemale',
			),
		11 => array(
				0 => 'draeneimale',
				1 => 'draeneifemale',
			),
	);
	/* -------------------- */
    
	/* --- Option Counts -- */
		
		var  $opts = array(
			// Human Male
			1 => array(
				0 => array(
					'ha' => 23,
					'hc' => 12,
					'fa' => 29,
					'sk' => 14,
					'fh' => 6,
					'fc' => 12,
				),
				// Human Female
				1 => array (
					 'ha' => 16,
					 'hc' => 12,
					 'fa' => 23,
					 'sk' => 14,
					 'fh' => 8,
					 'fc' => 12,
				),
			),
		
			
			2 => array(
				//Orc Male
				0 => array(
					'ha' => 12,
					'hc' => 10,
					'fa' => 17,
					'sk' => 13,
					'fh' => 6,
					'fc' => 10,
				),
				// Orc Female
				1 => array (
					 'ha' => 11,
					'hc' => 10,
					'fa' => 17,
					'sk' => 17,
					'fh' => 10,
					'fc' => 10,
				),
			),
			
			3 => array(
				//Dwarf Male
				0 => array(
					'ha' => 18,
					'hc' => 12,
					'fa' => 19,
					'sk' => 13,
					'fh' => 5,
					'fc' => 12,
				),
				// Dwarf Female
				1 => array (
					'ha' => 15,
					'hc' => 12,
					'fa' => 19,
					'sk' => 21,
					'fh' => 10,
					'fc' => 12,
				),
			),
			
			4 => array(
				// Night Elf Male
				0 => array(
					'ha' => 11,
					'hc' => 9,
					'fa' => 17,
					'sk' => 11,
					'fh' => 9,
					'fc' => 10,
				),
				// Night Elf Female
				1 => array (
					'ha' => 11,
					'hc' => 9,
					'fa' => 17,
					'sk' => 11,
					'fh' => 5,
					'fc' => 10,
				),
			),
			
			5 => array(
				//Forsaken Male
				0 => array(
					'ha' => 14,
					'hc' => 9,
					'fa' => 19,
					'sk' => 5,
					'fh' => 7,
					'fc' => 9,
				),
				// Forsaken Female
				1 => array (
					'ha' => 14,
					'hc' => 9,
					'fa' => 19,
					'sk' => 5,
					'fh' => 16,
					'fc' => 9,
				),
			),
			
			6 => array(
				//Tauren Male
				0 => array(
					'ha' => 11,
					'hc' => 2,
					'fa' => 7,
					'sk' => 13,
					'fh' => 4,
					'fc' => 2,
				),
				// Tauren Female
				1 => array (
					'ha' => 12,
					'hc' => 2,
					'fa' => 9,
					'sk' => 21,
					'fh' => 6,
					'fc' => 2,
				),
			),
			
			7 => array(
				// Gnome Male
				0 => array(
					'ha' => 11,
					'hc' => 11,
					'fa' => 13,
					'sk' => 9,
					'fh' => 6,
					'fc' => 11,
				),
				// Gnome Female
				1 => array (
					'ha' => 11,
					'hc' => 11,
					'fa' => 13,
					'sk' => 9,
					'fh' => 7,
					'fc' => 11,
				),
			),
			
			8 => array(
				// Troll Male
				0 => array(
					'ha' => 9,
					'hc' => 12,
					'fa' => 11,
					'sk' => 17,
					'fh' => 5,
					'fc' => 12,	
				),
				// Troll Female
				1 => array (
					'ha' => 9,
					'hc' => 12,
					'fa' => 9,
					'sk' => 17,
					'fh' => 10,
					'fc' => 12,
				),
			),
			
			10 => array(
				//Blood Elf Male
				0 => array(
					'ha' => 19,
					'hc' => 12,
					'fa' => 19,
					'sk' => 18,
					'fh' => 10,
					'fc' => 12,
				),
				// Blood Elf Female
				1 => array (
					'ha' => 15,
					'hc' => 12,
					'fa' => 19,
					'sk' => 18,
					'fh' => 9,
					'fc' => 12,
				),
			),
			
			11 => array(
				//Draenei Male
				0 => array(
					'ha' => 15,
					'hc' => 9,
					'fa' => 19,
					'sk' => 14,
					'fh' => 6,
					'fc' => 9,
				),
				// Draenei Female
				1 => array (
					'ha' => 13,
					'hc' => 9,
					'fa' => 19,
					'sk' => 16,
					'fh' => 7,
					'fc' => 9,
				),
			),
		);
				
    var $default_options = array(
            'cname' => '', 
            'realm' => '',
            'realmType' => '',
            'show_top' => true,
            'show_g' => true,
            'show_p' => true,
            'show_a' => true,
            'lang' => 'en',
            'linkback' => false,
            'talents' => true,
            'show3D' => false,
            'hair' => 0,
            'hairColor' => 0,
            'face' => 0,
            'skinColor' => 0,
            'facialHair' => 0,
            'facialHairColor' => 0,
            'show_apoints' => 1,
            'title' => 'Armory for %NAME%',
            'weapons' => 0,
    );
    
    function WoWArmory() {
			$this->plugin_folder = get_option('siteurl').'/'.PLUGINDIR.'/wow-armory/';
			$widget_ops = array('classname' => 'widget_wow_armory', 'description' => __('Shows any WoW Character\'s Armory Information') );
			$control_ops = array('width' => 500, 'height' => 500);
			wp_enqueue_script('wowhead',"http://static.wowhead.com/widgets/power.js");
			wp_enqueue_style('wow_armory_css', $this->plugin_folder.'css/style.css');
			$this->WP_Widget('wowarmory', __('WoW Armory'), $widget_ops, $control_ops);
		}		
		
		function widget($args, $instance) {
			extract($args);
			$title = str_replace('%NAME%',  $instance['cname'], $instance['title']);
			echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<div class="armory_display">';
			$armory = getArmory($instance);
			echo $armory['content'];
			echo '</div>'.$after_widget;
		}
		
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['cname'] = strip_tags(stripslashes($new_instance['cname']));
			$instance['realm'] = strip_tags(stripslashes($new_instance['realm']));
			$instance['realmType'] = strip_tags(stripslashes($new_instance['realmType']));
			$instance['show_top'] = strip_tags(stripslashes($new_instance['show_top']));
			$instance['show_g'] = strip_tags(stripslashes($new_instance['show_g']));
			$instance['show_p'] = strip_tags(stripslashes($new_instance['show_p']));
			$instance['show_a'] = strip_tags(stripslashes($new_instance['show_a']));
			$instance['lang'] = strip_tags(stripslashes($new_instance['lang']));
			$instance['linkback'] = strip_tags(stripslashes($new_instance['linkback']));
			$instance['talents'] = strip_tags(stripslashes($new_instance['talents']));
			$instance['show3D'] = strip_tags(stripslashes($new_instance['show3D']));
			$instance['hair'] = strip_tags(stripslashes($new_instance['hair']));
			$instance['hairColor'] = strip_tags(stripslashes($new_instance['hairColor']));
			$instance['face'] = strip_tags(stripslashes($new_instance['face']));
			$instance['skinColor'] = strip_tags(stripslashes($new_instance['skinColor']));
			$instance['facialHair'] = strip_tags(stripslashes($new_instance['facialHair']));
			$instance['facialHairColor'] = strip_tags(stripslashes($new_instance['facialHairColor']));
			$instance['show_apoints'] = strip_tags(stripslashes($new_instance['show_apoints']));
			$instance['title'] = strip_tags(stripslashes($new_instance['title']));
			$instance['weapons'] = strip_tags(stripslashes($new_instance['weapons']));
			return $instance;
		}
		
		function form($instance) {
			$instance = wp_parse_args ( (array) $instance, $this->default_options);
			?>
			<div class="wow_armory_options">

	<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:'); ?></label>
	<input type="text" class="wa-title" style="width: 500px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo htmlspecialchars($instance['title']); ?>" /><br/>
	<small>Enter the title for this widget. Use %NAME% for the character's name.</small><br/><br/>

	<label for="<?php echo $this->get_field_id('cname'); ?>"><?php echo __('Character name:'); ?></label>
	<input type="text" class="wa-cname" style="width: 500px;" id="<?php echo $this->get_field_id('cname'); ?>" name="<?php echo $this->get_field_name('cname'); ?>" value="<?php echo htmlspecialchars($instance['cname']); ?>" /><br/>
	<small>Enter the name of the character you wish to display.</small><br/><br/>

	<label for="<?php echo $this->get_field_id('realm'); ?>"><?php echo __('Realm:'); ?></label>
	<select class="wa-realmtype" id="<?php echo $this->get_field_id('realmType'); ?>" name="<?php echo $this->get_field_name('realmType'); ?>" style="display: inline;">
		<option value="US"<?php echo ($instance['realmType'] == 'US' ? ' selected="selected"' : ''); ?>>US</option>
		<option value="EU"<?php echo ($instance['realmType'] == 'EU' ? 'selected="selected"' : ''); ?>>EU</option>
	</select>
	<input type="text" class="wa-realm" style="width:400px;" id="<?php echo $this->get_field_id('realm'); ?>" name="<?php echo $this->get_field_name('realm'); ?>" value="<?php echo htmlspecialchars($instance['realm']); ?>" /><br/>
	<small>Enter the character's realm and realm type.</small><br/><br/>
	
<label for="<?php echo $this->get_field_id('lang'); ?>"><?php echo __('Language:'); ?></label>
<select class="wa-lang" style="width:100px;" id="<?php echo $this->get_field_id('lang'); ?>" name="<?php echo $this->get_field_name('lang'); ?>">
	<option value="en"<?php echo $instance['lang'] == 'en' ? ' selected="selected"' : ''; ?>>English</option>
	<option value="de"<?php echo $instance['lang'] == 'de' ? ' selected="selected"' : ''; ?>>Deutsch</option>
	<option value="es"<?php echo $instance['lang'] == 'es' ? ' selected="selected"' : ''; ?>><?php echo html_entity_decode('Espa&Atilde;&plusmn;ol'); ?></option>
	<option value="fr"<?php echo $instance['lang'] == 'fr' ? ' selected="selected"' : ''; ?>><?php echo html_entity_decode('Fran&Atilde;&sect;ais'); ?></option>
	<option value="ru"<?php echo $instance['lang'] == 'ru' ? ' selected="selected"' : ''; ?>>Pycc<?php echo html_entity_decode('&ETH;&ordm;&ETH;&cedil;&ETH;&sup1;'); ?></option>
</select><br/>
<small>Choose the language you would like to display the item tooltips in.</small><br/><br/>

<h3>Display Options:</h3>

	<input id="<?php echo $this->get_field_id('show_top'); ?>" name="<?php echo $this->get_field_name('show_top'); ?>" value="<?php echo htmlspecialchars($instance['show_top']); ?>" type="checkbox" value="1"<?php echo $instance['show_top'] ? ' checked="checked"' : ''; ?> />
	<label for="<?php echo $this->get_field_id('show_top'); ?>"><?php echo __('Show top'); ?></label><br/>

	<input id="<?php echo $this->get_field_id('talents'); ?>" name="<?php echo $this->get_field_name('talents'); ?>" value="<?php echo htmlspecialchars($instance['talents']); ?>" type="checkbox" value="1"<?php echo $instance['talents'] ? ' checked="checked"' : ''; ?> />
	<label for="<?php echo $this->get_field_id('talents'); ?>"><?php echo __('Show talents'); ?></label><br/>
	
	<input id="<?php echo $this->get_field_id('show_g'); ?>" name="<?php echo $this->get_field_name('show_g'); ?>" value="<?php echo htmlspecialchars($instance['show_g']); ?>" type="checkbox" value="1"<?php echo $instance['show_g'] ? ' checked="checked"' : ''; ?> />
	<label for="<?php echo $this->get_field_id('show_g'); ?>"><?php echo __('Show gear'); ?></label><br/>
	
	<input id="<?php echo $this->get_field_id('show_p'); ?>" name="<?php echo $this->get_field_name('show_p'); ?>" value="<?php echo htmlspecialchars($instance['show_p']); ?>" type="checkbox" value="1"<?php echo $instance['show_p'] ? ' checked="checked"' : ''; ?> />
	<label for="<?php echo $this->get_field_id('show_p'); ?>"><?php echo __('Show professions'); ?></label><br/>
	
	<input id="<?php echo $this->get_field_id('show_a'); ?>" name="<?php echo $this->get_field_name('show_a'); ?>" type="checkbox" value="1"<?php echo $instance['show_a'] ? ' checked="checked"' : ''; ?>/>
	<label for="<?php echo $this->get_field_id('show_a'); ?>"><?php echo __('Show 5 latest achievements'); ?></label><br/><br/>
	
	<label for="<?php echo $this->get_field_id('show_apoints'); ?>"><?php echo __('Show achievement points'); ?></label>
	<select style="width: 150px;" id="<?php echo $this->get_field_id('show_apoints'); ?>" name="<?php echo $this->get_field_name('show_apoints'); ?>">
		<option value="1"<?php echo $instance['show_apoints'] == 1 ? ' selected="selected"' : ''; ?>>Display bars</option>
		<option value="2"<?php echo $instance['show_apoints'] == 2 ? ' selected="selected"' : ''; ?>>Display text only</option>
		<option value="3"<?php echo $instance['show_apoints'] == 3 ? ' selected="selected"' : ''; ?>>Display none</option>
	</select><br/>
	<small>Choose how achievement points should be displayed.</small><br/><br/>
	
	<input id="<?php echo $this->get_field_id('linkback'); ?>" name="<?php echo $this->get_field_name('linkback'); ?>" type="checkbox" value="1"<?php echo $instance['linkback'] ? ' checked="checked"' : ''; ?> />
	<label for="<?php echo $this->get_field_id('linkback'); ?>">Show an optional link back to Tim's World</label><br/>
	<small>If checked a small link back to my site will be shown at the bottom of the widget.</small><br/><br/>
	
	<input class="wa-show3d" id="<?php echo $this->get_field_id('show3D'); ?>" name="<?php echo $this->get_field_name('show3D'); ?>" type="checkbox" value="1"<?php echo $instance['show3D'] ? ' checked="checked"' : ''; ?> />
	<label for="<?php echo $this->get_field_id('show3D'); ?>">Show a 3D Model of the Character</label><br/>
	<small>If checked the widget will display a 3D model of the character.</small><br/><br/>
	
<div class="wa-3DOnly" style="display: <?php echo $instance['show3D'] ? 'inline' : 'none'; ?>; width: 100%;">
	<div style="height: 400px; width: 100%; text-align: center;">
		<?php
			$armory = getArmory(
				array(
				'cname' => stripslashes($instance['cname']) ,
				'realm' => stripslashes($instance['realm']),
				'realmType' => stripslashes($instance['realmType']),
				'show_g' => 0,
				'show_p' => 0,
				'show_a' => 0,
				'lang' => $instance['lang'],
				'linkback' => 0,
				'talents' => 0,
				'show3D' => 1,
				'hair' => $instance['hair'],
				'hairColor' => $instance['hairColor'],
				'face' => $instance['face'],
				'skinColor' => $instance['skinColor'],
				'facialHair' => $instance['facialHair'],
				'facialHairColor' => $instance['facialHairColor'],
				'show_top' => 0,
				'show_apoints' => 0,
				'forceNew' => 1,
				'weapons' => $instance['weapons']
				)
			);
		?>
		<div class="wa-model">
			<?php echo $armory['content']; ?>
		</div>
		<div class="wa-load">
			<img src="<?php echo $this->plugin_folder; ?>/includes/ajax-loader.gif" />
		</div><br/>
		<input type="button" class="button widget-action edit wa-refresh" value="Refresh" />
	</div>
	<?php 
		$thisChar = $this->opts[$armory['raceid']][$armory['genderid']];
		$model = $this->modelNames[$armory['raceid']][$armory['genderid']];
	?><br/><br/>
	<small>Select the styles below for this character's appearance and then click the "Refresh" button to preview your changes.</small>
	<div style="text-align:center;">
		<table style="width: 100%; text-align: center;">
			<tr>
				<td style="text-align:center;">
					<label for="<?php echo $this->get_field_id('hair'); ?>">Hair Style: <?php echo $instance['hair']; ?></label><br/>
					<select class="wa-hair" style="width: 100px;" id="<?php echo $this->get_field_id('hair'); ?>" name="<?php echo $this->get_field_name('hair'); ?>">
						<?php for ($i = 0; $i<=$thisChar['ha'];$i++) { ?> 
							<option value="<?php echo $i; ?>"<?php echo ($instance['hair'] == $i) ? ' selected="selected"' : ''; ?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</td>
				<td style="text-align:center;">
					<label for="<?php echo $this->get_field_id('hairColor'); ?>">Hair Color</label><br/>
					<select class="wa-haircolor" style="width: 100px;" id="<?php echo $this->get_field_id('hairColor'); ?>" name="<?php echo $this->get_field_name('hairColor'); ?>">
						<?php for ($i = 0; $i<=$thisChar['hc'];$i++) { ?> 
							<option value="<?php echo $i; ?>"<?php echo ($instance['hairColor'] == $i) ? ' selected="selected"' : ''; ?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</td>
				<td style="text-align:center;">
					<label for="<?php echo $this->get_field_id('face'); ?>">Face</label><br/>
					<select class="wa-face" style="width: 100px;" id="<?php echo $this->get_field_id('face'); ?>" name="<?php echo $this->get_field_name('face'); ?>">
						<?php for ($i = 0; $i<=$thisChar['fa'];$i++) { ?> 
							<option value="<?php echo $i; ?>"<?php echo ($instance['face'] == $i) ? ' selected="selected"' : ''; ?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;">
					<label for="<?php echo $this->get_field_id('skinColor'); ?>">Skin Color</label><br/>
					<select class="wa-skincolor" style="width: 100px;" id="<?php echo $this->get_field_id('skinColor'); ?>" name="<?php echo $this->get_field_name('skinColor'); ?>">
						<?php for ($i = 0; $i<=$thisChar['sk'];$i++) { ?> 
							<option value="<?php echo $i; ?>"<?php echo ($instance['skinColor'] == $i) ? ' selected="selected"' : ''; ?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</td>
				<td style="text-align:center;">
					<label for="<?php echo $this->get_field_id('facialHair'); ?>">Facial Hair</label><br/>
					<select class="wa-facialhair" style="width: 100px;" id="<?php echo $this->get_field_id('facialHair'); ?>" name="<?php echo $this->get_field_name('facialHair'); ?>">
						<?php for ($i = 0; $i<=$thisChar['fh'];$i++) { ?> 
							<option value="<?php echo $i; ?>"<?php echo ($instance['facialHair'] == $i) ? ' selected="selected"' : ''; ?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</td>
				<td style="text-align:center;">
					<label for="<?php echo $this->get_field_id('facialHairColor'); ?>">Facial Hair Color</label><br/>
					<select class="wa-facialcolor" style="width: 100px;" id="<?php echo $this->get_field_id('facialHairColor'); ?>" name="<?php echo $this->get_field_name('facialHairColor'); ?>">
						<?php for ($i = 0; $i<=$thisChar['fc'];$i++) { ?> 
							<option value="<?php echo $i; ?>"<?php echo ($instance['facialHairColor'] == $i) ? ' selected="selected"' : ''; ?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align:left;">
					<label for="<?php echo $this->get_field_id('weapons'); ?>">Show Weapons</label>
					<select class="wa-weapons" style="width: 150px;" id="<?php echo $this->get_field_id('weapons'); ?>" name="<?php echo $this->get_field_name('weapons'); ?>">
						<option value="0" <?php echo ($instance['weapons'] == 0) ? ' selected="selected"' : ''; ?>>Melee</option>
						<option value="1" <?php echo ($instance['weapons'] == 1) ? ' selected="selected"' : ''; ?>>Ranged</option>
						<option value="2" <?php echo ($instance['weapons'] == 2) ? ' selected="selected"' : ''; ?>>None</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
</div>
</div>
<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/wow-armory/includes/effects.js"></script>
		<?php
	}

}

function WoWArmoryWidgetInit() {
	register_widget('WoWArmory');
}

function WoWArmoryFromShortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'char' => '', 
		'realm' => '',
		'realmtype' => 'US',
		'gear' => 1,
		'profs' => 1,
		'achievs' => 1,
		'lang' => 'en',
		'linkback' => 0,
		'talents' => 1,
		'model' => 0,
		'hair' => 0,
		'haircolor' => 0,
		'face' => 0,
		'skincolor' => 0,
		'facialhair' => 0,
		'facialhairc' => 0,
		'top' => 1,
		'apoints' => 1,
		'weapons' => 0,
	), $atts));
	$randNo = rand(0, pow(10,5));
	$results = '<div id="armory-'.$randNo.'" class="armory_display">';
	$armory = getArmory(array(
		'cname' => $char,
		'realm' => $realm,
		'realmType' => $realmtype,
		'show_g' => $gear,
		'show_p' => $profs,
		'show_a' => $achievs,
		'lang' => $lang,
		'linkback' => $linkback,
		'talents' => $talents,
		'show3D' => $model,
		'hair' => $hair,
		'hairColor' => $haircolor,
		'face' => $face,
		'skinColor' => $skincolor,
		'facialHair' => $facialhair,
		'facialHairColor' => $facialhairc,
		'show_top' => $top,
		'show_apoints' => $apoints,
		'weapons' => $weapons,
		)
	);
	$results .= $armory['content'];
	$results .= '</div>';
	return "$results";
}

function wowarmory_options_page() {

if (isset($_GET['deleteit']) && isset($_GET['delete'])) {
	$clear_count = 0;
	foreach( (array) $_GET['delete'] as $clear_name ) {
		delete_option($clear_name);
		$clear_count++;
	}
	?>
	<div id="message" class="updated fade">
		<p><?php echo sprintf('Cleared %s caches.', $clear_count); ?></p>
	</div>
	<?php
}

$wrmAdmin = new WoWArmory();
	?>
	<div class="wrap">
		<h2>wow-armory Cache Administration</h2>
		<form id="cache-list" action="" method="get">
			<input type="hidden" value="wowarmorycache" name="page" />
			
			<div class="tablenav">
				<input type="submit" value="Refresh" name="refresh" class="button-secondary" />
				<input type="submit" value="Clear Cache" name="deleteit" class="button-secondary delete" />
				<br class="clear" />
			</div>

			<br class="clear" />
			
			<table class="widefat">
				<thead>
					<tr>
						<th scope="col" class="check-column"><input type="checkbox" onclick="checkAll(document.getElementById('cache-list'));" /></th>
						<th scope="col">Character Name</th>
						<th scope="col">Realm</th>
						<th scope="col">Realm Type</th>
						<th scope="col">Last Cache</th>
						<th scope="col"></th>
					</tr>
				</thead>
				
				<tbody>
					<?php 
						global $wpdb;
						$caches = $wpdb->get_results("SELECT * FROM ".(($table_prefix)?$table_prefix:'wp_')."options WHERE `option_name` LIKE '%lastarmory%' ");
						if (count($caches)==0) {
						?>
							<tr>
								<td scope="row" colspan="4" style="text-align: center;"><strong>No Caches Found</strong></td>
							</tr>
						<?php
						} else {
							foreach ($caches as $cache) {
								$currentCache = get_option($cache->option_name);
								$parser = xml_parser_create();
								xml_parse_into_struct($parser,$currentCache['data'],$vals,$index);
								xml_parser_free($parser);
								$char_info = $vals[$index["CHARACTERINFO"][0]]["attributes"];
								$char_attr = $vals[$index["CHARACTER"][0]]["attributes"];
								$armory = getArmory(array(
										'cname' => $char_attr["NAME"] ,
										'realm' => $char_attr["REALM"],
										'realmType' => $currentCache['realmType'],
										'show_g' => 1,
										'show_p' => 1,
										'show_a' => 1,
										'lang' => $currentCache['lang'],
										'linkback' => 1,
										'talents' => 1,
										'show3D' => 1,
										'hair' => 0,
										'hairColor' => 0,
										'face' => 0,
										'skinColor' => 0,
										'facialHair' => 0,
										'facialHairColor' => 0,
										'show_top' => 1,
										'show_apoints' => 1,
										'title' => 'Armory for %NAME%',
										'weapons' => 0,
									)
								);
								?>
								<tr>
									<th scope="row" class="check-column"><input type="checkbox" name="delete[]" value="<?php echo $cache->option_name; ?>" /></th>
									<td scope="row" style="text-align: left"><img src="<?php echo ($currentCache['realmType'] == "EU" ? $armoryPathEU : $armoryPathUS); ?>/icons/race/<?php echo $char_attr['RACEID'].'-'.$char_attr['GENDERID']; ?>.gif"/> <img src="http://<?php echo ($currentCache['realmType'] == "EU" ? $armoryPathEU : $armoryPathUS);?>/icons/class/<?php echo $char_attr['CLASSID']; ?>.gif" /> <?php echo $char_attr["NAME"]; ?></td>
									<td scope="row" style="text-align: left"><?php echo $char_attr["REALM"]; ?></td>
									<td scope="row" style="width:60px;text-align: left"><?php echo $currentCache['realmType']; ?></td>
									<td scope="row" style="text-align: left"><?php echo date("F j, Y, g:i a", $currentCache['lastarmorycheck']); ?></td>
									<td scope="row" style="width:140px;text-align:center;"><input alt="#TB_inline?height=500&width=400&inlineId=cache-<?php echo $cache->option_name; ?>" title="Armory for <?php echo $char_attr["NAME"]; ?>" class="thickbox button-secondary" type="button" value="View &raquo;" />
									<div id="cache-<?php echo $cache->option_name; ?>" style="display:none;"><?php 
									
									
									echo $armory['content'];
									
									 ?></div></td>
								
								</tr>
								<?php
							}
						}
					?>
				</tbody>
			</table>
			<div class="tablenav">
				<br class="clear" />
			</div>
		</form>	
	</div>
	<?php
}

function WoWArmoryAddPages() {
	$page_name = add_options_page('wow-armory Cache Administration', 'wow-armory Cache', 8, 'wowarmorycache', 'wowarmory_options_page');
	add_action('admin_head-'.$page_name,'wowarmory_thickbox_css');
}

function wowarmory_thickbox_css() {
	echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/wow-armory/includes/thickbox/thickbox.css" type="text/css" />';
}

function wowarmory_admin_scripts() {
	wp_enqueue_script('thickbox-compressed', get_bloginfo('wpurl') . '/wp-content/plugins/wow-armory/includes/thickbox/thickbox-compressed.js', array('jquery'));
	//wp_enqueue_script('wow-armory-effects', get_bloginfo('wpurl') . '/wp-content/plugins/wow-armory/includes/effects.js', array('jquery'));
	wp_enqueue_script('jquery-autocomplete', get_bloginfo('wpurl') . '/wp-content/plugins/wow-armory/includes/jquery.autocomplete.js', array('jquery'));
}
require_once(ABSPATH . 'wp-includes/class-snoopy.php');
require_once('includes/functions.php');
add_action('widgets_init', 'WoWArmoryWidgetInit');
add_shortcode('wowarmory', 'WoWArmoryFromShortcode');
add_action('admin_menu', 'WoWArmoryAddPages');
add_action('admin_init', 'wowarmory_admin_scripts');

?>