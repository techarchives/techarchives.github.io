<?php
// News Lister
// http://www.netartmedia.net/newslister
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
// Released under the MIT license
?><br/>
<?php
if(!isset($_REQUEST["page"])||$_REQUEST["page"]==""||$_REQUEST["page"]=="results")
{
?>
<h4><?php echo $this->texts["refine_results"];?></h4>
<hr class="no-margin"/>
<br/>
<form action="index.php" method="post">
<input type="hidden" name="page" value="results"/>
<input type="hidden" name="proceed_search" value="1"/>

	<div class="row">
		<label class="control-label col-md-4" for="keyword_search">
			<?php echo $this->texts["keyword"];?>:
		</label>

		<div class="control-field col-md-8 no-right-padding">
			<input required name="keyword_search" value="<?php if(isset($_REQUEST["keyword_search"])) echo preg_replace('/[^\p{L}\p{N} ]/u', '',strip_tags(stripslashes($_REQUEST["keyword_search"])));?>" class="form-control input-sm"/>
		</div>
	</div>
	
	<div class="clearfix"></div>
			<br/>
		<div class="row">
			<input type="submit" class="pull-right btn btn-primary " value="<?php echo $this->texts["search"];?>"/>
		</div>
	<div class="clearfix"></div>
	<br/>
</form>
<?php
}
?>