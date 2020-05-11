<?php
// News Lister 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2016
// Check http://www.netartmedia.net/newslister for demos and information
// Released under the MIT license
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
	<div class="header-line">
		  <div class="container">
			<h3><?php echo $this->texts["config_options"];?></h3>
		  </div>
	</div>

	<div class="container">

			<br/>
			<?php

			$ini_array = parse_ini_file("../config.php",true);
			
			if(isset($_POST["proceed_save"]))
			{
				
				
				$ini_array["website"]["seo_urls"]=stripslashes($_POST["seo_urls"]);
				$ini_array["website"]["date_format"]=stripslashes($_POST["date_format"]);
				$ini_array["website"]["results_per_page"]=stripslashes($_POST["results_per_page"]);
				$ini_array["website"]["admin_email"]=stripslashes($_POST["admin_email"]);
				$ini_array["website"]["use_captcha_images"]=stripslashes($_POST["use_captcha_images"]);
				$ini_array["website"]["time_zone"]=stripslashes($_POST["time_zone"]);
				$ini_array["website"]["image_quality"]=stripslashes($_POST["image_quality"]);
				$ini_array["website"]["max_image_width"]=stripslashes($_POST["max_image_width"]);
				$ini_array["website"]["google_maps_key"]=stripslashes($_POST["google_maps_key"]);
							
				
				if
				(
					trim($_POST["admin_username"])!=""
					&&
					trim($_POST["old_password"])!=""
					&&
					trim($_POST["new_password"])!=""
					&&
					trim($_POST["confirm_new_password"])!=""
				)
				{
					$admin_password_salt="D58X1W";
					if(trim($_POST["new_password"])!=trim($_POST["confirm_new_password"]))
					{
						echo "<h3>".$this->texts["passwords_mismatch"]."</h3>";
					}
					else
					if(md5($_POST["old_password"].$admin_password_salt)!=$ini_array["login"]["admin_password"])
					{
						echo "<h3>".$this->texts["old_password_wrong"]."</h3>";
					}
					else
					{
						$ini_array["login"]["admin_password"]=md5($_POST["new_password"].$admin_password_salt);
						$ini_array["login"]["admin_user"]=stripslashes($_POST["admin_username"]);
					
						echo "<h3>".$this->texts["password_changed_success"]."</h3>";
					}
					
				}
				
				$this->write_ini_file("../config.php", $ini_array);
			}
			

			
			?>
			
			<div class="row">
				<div class="col-md-8">
				
					<br/>
				
				
					<form id="main" action="index.php" method="post">
					<input type="hidden" name="page" value="settings"/>
					<input type="hidden" name="proceed_save" value="1"/>
						
						<fieldset>
							<legend>
							
								<a target="_blank" href="http://support.netartmedia.net/article-news-lister-settings-and-configuration-options-13.html"><img src="images/question-white.png" alt="Get Help" class="pull-right" style="position:relative;top:-12px"/></a>
								<?php echo $this->texts["website_settings"];?>
							
							</legend>
							<ol>
								<li>
									<label><?php echo $this->texts["use_seo_urls"];?>:</label>
									
									<select name="seo_urls">
										<option value="0" <?php if($ini_array["website"]["seo_urls"]=="0") echo "selected";?>><?php echo $this->texts["no_word"];?></option>
										<option value="1" <?php if($ini_array["website"]["seo_urls"]=="1") echo "selected";?>><?php echo $this->texts["yes_word"];?></option>
									</select>
									
								</li>
								
								
								<li>
									<label><?php echo $this->texts["date_format"];?>:</label>
									
									<input type="text" name="date_format" value="<?php echo $ini_array["website"]["date_format"];?>"/>
								</li>
								
								<li>
									<label><?php echo $this->texts["results_per_page"];?>:</label>
									
									<input type="text" name="results_per_page" value="<?php echo $ini_array["website"]["results_per_page"];?>"/>
								</li>
								
								<li>
									<label><?php echo $this->texts["admin_email"];?>:</label>
									
									<input type="text" name="admin_email" value="<?php echo $ini_array["website"]["admin_email"];?>"/>
								</li>
								
								<li>
									<label><?php echo $this->texts["use_captcha_images"];?>:</label>
									
									<select name="use_captcha_images">
										<option value="0" <?php if($ini_array["website"]["use_captcha_images"]=="0") echo "selected";?>><?php echo $this->texts["no_word"];?></option>
										<option value="1" <?php if($ini_array["website"]["use_captcha_images"]=="1") echo "selected";?>><?php echo $this->texts["yes_word"];?></option>
									</select>
									
								</li>
								<li>
									<label><?php echo $this->texts["time_zone"];?>:</label>
									
									<input type="text" name="time_zone" value="<?php echo $ini_array["website"]["time_zone"];?>"/>
								</li>
								<li>
									<label><?php echo $this->texts["image_quality"];?>:</label>
									
									<input type="text" name="image_quality" value="<?php echo $ini_array["website"]["image_quality"];?>"/>
								</li>
								<li>
									<label><?php echo $this->texts["max_image_width"];?>:</label>
									
									<input type="text" name="max_image_width" value="<?php echo $ini_array["website"]["max_image_width"];?>"/>
								</li>
								<li>
									<label><?php echo $this->texts["google_maps_key"];?>:</label>
									
									<input type="text" name="google_maps_key" value="<?php echo $ini_array["website"]["google_maps_key"];?>"/>
								</li>
							<ol>
						</fieldset>
						
						
						
						<fieldset>
							<legend><?php echo $this->texts["modify_admin_user_pass"];?></legend>
							<ol>
								<li>
									<label><?php echo $this->texts["username"];?>:</label>
									
									<input type="text" name="admin_username" value="<?php echo $ini_array["login"]["admin_user"];?>"/>
								</li>
								<li>
									<label><?php echo $this->texts["old_password"];?>:</label>
									
									<input type="password" name="old_password" value=""/>
								</li>
								<li>
									<label><?php echo $this->texts["new_password"];?>:</label>
									
									<input type="password" name="new_password" value=""/>
								</li>
								<li>
									<label><?php echo $this->texts["confirm_new_password"];?>:</label>
									
									<input type="password" name="confirm_new_password" value=""/>
								</li>
								
							<ol>
						</fieldset>
						
						<div class="clearfix"></div>
						<br/>
						<button type="submit" class="btn btn-primary pull-right"><?php echo $this->texts["save"];?></button>
						<div class="clearfix"></div>
					</form>
				
				</div>
				
			</div>

	</div>