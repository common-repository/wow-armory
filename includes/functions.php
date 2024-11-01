<?php

  
  
  function imgCache($image_url,$prefix = "")
	{
       
    $image_path = 'wp-content/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'cache/';
    $exploded_image_url = explode("/",$image_url);
    $image_filename = end($exploded_image_url);
    $exploded_image_filename = explode(".",$image_filename);
    $extension = end($exploded_image_filename);
    $new_img_path = get_option('siteurl').'/'.$image_path.$prefix.$image_filename;
   
    $file_out = $image_url;
    //make sure its an image
    if($extension=="gif"||$extension=="jpg"||$extension=="png")
    {
        if(file_exists(ABSPATH.$image_path.$prefix.$image_filename))
        {
            $file_out = $new_img_path;
        }
        else
        {
            if(!$fp = fopen(ABSPATH.$image_path.$prefix.$image_filename, 'w'))
            {
                echo "error<br/>";
            }
            else
            {
                $curl = curl_init($image_url);
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                curl_setopt($curl, CURLOPT_FILE, $fp);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_exec($curl);
                curl_close($curl);
                fclose($fp);
                $file_out = $new_img_path;
            }
        }
    }
    return $file_out;
	}

  
	function showBar($value, $max, $caption, $span_class, $color='green')
	{
		$max2 = ($max >= $value ? $max : $value);
		$results = '<div style="text-align:center;" class="prog-bar '.$span_class.'"><div class="progressTxt"><strong>'.$caption.'</strong> '.$value.'/'.$max.' ('.ceil(($value/$max)*100).'%)</div><b class="bar-'.$color.'" style="width: '.ceil(($value/$max2)*100).'%;"></b></div>';
		
		
	//	$results = '<dl class="prog_bar"><dd class="prog_bar"><span class="back">'.$value.'/'.$max.'</span><span class="bar" style="left:-'.(204-(204*($value/$max))).'px;"></span><em>'.$value.'/'.$max.'</em><span class="caption '.$span_class.'">'.$caption.' ('.ceil(($value/$max)*100).'%)</span></dd></dl>';
		return $results;
	}

	function getDID($itemID) {
		$url = 'http://www.wowhead.com/?item='.$itemID.'&xml';
		$snoopy = new Snoopy();
		$snoopy->agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3";
		$snoopy->rawheaders["Accept-Language"] = $locale.",en;q=0.5";
		@$snoopy->fetch($url);
		$output = $snoopy->results;
		$parser = xml_parser_create();
		xml_parse_into_struct($parser,$output,$vals,$index);
		xml_parser_free($parser);
		$icon = $vals[$index["ICON"][0]]["attributes"];
		
		$slot = substr($vals[$index["JSONEQUIP"][0]]["value"],strlen("slotbak:"),strpos($vals[$index["JSONEQUIP"][0]]["value"],",")-strlen("slotbak:"));
		
		return Array('did' => $icon["DISPLAYID"], 'slot' => $slot);
	}
			
	function get3DModel($model,$modeldata,$equipList) {
		$results = '<object id="wowhead" width="250" height="400" type="application/x-shockwave-flash" data="http://static.wowhead.com/modelviewer/ModelView.swf"><param name="quality" value="high"/><param name="allowscriptaccess" value="always"/><param name="menu" value="false"/><param value="transparent" name="wmode"><param name="flashvars" value="contentPath=http://static.wowhead.com/modelviewer/&blur=1';
		$results .= '&model='.$model;
		$results .= '&modelType=16';
		$results .= '&ha='.$modeldata['hair'];
		$results .= '&hc='.$modeldata['hairColor'];
		$results .= '&fa='.$modeldata['face'];
		$results .= '&sk='.$modeldata['skinColor'];
		$results .= '&fh='.$modeldata['facialHair'];
		$results .= '&fc='.$modeldata['facialHairColor'];
		$results .= '&equipList='.$equipList.'"/>';
		$results .= '</object>';
		return $results;
	}

	function getArmory($options) {
		$isOkay = TRUE;
		$results = array(
			'cname' => '',
			'raceid' => '',
			'genderid' => '',
			'content' => '?????',
		);

		/* -- List of Profession Icons -- */
		$prof_img = array(
			"jewelcrafting"	=>	'inv_misc_gem_02',
			"inscription" => 'inv_inscription_tradeskill01',
			"leatherworking" => 'inv_misc_armorkit_17',
			"skinning" =>	'inv_misc_pelt_wolf_01',
			"herbalism"	=>	'spell_nature_naturetouchgrow',
			"alchemy" =>	'trade_alchemy',
			"blacksmithing" => 'trade_blacksmithing',
			"engineering" => 'trade_engineering',
			"enchanting" =>	'trade_engraving',
			"mining" =>	'trade_mining',
			"tailoring" =>	'trade_tailoring',
		);
		$armoryPathUS = "wowarmory.com/_images";
		$armoryPathEU = "wowarmory.com/images";
		/* ------------------------------ */
		
		$locale = substr(get_locale(), 0, 2);
		$options['realmType'] = (isset($options['realmType']) && $options['realmType']!='') ? $options['realmType'] : "US";
		if($options['realmType'] == "EU")
		{
      $rt = 'eu';
      $armoryPath = $armoryPathEU;
		}
		else 
		{
      $rt = 'www';
      $armoryPath = $armoryPathUS;
     }
		
		$options['realm'] = str_replace(" ","+",$options['realm']);
		$wl = isset($options['lang']) ? ($options['lang'] == 'en' ? 'www' : $options['lang']) : 'www';
		$baseURL = get_bloginfo('wpurl') . '/wp-content/plugins/wow-armory/';
		$url = "http://$rt.wowarmory.com/character-sheet.xml?r=".stripslashes($options['realm']).'&n='.stripslashes($options['cname']);
		
		if (get_option("lastarmory-".md5($options['cname'].'-'.$options['realm'].'-'.$options['realmType']))) {
			// If there is cached data for this character, grab it
			$armory_check = get_option("lastarmory-".md5($options['cname'].'-'.$options['realm'].'-'.$options['realmType']));
		} else {
			// else, leave it blank
			$armory_check = Array(
				'lastarmorycheck' => mktime() - 1000,
				'data' => false,
				'achiev' => false
			);
		}
		
		
		if ($armory_check['lastarmorycheck'] < ( mktime() - 900 )	|| !$armory_check['data'] || $options['forceNew'] == 1 ) {
			$snoopy = new Snoopy();
			$snoopy->agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3";
			$snoopy->rawheaders["Accept-Language"] = $locale.",en;q=0.5";
			@$snoopy->fetch($url);
			$output = $snoopy->results;
			$armory_check['lastarmorycheck'] = mktime();
			if (!$output || trim($output) == '') {
				$output = $armory_check['data'];
			}
			else
			{
				$parser = xml_parser_create();
				xml_parse_into_struct($parser, $output,$vals,$index);
				xml_parser_free($parser);
				if(!$vals) {
					if($armory_check['data'])
						$output = $armory_check['data'];
				} else {
					if(!empty($vals[$index["ERRORHTML"][0]]["attributes"]))
					{
						if($armory_check['data']) 
							$output = $armory_check['data'];
					}
				}
			}
		} else {
			$output = $armory_check['data'];
		}
		
		

		//find out if there was an error returned by the armory: maintenence, etc
		

		if (!$output || trim($output) == '') {
			$isOkay = FALSE;
			$results['content'] = "<p>Armory data is unavailable at this time.</p>";
		} else {
			$parser = xml_parser_create();
			xml_parse_into_struct($parser, $output,$vals,$index);
			xml_parser_free($parser);
			if(!$vals) {
				$isOkay = FALSE;
				$results['content'] = "<p>Armory data is unavailable at this time.</p>";
			} else {
				
				if(!empty($vals[$index["ERRORHTML"][0]]["attributes"]))
				{
					$isOkay = FALSE;
					
					$errType = $vals[$index["ERRORHTML"][0]]["attributes"];
					if(trim($errType["TYPE"])=="maintenance")
						$results['content'] = '<ul><li style="margin-left:10px;height:18px;padding-left:20px;background:url(\''.imgCache('http://static.wowhead.com/images/icons/small/inv_misc_enggizmos_swissarmy.jpg').'\') 0px 0px no-repeat !important;display:block;"><small>&nbsp;Armory data is unavailable due to Maintenance.</small></li></ul>';
					else
						$results['content'] = "<p>Armory data is unavailable at this time.</p>";
				}
				else
				{
					/* ------- Top -------- */
					$char_info = $vals[$index["CHARACTERINFO"][0]]["attributes"];
					if ($char_info['ERRCODE'] == "noCharacter") {
						$isOkay = FALSE;
						$results['content'] = "<p>Character could not be found.</p>";
					} else {
						$char_attr = $vals[$index["CHARACTER"][0]]["attributes"];
						$results['cname'] = $char_attr["NAME"];
						$results['raceid'] = $char_attr["RACEID"];
						$results['genderid'] = $char_attr["GENDERID"];
						$results['content'] = '';
													
						if ($options['show_top']) {
							if ($char_attr["LEVEL"] < 60) {
								$img_age = "-default";
							} else if ($char_attr["LEVEL"] < 70) {
								$img_age = '';
							} else if ($char_attr["LEVEL"] < 80) {
								$img_age = '-70';
							} else {
								$img_age = '-80';
							}
							$top_block .= "<img src=\"".imgCache("http://$rt.$armoryPath/portraits/wow".$img_age."/".$char_attr["GENDERID"]."-".$char_attr["RACEID"]."-".$char_attr["CLASSID"].'.gif').'" width="48" height="48" class="armory_char_prof" alt="Character portrait" /><span class="armory_char_name"><a href="'."http://$rt.wowarmory.com/character-sheet.xml?r=".stripslashes($options['realm'])."&n=".stripslashes($options['cname']).'">'.($char_attr["PREFIX"] ? $char_attr["PREFIX"].' ' : '').$char_attr["NAME"].($char_attr["SUFFIX"] ? $char_attr["SUFFIX"].' ' : '').'</a></span><br/>'.($char_attr["GUILDNAME"] ? '<strong><a href="http://'.$rt.'.wowarmory.com/guild-info.xml?r='.stripslashes($options['realm']).'&gn='.$char_attr["GUILDNAME"].'">&lt;'.$char_attr["GUILDNAME"].'&gt;</a></strong>' : '').'<span class="armory_char_info" > of '.$char_attr["REALM"]."-".$options['realmType'].'<br/>Level '.$char_attr["LEVEL"].' '.$char_attr["RACE"].' '.$char_attr["CLASS"].'<br/>';
						}
						/* === TALENTS === */
						if($options['talents']) {
							// if they want to show the Talents section
							if($index["TALENTSPECS"]) {
								$talents[0] = $vals[$index["TALENTSPEC"][0]]["attributes"];
								if($talents[0]['TREEONE'] >= $talents[0]['TREETWO']) {
									if($talents[0]['TREEONE'] >= $talents[0]['TREETHREE']) {
										$spec[0] = 1;
									} else {
										$spec[0] = 3;
									}
								} else if($talents[0]['TREETWO'] >= $talents[0]['TREETHREE']) {
									$spec[0] = 2;
								} else {
									$spec[0] = 3;
								}
								
								if($talents[0]['ACTIVE']) {
									$tactive = 0;
									$tinactive = 1;
								} else {
									$tactive = 1;
									$tinactive = 0;
								}

								if($index["TALENTSPEC"][1]) {
									$tdual = true;
									$talents[1] = $vals[$index["TALENTSPEC"][1]]["attributes"];
									if($talents[1]['TREEONE'] >= $talents[1]['TREETWO']) {
										if($talents[1]['TREEONE'] >= $talents[1]['TREETHREE']) {
											$spec[1] = 1;
										} else {
											$spec[1] = 3;
										}
									} else if($talents[1]['TREETWO'] >= $talents[1]['TREETHREE']) {
										$spec[1] = 2;
									} else {
										$spec[1] = 3;
									}
								} else {
									$talents[1] = false;
								}
							
							} else {
								 $talents[0] = false;
								 $talents[1] = false;
							} 
							
							if ($talents[0]) {
							
								$talent_block = '<span class="active_spec"><img src="'.imgCache('http://'.$rt.'.'.$armoryPath.'/icons/class/'.$char_attr["CLASSID"].'/talents/'.$spec[$tactive].'.gif',$char_attr["CLASSID"].'-').'" style="border:0;vertical-align:middle;margin-right:5px;" width="27" height="27" alt="Active talent spec" /><a href="http://'.$rt.'.wowarmory.com/character-talents.xml?r='.stripslashes($options['realm']).'&n='.stripslashes($options['cname']).'">'.$talents[$tactive]['TREEONE'].' / '.$talents[$tactive]['TREETWO'].' / '.$talents[$tactive]['TREETHREE'].'</a></span>';
								
								
								if($talents[1]){
									$talent_block.='<span class="inactive_spec"><img src="'.imgCache('http://'.$rt.'.'.$armoryPath.'/icons/class/'.$char_attr["CLASSID"].'/talents/'.$spec[$tinactive].'.gif',$char_attr["CLASSID"].'-').'" style="border:0;vertical-align:middle;margin-right:5px;" width="27" height="27" alt="Active talent spec" /><a href="http://'.$rt.'.wowarmory.com/character-talents.xml?r='.stripslashes($options['realm']).'&n='.stripslashes($options['cname']).'">'.$talents[$tinactive]['TREEONE'].' / '.$talents[$tinactive]['TREETWO'].' / '.$talents[$tinactive]['TREETHREE'].'</a></span>';
								}
							}
						} else {
							$talent_block = '';
						}
						
						if ($options['show_top'] || $options['talents'] ) {
							$top_block = '<div>'.$top_block;
							$talent_block .= '</div>';
						}
						/* =============== */
						
						/* ==== GEAR ===== */
						// if they don't want to show gear or the 3d model, we can skip this.
						if (($options['show_g'] || $options['show3D'] ) && $index["ITEM"]) {
							
							$equipList = '';
							foreach($index["ITEM"] as $items) {
								$item = $vals[$items]["attributes"];
								if ($options['show3D']) {
									$itemDID = getDID($item["ID"]);
										if ($itemDID['slot'] != 2 && $itemDID['slot'] != 11 && $itemDID['slot'] != 12 && $itemDID['slot'] != 14) {
											if(($options['weapons'] == 0 && $itemDID['slot'] != 15) || ($options['weapons'] == 1 && $itemDID['slot'] != 13 && $itemDID['slot'] != 22) || ($options['weapons'] == 2 && $itemDID['slot'] != 22 && $itemDID['slot'] != 15 && $itemDID['slot'] != 13) ) {
								
											$equipList.=(($equipList != '') ? ',' : '').($itemDID['slot']).','.$itemDID['did'];
										}
									}
								}
								if ($options['show_g']) {
									if ($item["SLOT"] >= 0) {
										$enchants="lvl=".$char_attr["LEVEL"];								
										if ($item["PERMANENTENCHANT"] != "0")
											$enchants.=";ench=".$item["PERMANENTENCHANT"];
											
										if ($item["RANDOMPROPERTIESID"] != "0")
											$enchants.=";rand=".$item["RANDOMPROPERTIESID"];
										 
											if ($item["GEM0ID"] != "0" || $item["GEM1ID"] != "0" || $item["GEM1ID"] != "0") {
												$enchants.=";gems=";
												if ($item["GEM0ID"] != "0") 
													$enchants.=$item["GEM0ID"];
												if ($item["GEM1ID"] != "0") 
													$enchants.=":".$item["GEM1ID"];
												if ($item["GEM2ID"] != "0") 
													$enchants.=":".$item["GEM2ID"];
											}
											
										$equipDisplay .= '<li><a href="http://'.$wl.'.wowhead.com/?item='.$item["ID"].'"'.(($enchants) ? ' rel="'.$enchants.'"' : '').'>';
										$equipDisplay .= '<img src="'.imgCache('http://'.$rt.'.wowarmory.com/wow-icons/_images/51x51/'.$item["ICON"].'.jpg').'" width="26" height="26" class="armory_item_icon" alt="'.$item["ID"].'" />';
										$equipDisplay .= '</a></li>';
									}
								}
							}
							if ($options['show_g'])
								$equipDisplay = '<h4>Equipment</h4><ul class="armory_equip_list">'.$equipDisplay.'</ul>';
						}
						/* =============== */
						
						/* === 3D model == */
						if ($options['show3D'] && $equipList != '' ) {
							$model3D = WoWArmory::$modelNames[$char_attr["RACEID"]][$char_attr["GENDERID"]];
							$model_block = get3DModel($model3D, $options, $equipList);
						}
						/* =============== */
						
						
						/* == Profession = */
						if ($options['show_p'] && $index["SKILL"]){
							$prof_1 = $vals[$index["SKILL"][0]]["attributes"];
							$prof_2 = $vals[$index["SKILL"][1]]["attributes"];
							if ($prof_1 != NULL || $prof_2 != NULL) {
								$prof_block = '<h4>Professions</h4><ul class="armory_prof_list">';
								if ($prof_1 != NULL) {
									$prof_block .= '<li style="margin-left:10px;height:18px;padding-left:20px;background:url(\''.imgCache('http://static.wowhead.com/images/icons/small/'.$prof_img[$prof_1["KEY"]].'.jpg').'\') 0px 0px no-repeat !important;display:block;">'.showBar($prof_1["VALUE"], $prof_1["MAX"], $prof_1["NAME"], 'prof', 'blue').'</li>';
								}
								if ($prof_2 != NULL) {
									$prof_block .= '<li style="margin-left:10px;height:18px;padding-left:20px;background:url(\''.imgCache('http://static.wowhead.com/images/icons/small/'.$prof_img[$prof_2["KEY"]].'.jpg').'\') 0px 0px no-repeat !important;display:block;">'.showBar($prof_2["VALUE"], $prof_2["MAX"], $prof_2["NAME"], 'prof', 'blue').'</li>';
									
								}
								$prof_block .= '</ul>';
							}
						}
						/* =============== */
						
						/* = Achievements = */
						if ($options['show_a'] || $options['show_apoints'] != 0) {
							$urla = "http://$rt.wowarmory.com/character-achievements.xml?r=".stripslashes($options['realm']).'&n='.stripslashes($options['cname']);
							
							if (!$armory_check['achiev'] || $armory_check['achiev'] == '' || $armory_check['lastarmorycheck'] < ( mktime() - 900 )) {
								$snoopya = new Snoopy();
								$snoopya->agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3";
								$snoopya->rawheaders["Accept-Language"] = $locale.",en;q=0.5";
								@$snoopya->fetch($urla);
								$output_achiev = $snoopya->results;
							} else {
								$output_achiev = $armory_check['achiev'];
							}
							
							$parser_achiev = xml_parser_create();
							xml_parse_into_struct($parser_achiev,$output_achiev,$vals_a,$index_a);
							xml_parser_free($parser_achiev);
							if ($vals_a && $index_a["ACHIEVEMENT"]) {
								$ach_points = $vals_a[$index_a["C"][0]]["attributes"];
								switch($options['show_apoints']) {
									case '1':
										$achiev_block .= '<h4>Achievement Points</h4>';
										$achiev_block .= showBar($ach_points["EARNED"], $ach_points["TOTAL"], $ach_points["POINTS"].' Points', 'apoints');
										break;
									case '2':
										$achiev_block .= '<h4>Achievement Points</h4>';
										$achiev_block .= '<p class="apoints-text">'.$ach_points["POINTS"].' Points ('.ceil(($ach_points["EARNED"]/$ach_points["TOTAL"])*100).'%)</p>';
										break;
								}
								if ($options['show_a']) {
									$achiev_block .= '<h4>Recent Achievements</h4><ul class="armory_achiev_list">';
									foreach($index_a["ACHIEVEMENT"] as $achs) {
										$ach = $vals_a[$achs]["attributes"];
										$achiev_block .= '<li><a href="http://'.$wl.'.wowhead.com/?achievement='.$ach["ID"].'"><img src="'.imgCache('http://'.$rt.'.wowarmory.com/wow-icons/_images/51x51/'.$ach["ICON"].'.jpg').'" width="20" height="20" class="armory_achiev_icon" alt="'.$ach["TITLE"].'" />'.$ach["TITLE"].'</a></li>';
									}
									$achiev_block .= '</ul>';
								}
							}
						}
						/* =============== */
						
						if ($options['linkback']) 
							$linkback = '<br/><p style="text-align:right;"><a href="http://timsworld.nfshost.com"><img src="'.$baseURL.'powered_by.png" style="border: 0;" alt="Tim\'s World" /></a></p>';
					}
				}
			}
		}
		if($isOkay) {
			$armory_check['data'] = $output;
			$armory_check['achiev'] = $output_achiev;
			
			$armory_check['crealm'] = $char_attr["REALM"];
			$armory_check['raceid'] = $char_attr["RACEID"];
			$armory_check['realmType'] = $options['realmType'];
			$armory_check['lang'] = $options['lang'];
			
			$results['content'] = $top_block.$talent_block.$model_block.$equipDisplay.$prof_block.$achiev_block.$linkback;
			if (get_option("lastarmory-".md5($options['cname'].'-'.$options['realm'].'-'.$options['realmType']))) {
				update_option("lastarmory-".md5($options['cname'].'-'.$options['realm'].'-'.$options['realmType']),$armory_check);
			} else {
				add_option("lastarmory-".md5($options['cname'].'-'.$options['realm'].'-'.$options['realmType']),$armory_check);
			}
		}
		return $results;

	}

	function getArmoryAsync($cname, $realm, $realmtype, $lang, $hair, $haircolor, $face, $skincolor, $facialhair, $facialcolor) {
		$response = array();
		$armory = getArmory(
			array(
				'cname' => stripslashes($cname) ,
				'realm' => stripslashes($realm),
				'realmType' => stripslashes($realmtype),
				'show_g' => 0,
				'show_p' => 0,
				'show_a' => 0,
				'lang' => $lang,
				'linkback' => 0,
				'talents' => 0,
				'show3D' => 1,
				'hair' => $hair,
				'hairColor' => $haircolor,
				'face' => $face,
				'skinColor' => $skincolor,
				'facialHair' => $facialhair,
				'facialHairColor' => $facialcolor,
				'show_top' => 0,
				'forceNew' => 1,
				'weapons' => 0
			)
		);
		$response = array(
				'ok' => true,
				'msg' => $armory['content']);
		return $response;
	}
	
	if (@$_REQUEST['action'] == 'get' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		echo json_encode(getArmoryAsync($_REQUEST['cname'], $_REQUEST['realm'], $_REQUEST['realmtype'], $_REQUEST['lang'], $_REQUEST['hair'], $_REQUEST['haircolor'], $_REQUEST['face'], $_REQUEST['skincolor'], $_REQUEST['facialhair'], $_REQUEST['facialcolor']));
		exit;
	} 

?>