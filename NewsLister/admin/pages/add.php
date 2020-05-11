<?php
// News Lister, http://www.netartmedia.net/newslister
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
// Released under the MIT license
?><?php
if(!defined('IN_SCRIPT')) die("");


?>
	<div class="header-line">
		  <div class="container">
		  
			<a href="index.php" style="margin-top:17px" class="btn btn-default pull-right"><?php echo $this->texts["go_back"];?></a>
			
			<h3><?php echo $this->texts["add_new_listing"];?></h3>
		  </div>
	</div>
	
	

	<div class="container">

			<br/>
			<?php
			$show_add_form=true;
			
			class SimpleXMLExtended extends SimpleXMLElement 
			{
			  public function addChildWithCDATA($name, $value = NULL) {
				$new_child = $this->addChild($name);

				if ($new_child !== NULL) {
				  $node = dom_import_simplexml($new_child);
				  $no   = $node->ownerDocument;
				  $node->appendChild($no->createCDATASection($value));
				}

				return $new_child;
			  }
			}

			if(isset($_REQUEST["proceed_save"]))
			{
				///images processing
				$str_images_list = "";
				$limit_pictures=25;	
				$path="../";
				
				$ini_array = parse_ini_file("../config.php",true);
				$image_quality=$ini_array["website"]["image_quality"];
				$max_image_width=$ini_array["website"]["max_image_width"];
				
				include("include/images_processing.php");
				///end images processing
				$listings = simplexml_load_file($this->data_file,'SimpleXMLExtended', LIBXML_NOCDATA);
				$listing = $listings->addChild('listing');
				$listing->addChild('time', time());
				$listing->addChild('title', stripslashes($_POST["title"]));
				$article_content=stripslashes($_POST["description"]);
				$article_content=str_replace("&nbsp;"," ",$article_content);
				
				$listing->addChildWithCDATA('description', $article_content);
				$listing->addChild('images', $str_images_list);
				$listing->addChild('written_by', stripslashes($_POST["written_by"]));
				$listing->addChild('latitude', stripslashes($_POST["latitude"]));
				$listing->addChild('longitude', stripslashes($_POST["longitude"]));
				$listing->addChild('address', stripslashes($_POST["address"]));
				$listings->asXML($this->data_file); 
				?>
				<h3><?php echo $this->texts["new_added_success"];?></h3>
				<br/>
				<a href="index.php?page=add" class="underline-link"><?php echo $this->texts["add_another"];?></a>
				<?php echo $this->texts["or_message"];?>
				<a href="index.php?page=home" class="underline-link"><?php echo $this->texts["manage_listings"];?></a>
				<br/>
				<br/>
				<br/>
				<?php
				$show_add_form=false;
			}	
			
			

			if($show_add_form)
			{
			?>
			
				<a target="_blank" href="http://support.netartmedia.net/article-making-new-posts-in-news-lister-14.html"><img src="images/question-white.png" alt="Get Help" class="pull-right" style="position:relative;top:-12px"/></a>
								
					<br/>
				
					<script src="js/nicEdit.js" type="text/javascript"></script>
					<script type="text/javascript">
					bkLib.onDomLoaded(function() {
						new nicEditor({fullPanel : true,iconsPath : 'js/nicEditorIcons.gif'}).panelInstance('description');
					});
					</script>
					<style>
					.nicEdit-main{ background-color: white;}
					.nicEdit-selected { border-style:none !important;}
					*{outline-width: 0;}
					</style>
					<form  action="index.php" method="post"   enctype="multipart/form-data">
					<input type="hidden" name="page" value="add"/>
					<input type="hidden" name="proceed_save" value="1"/>
				
					<div class="row">
						<div class="col-md-2">
							<?php echo $this->texts["title"];?>:
						</div>
						<div class="col-md-10">
									<input class="form-control" type="text" name="title" required value=""/>
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="col-md-2">
							<?php echo $this->texts["description"];?>:
						</div>
						<div class="col-md-10">
							
							

							<textarea class="form-control" id="description" name="description" cols="40" rows="10" style="width:100%;height:100%"></textarea>
							
						</div>
					</div>		
					
					<br/>
					
					<div class="row">
						<div class="col-md-2">			
							<?php echo $this->texts["images"];?>:
						</div>
						<div class="col-md-10">		
							<!--images upload-->
							<script src="../js/jquery.uploadfile.js"></script>

							
								<div id="mulitplefileuploader"><?php echo $this->texts["please_select"];?></div>
								
								
								<div id="status"><i>
									
								</i>
								
								</div>
								<script>
								var uploaded_files="";
								$(document).ready(function()
								{
								var settings = {
									url: "upload.php",
									dragDrop:true,
									fileName: "myfile",
									maxFileCount:25,
									allowedTypes:"jpg,png,gif",	
									returnType:"json",
									 onSuccess:function(files,data,xhr)
									{
										if(uploaded_files!="") uploaded_files+=",";
										uploaded_files+=data;
										
									},
									afterUploadAll:function()
									{
										var preview_code="";
										var imgs = uploaded_files.split(",")
										for (var i = 0; i < imgs.length; i++)
										{
											preview_code+='<div class="img-wrap"><img width="120" src="uploads/'+imgs[i]+'"/></div>';
										}
										
										document.getElementById("status").innerHTML=preview_code;
										document.getElementById("list_images").value=uploaded_files;
									},
									showDelete:false,
									
									showProgress:true,
									showFileCounter:false,
									showDone:false
								}
								
								

								var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


								});
								</script>
										
							<!--end images upload-->
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="col-md-2">
							<?php echo $this->texts["add_map"];?>:
						</div>
						<div class="col-md-10">
							<!--google maps-->
							
							<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->settings["website"]["google_maps_key"];?>"></script>
							<script>
							  var geocoder;
							  var map;
							  function initialize() 
							  {
								geocoder = new google.maps.Geocoder();
								var latlng = new google.maps.LatLng(0, 0);
								var mapOptions = {
								  zoom: 1,
								  center: latlng,
								  mapTypeId: google.maps.MapTypeId.ROADMAP
								}
								map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
								
							}

							  function PreviewMap() 
							  {
								
								if(document.getElementById('address').value=="")
								{
									alert("<?php echo $this->texts["please_enter_address"];?>");
									document.getElementById('address').focus();
								}
								else
								{
									document.getElementById("map-canvas").style.display="block";
								  
									var address = "";
									
									
									address += document.getElementById('address').value;
									geocoder.geocode( { 'address': address}, function(results, status) {
									  if (status == google.maps.GeocoderStatus.OK) {
										map.setCenter(results[0].geometry.location);
										
										map.setZoom(13);
										
										var marker = new google.maps.Marker({
											map: map,
											position: results[0].geometry.location
										});
										
										document.getElementById("latitude").value=
										results[0].geometry.location.lat();
										
										document.getElementById("longitude").value=
										results[0].geometry.location.lng();
										
										
									  } else {
										alert('Google Maps can\'t find this address: ' + status);
									  }
									});
									google.maps.event.trigger(map, 'resize');
									map.checkResize();
								}
							  }
							  
							  window.onload=initialize;
							</script>
							<script>
							function AddMap()
							{
								if(document.getElementById("add-map").style.display=="none")
								{
									document.getElementById("add-map").style.display="block"
								}
								else
								{
									document.getElementById("add-map").style.display="none"
								}
							}
							
							function UserKeyUp()
							{
								if(document.getElementById("address").value=="")
								{
									document.getElementById("preview-map").style.display="none";
								}
								else
								{
									document.getElementById("preview-map").style.display="block";
								}
							}
							</script>
							
						
								<input placeholder="<?php echo $this->texts["please_enter_address"];?>" class="form-control" name="address" value="<?php if(isset($_REQUEST["address"])) echo $_REQUEST["address"];?>" onkeyup="javascript:UserKeyUp()" id="address" type="text"/>
						
							<br/>
							
							<div class="row">
								<div class="col-md-1">
									<br/>
									<?php echo $this->texts["or_enter"];?>
								</div>
								<div class="col-md-2">
									<?php echo $this->texts["latitude"];?>:
									<br/>
									<input type="text" name="latitude" id="latitude"  class="form-control" style="width:120px !important;float:left !important" value="<?php if(isset($_REQUEST["latitude"])) echo $_REQUEST["latitude"];?>">
									<br/>
									<span style="font-size:10px"><?php echo $this->texts["e_g"];?> 40.758224</span>
							
								</div>
								<div class="col-md-2">
									<?php echo $this->texts["longitude"];?>:
									<br/>
									<input type="text" name="longitude" id="longitude" class="form-control" style="width:120px !important;float:left !important" value="<?php if(isset($_REQUEST["longitude"])) echo $_REQUEST["longitude"];?>"> 
									<br/>
									<span style="font-size:10px"><?php echo $this->texts["e_g"];?> -73.917404</span>
									
								</div>
							</div>
									<div class="clearfix"></div>	
							
							<br/>
							<span id="preview-map"><a class="underline-link" href="javascript:PreviewMap()"><?php echo $this->texts["preview_save"];?></a></span>
							<div class="clear"></div>
						
							<div id="map-canvas" style="width: 500px; height: 300px;display:none"></div>
				
				
							<br/>	
							<br/>
							
							<!--end google maps-->
						</div>
					</div>


					
					<div class="row">
						<div class="col-md-2">
							<?php echo $this->texts["written_by"];?>:
						</div>
						<div class="col-md-10">
							<input class="form-control" type="text" name="written_by" value=""/>
						</div>
					</div>				
									
										
					<input type="hidden" name="list_images" value="<?php if(isset($_POST["list_images"])) echo $_POST["list_images"];?>" id="list_images"/>
				
					<div class="clearfix"></div>
			
						
				<div class="clearfix"></div>
				<br/>
				<button type="submit" class="btn btn-primary pull-right"> <?php echo $this->texts["submit"];?> </button>
				<div class="clearfix"></div>
			</form>
				
			
			<?php
			}
			?>
	</div>
	
	<style>
	textarea{background:white !important}
	</style>