<?php
// News Lister
// http://www.netartmedia.net/newslister
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
// Released under the MIT license
?><?php
if(!defined('IN_SCRIPT')) die("");

$id=intval($_REQUEST["id"]);

$this->ms_i($id);

?>
	<div class="header-line">
		  <div class="container">
		  
			<a href="index.php<?php if(isset($_REQUEST["num"])) echo "?num=".$_REQUEST["num"];?>" style="margin-top:17px" class="btn btn-default pull-right">Go Back</a>
			
			<h3><?php echo $this->texts["edit_listing"];?></h3>
		  </div>
	</div>
	<script>
$(function(){
	var offsetX = 20;
	var offsetY = -200;
	$('a.hover').hover(function(e){	
		var href = $(this).attr('href');
		$('<img id="largeImage" src="' + href + '" alt="image" />')
			.css({'top':e.pageY + offsetY,'left':e.pageX + offsetX})
			.appendTo('body');
	}, function(){
		$('#largeImage').remove();
	});
	$('a.hover').mousemove(function(e){
		$('#largeImage').css({'top':e.pageY + offsetY,'left':e.pageX + offsetX});
	});
	$('a.hover').click(function(e){
		e.preventDefault();
	});
});
</script>
	

	<div class="container">

			<br/>
			<?php
			
			$xml = simplexml_load_file($this->data_file);

		
			if(isset($_POST["proceed_save"]))
			{
				$article_content=stripslashes($_POST["description"]);
				$article_content=str_replace("&nbsp;"," ",$article_content);
				
				$xml->listing[$id]->description=$article_content;
				$xml->listing[$id]->title=stripslashes($_POST["title"]);
				

				if(isset($_POST["written_by"]))
				{
					$xml->listing[$id]->written_by=stripslashes($_POST["written_by"]);
				}
				
				
				$xml->asXML($this->data_file); 
				echo "<h3>".$this->texts["modifications_saved"]."</h3><br/>";
			}	
			
			

			
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
					<input type="hidden" name="page" value="edit"/>
					<input type="hidden" name="proceed_save" value="1"/>
					<input type="hidden" name="id" value="<?php echo $id;?>"/>
					<?php 
					if(isset($_REQUEST["num"]))
					{
						?>
						<input type="hidden" name="num" value="<?php echo $_REQUEST["num"];?>"/>
						<?php
					}
					?>
					
						<div class="row">
							<div class="col-md-2">
									<?php echo $this->texts["title"];?>:
							</div>
						
							<div class="col-md-10">
								<input class="form-control" type="text" name="title" required value="<?php echo $xml->listing[$id]->title;?>"/>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-md-2">
								<?php echo $this->texts["description"];?>:
									
									
							</div>
							<div class="col-md-10">
								<textarea class="form-control" id="description" name="description" cols="40" rows="10"><?php echo $xml->listing[$id]->description;?></textarea>
							
							</div>
						</div>	
						<br/>
						<div class="row">
							<div class="col-md-2">			
								<?php echo $this->texts["images"];?>:
							</div>
							<div class="col-md-10">	
								<?php
								if(trim($xml->listing[$id]->images)!="")
								{
									$image_ids = explode(",",trim($xml->listing[$id]->images));
				
									foreach($image_ids as $image_id)
									{
										if(file_exists("../thumbnails/".$image_id.".jpg"))
										{
											echo "<a href=\"../uploaded_images/".$image_id.".jpg\" class=\"hover\"><img src=\"../thumbnails/".$image_id.".jpg\" class=\"admin-preview-thumbnail\"/></a>";
										}
										
									}
									?>
									
									
									<?php
								}
								else
								{
									?>
									<img src="../images/no_pic.gif" width="50" class="admin-preview-thumbnail"/>
									<?php
								}
																	
								?>	
								<div class="clearfix"></div>
								
								<a class="underline-link" href="index.php?page=images&id=<?php echo $id;?>"><?php echo $this->texts["modify"];?></a>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-md-2">
								<?php echo $this->texts["written_by"];?>:
							</div>
							<div class="col-md-10">
									
									<input class="form-control" type="text" name="written_by" value="<?php echo $xml->listing[$id]->written_by;?>"/>
							</div>
						</div>
						
						
						<div class="clearfix"></div>
						<br/>
						<button type="submit" class="btn btn-primary pull-right"> <?php echo $this->texts["save"];?> </button>
						<div class="clearfix"></div>
					</form>
				
				
	</div>