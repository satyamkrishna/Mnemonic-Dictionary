$(document).ready(function()
{
	ajax(0);
	
	function ajax(index)
	{
		var str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var char = str.charAt(index);
		createDiv(char);
		$.post('include/create_json_ajax.php',{char:char},function()
		{
			if(index < 25)
			{
				ajax(index+1);
				setRandom(str.charAt(index+1).toUpperCase());
				setFull(str.charAt(index).toUpperCase());
			}
			else if(index == 25)
			{
				setFull(str.charAt(index).toUpperCase());
			}
		});
	}
	
	function setFull(char)
	{
		$('#'+char).css('width','100%');
		$('#'+char).parent().removeClass('success');
	}
	
	function setRandom(char)
	{
		$('#'+char).css('width',Math.floor((Math.random()*60)+1)+'%');
	}
	
	function createDiv(letter)
	{
		$('#list').append('<div class="row card" style="padding:25px;padding-bottom:16px;margin-bottom:30px;"> <div class="large-3 columns" style="padding-top:5px;"> Word Starting with Letter `'+letter.toUpperCase()+'` : </div> <div class="large-9 columns"> <div class="progress success radius "> <span class="meter" id="'+letter+'" style="width:0%"></span> </div> </div> </div>');
	}
});