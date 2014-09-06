<?php
require_once 'core.inc.php';
require_once 'dbhelper.inc.php';
require_once 'loggedin.php';
require_once 'pronunciation.inc.php';

function get_word($search) {
	$db = new dbHelper;
	$db -> ud_connectToDB();
	$fav = false;
	$wordObj = array();

	$result = $db -> ud_getQuery('SELECT * FROM word_list w WHERE w.word = \'' . $search . '\'');
	if ($db -> ud_getRowCountResult($result) > 0) 
	{
		$word = $db -> ud_mysql_fetch_assoc($result);
		$wordID = $word['wordID'];
		$result = $db -> ud_whereQuery('ud_user_fav', NULL, array('userID' => $_SESSION['userID'], 'wordID' => $wordID));
		if ($db -> ud_getRowCountResult($result) > 0) {
			$fav = true;
		}
		$result = $db -> ud_whereQuery('mnemonics_word_list', NULL, array('wordID' => $wordID));
		$mnemonics = $db -> ud_mysql_fetch_assoc_all($result);
		$mnemonics_arr = array();
		for ($i = 0; $i < sizeof($mnemonics); $i++) {
			$mnemonics_arr[$i] = $mnemonics[$i];
		}

		$result = $db -> ud_whereQuery('definition_word_list', NULL, array('wordID' => $wordID));
		$defintion = $db -> ud_mysql_fetch_assoc_all($result);
		$defintion_arr = array();

		for ($i = 0; $i < sizeof($defintion); $i++) {
			$result = $db -> ud_whereQuery('synonym_word_list', NULL, array('definitionID' => $defintion[$i]['definitionID']));
			$synonym = $db -> ud_mysql_fetch_assoc_all($result);
			$synonym_arr = array();

			for ($j = 0; $j < sizeof($synonym); $j++) {
				$synonym_arr[$j] = $synonym[$j]['synonym'];
			}

			$result = $db -> ud_whereQuery('sentence_word_list', NULL, array('definitionID' => $defintion[$i]['definitionID']));
			$sent = $db -> ud_mysql_fetch_assoc_all($result);
			$sent_arr = array();

			for ($j = 0; $j < sizeof($sent); $j++) {
				$sent_arr[$j] = $sent[$j]['sentence'];
			}

			$defintion_arr[$i] = array('def' => $defintion[$i]['definition'], 'syn' => $synonym_arr, 'sent' => $sent_arr);
		}

		$wordObj['wordID'] = $word['wordID'];
		$wordObj['word'] = $word['word'];
		$wordObj['word_fav'] = $fav;
		$wordObj['definition_short'] = $word['definition_short'];
		$wordObj['mnemonics_arr'] = $mnemonics_arr;
		$wordObj['defintion_arr'] = $defintion_arr;

		echo word_card($wordObj);
	} else {
		echo word_not_found();
	}
}

function word_not_found() {
	require 'no_word_found.php';
}

function check_word($search) {
	$db = new dbHelper;
	$db -> ud_connectToDB();

	$result = $db -> ud_getQuery('SELECT * FROM word_list w WHERE w.word = \'' . $search . '\'');
	if ($db -> ud_getRowCountResult($result) > 0) {
		return true;
	} else {
		return false;
	}

}

function word_card($wordObj) {
	require 'card_template.php';
}
?>

