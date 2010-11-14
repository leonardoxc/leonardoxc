<?php

	session_start();

	$requestVars = isset($_REQUEST) ? $_REQUEST : array(); 

	switch($requestVars['action']) {
		case 'verify':
			if (substr($requestVars['captcha'], 10) == $_SESSION['captchaCodes'][$_SESSION['captchaAnswer']]) {
				echo json_encode(array('status' => 'success'));
			} else {
				$_SESSION['captchaCodes'] = NULL;
				$_SESSION['captchaAnswer'] = NULL;
				echo json_encode(array('status' => 'error'));
			}
			
			break;
		case 'refresh':
			$captchaImages = array(	array(	'label'	=> 'star',
																			'on'		=> array(	'top'		=> '-120px',
																												'left'	=> '-3px'),
																			'off'		=> array(	'top'		=> '-120px',
																												'left'	=> '-66px'),
																	),
															array(	'label'	=> 'heart',
																			'on'		=> array(	'top'		=> '0',
																												'left'	=> '-3px'),
																			'off'		=> array(	'top'		=> '0',
																												'left'	=> '-66px'),
																			),
															array(	'label'	=> 'bwm',
																			'on'		=> array(	'top'		=> '-56px',
																												'left'	=> '-3px'),
																			'off'		=> array(	'top'		=> '-56px',
																												'left'	=> '-66px'),
																			),
															array(	'label'	=> 'diamond',
																			'on'		=> array(	'top'		=> '-185px',
																												'left'	=> '-3px'),
																			'off'		=> array(	'top'		=> '-185px',
																												'left'	=> '-66px'),
																			)
													);

		$captchaCodes = array(	'star'		=> md5(mt_rand(00000000, 99999999)), 
														'heart'		=> md5(mt_rand(00000000, 99999999)), 
														'bwm' 		=> md5(mt_rand(00000000, 99999999)), 
														'diamond' => md5(mt_rand(00000000, 99999999))
														);
		shuffle($captchaImages);
		$randomCaptcha = array_rand($captchaImages);
	
		$_SESSION['captchaAnswer'] = $captchaImages[$randomCaptcha]['label'];
		$_SESSION['captchaCodes'] = $captchaCodes;
		
		//HTML output
		echo '<div class="captchaWrapper" id="captchaWrapper">';
		
		foreach ($captchaImages as $count => $captchaImage) {
			echo '	<a href="#" class="captchaRefresh"></a>
							<div	id="draggable_' . $captchaCodes[$captchaImage['label']] . '" 
										class="draggable" 
										style="left: ' . (($count * 68) + 15) . 'px; background-position: ' . $captchaImage['on']['top'] . ' ' . $captchaImage['on']['left'] . ';"></div>';
		}

		echo '	<div class="targetWrapper">
							<div	class="target" 
										style="background-position: ' . $captchaImages[$randomCaptcha]['off']['top'] . ' ' . $captchaImages[$randomCaptcha]['off']['left'] . ';"></div>
						</div>
						<input type="hidden" class="captchaAnswer" name="captcha" value="" />
					</div>';
		
		break;
	}
