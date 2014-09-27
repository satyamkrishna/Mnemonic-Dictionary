<style type="text/css">
   #search_label
   {
   		font-weight: bold;
   		color: #636363;
   }
   #search_label:hover
   {
   	   background-color: rgb(240, 240, 240);
   	   border:#ACACAC 1px solid;
   	   color:#000000;
   	   opacity: 0.80;
   } 
   #search_label:active
   {
   	  background-color: rgb(230, 230, 230);
   }
   .search
    {
    	z-index:10;
    	background:white;
		border: 1px solid #ccc;
		border-top-color: #d9d9d9;
		box-shadow: 0 2px 4px rgba(0,0,0,0.2);
		-webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.2);
		cursor: default;
		display:none;
	}
	
	.search-val
	{
		padding:2px 5px 2px 6px;
		line-height: 1.2 !important;
		margin-bottom: 0em !important;
	}
	
	.search-val:hover
	{
		background: #CCCCCC;
	}
	
	.search_div
	{
		margin-bottom:40px!important;
	}
</style>

<?php
$val = '';
if(isset($search))
{
	$val = $search;
}

?>

<div class="row search_div">
	<div class="large-8 large-centered columns card" style="min-height:60px;padding:20px;max-height:75px;">
		<div class="row collapse">
			<div class="small-9 columns">
				<input type="text" placeholder="search" style="margin:0px" id="search" value="<?php echo $val; ?>"/>
				<div class="search"></div>
			</div>
			<div class="small-3 columns">
				<span class="postfix radius" id="search_label">Search</span>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function()
{	
	
	$(document.body).on('click','.search-val', function()
	{
		$('#search').val($(this).text());
		$('.search').hide();
	});
	
	
	var ajaxPool = new Array();
	
	/*
	$('.search_div').focusout(function()
	{
		$('.search').hide();
	});
	*/
	
	$('#search').focusin(function()
	{
		search_val();
	});
	
	$('#search').bind('keyup', function(e)
	{
		
        search_val();
		if(e.which == 13)
        {
        	$('.search').hide();
        	enter_search();
        }
	});
	
    $('#search_label').click(function()
    {
    	enter_search();
    });
    
    function search_val()
    {
    	search = $('#search').val();
		
		if(search == '')
		{
			$('.search').hide();
		}
		else
		{
			$.each(ajaxPool, function()
			{
			    this.abort();
			});
			var filename = getFileName();
			var request = $.post('include/search_ajax.php',{search:search,filename:filename},function(data)
			{
				if(data!= '' && $('#search').val() != '')
				{
					$('.search').html(data);
					$('.search').show();
				}
			});
			ajaxPool.push(request);
        }
    }
    
    function getFileName() 
	{
		//this gets the full url
		var url = document.location.href;
		//this removes the anchor at the end, if there is one
		url = url.substring(0, (url.indexOf("#") == -1) ? url.length : url.indexOf("#"));
		//this removes the query after the file name, if there is one
		url = url.substring(0, (url.indexOf("?") == -1) ? url.length : url.indexOf("?"));
		//this removes everything before the last slash in the path
		url = url.substring(url.lastIndexOf("/") + 1, url.length);
		//return
		return url;
	}
    
    function enter_search()
    {
    	var search_word = $('#search').val();
    	if(search_word != '')
    	{
    		url = 'word.php?word='+search_word;
    		window.location.href = url;
    	}
    }
});
</script>