<link rel="stylesheet" href="resources/css/frontend/card/card.css" />
<span id="dummy"></span>
<script type="text/javascript">
$(document).ready(function()
{
    $(document.body).on('click', ".speaker", function(e)
    {
        file_path = $(this).attr('id');
        playSound(file_path);
    });

    function playSound(soundfile)
    {
        var obj = document.createElement("audio");
        obj.setAttribute("src", soundfile);
        $.get();
        obj.play();
    }

    $(document.body).on('click', ".delete-mnemonic", function(e)
    {
        wordID = $(this).closest('.word_card').attr('id');
        mnemonicID  = $(this).attr('id');
        func = 'delete';
        li_div = $(this).closest('li');

        $.post('include/mnemonic_ajax.php',{func:func,wordID:wordID,data:mnemonicID},function(result)
        {
            if($.trim(result)=='Done')
            {
                li_div.hide();
            }
            else
            {
                alert('There was some error while deletion.Contact Administrator.');
            }
        });

    });
    $(document.body).on('click', ".add-mnemonic", function(e)
    {
        wordID = $(this).closest('.word_card').attr('id');
        mnemonic = $(this).closest('.row').find('.mnemonic-data');
        ul_div = $(this).closest('.mnemonics').find('.user-added');
        data = mnemonic.val();
        func = 'add';
        if(data.length >0)
        {
            $.post('include/mnemonic_ajax.php',{func:func,wordID:wordID,data:data},function(result)
            {
                if($.trim(result)=='Count Error')
                {
                    alert('Sorry you cannot add more than two nmenonics');
                }
                else if($.trim(result)=='Done')
                {
                    ul_div.append('<li>'+data+'</li>');
                    mnemonic.val('');
                }
            });
        }
    });

    $(document.body).on('click', ".star-select", function(e)
    {
        wordID = $(this).closest('.row').attr('id');
        $(this).attr('src', 'resources/img/common/star_unselect.png');
        $(this).removeClass('star-select');
        $(this).addClass('star-unselect');
        $.post('include/card_ajax.php', {
            func : 'select',
            wordID : wordID
        }, function() {
            var filename = getFileName();
            if(filename == 'ignore.php')
            {
                location.reload();
            }

        });
    });

    $(document.body).on('click', ".star-unselect", function(e)
    {
        wordID = $(this).closest('.row').attr('id');
        $(this).attr('src', 'resources/img/common/star_select.png');
        $(this).addClass('star-select');
        $(this).removeClass('star-unselect');
        $.post('include/card_ajax.php', {
            func : 'unselect',
            wordID : wordID
        }, function() {
            var filename = getFileName();
            if(filename != 'dashboard.php')
            {
                location.reload();
            }
        });
    });

    $(document.body).on('click', ".word_card", function(e)
    {
        var filename = getFileName();
        wordID = $(this).attr('id');
        $.post('include/card_ajax.php', {func : 'history',wordID : wordID}, function(){});
    });

    $(document.body).on('click', ".ignore", function(e)
    {
        word_div = $(this).closest('.row');
        wordID = word_div.attr('id');
        QueryString = get_param();

        my_form = document.createElement('FORM');
        my_form.name = 'myForm';
        my_form.method = 'POST';
        var filename = getFileName();
        if(QueryString.start == null)
        {
            if(filename=='dashboard.php')
            {
                QueryString.start = 'a';
            }
            else
            {
                QueryString.start = 'all_word';
            }
        }
        if(QueryString.page == null)
        {
            QueryString.page = '1';
        }
        my_form.action = filename + '?start='+QueryString.start+'&page=' + QueryString.page;
        //alert(my_form.action);
        my_tb = document.createElement('INPUT');
        my_tb.type = 'HIDDEN';
        my_tb.name = 'ignore';
        my_tb.value = wordID;
        my_form.appendChild(my_tb);
        document.body.appendChild(my_form);
        my_form.submit();
    });

    function get_param() {
        var QueryString = function() {
            // This function is anonymous, is executed immediately and
            // the return value is assigned to QueryString!
            var query_string = {};
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                // If first entry with this name
                if ( typeof query_string[pair[0]] === "undefined") {
                    query_string[pair[0]] = pair[1];
                    // If second entry with this name
                } else if ( typeof query_string[pair[0]] === "string") {
                    var arr = [query_string[pair[0]], pair[1]];
                    query_string[pair[0]] = arr;
                    // If third or later entry with this name
                } else {
                    query_string[pair[0]].push(pair[1]);
                }
            }
            return query_string;
        }();
        return QueryString;
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
});
</script>
