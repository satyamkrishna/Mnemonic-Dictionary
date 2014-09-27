<div class="row" style="margin-bottom:40px;">
	<div class="large-12 small-11 small-centered columns card" style="padding-bottom:10px;margin-top:40px;">
		<div class="pagination-centered" style="margin-top:20px">
			<ul class="pagination">
				<?php
				$unavail = '';
				if($page == 1 )
				{
					echo '<li class="arrow unavailable"><a href="#">&laquo;</a></li>';
				}
				else
				{
					echo '<li class="arrow"><a href="'.$file_name.'?start='.$start.'&page='.($page-1).$high_for_pagination.'">&laquo;</a></li>';
				}
				if($no_of_pages<=12)
				{
					for($i=1;$i<=$no_of_pages;$i++)
					{
						$current = '';
						if($i == $page)
						{
							$current = 'class="current"';
						}
						echo '<li '.$current.'><a href="'.$file_name.'?start='.$start.'&page='.$i.$high_for_pagination.'">'.$i.'</a></li>';
					}	
				}
				else
				{
					if($page<=6)
					{
						for($i=1;$i<=8;$i++)
						{
							$current = '';
							if($i == $page)
							{
								$current = 'class="current"';
							}
							echo '<li '.$current.'><a href="'.$file_name.'?start='.$start.'&page='.$i.$high_for_pagination.'">'.$i.'</a></li>';
						}	
						echo ' <li class="unavailable"><a href="">&hellip;</a></li>';
						for($i=$no_of_pages-1;$i<=$no_of_pages;$i++)
						{
							echo '<li><a href="'.$file_name.'?start='.$start.'&page='.$i.$high_for_pagination.'">'.$i.'</a></li>';
						}	
					}	
					else if($page > ($no_of_pages - 7))
					{
						for($i=1;$i<=2;$i++)
						{
							echo '<li><a href="'.$file_name.'?start='.$start.'&page='.$i.$high_for_pagination.'">'.$i.'</a></li>';
						}	
						echo ' <li class="unavailable"><a href="">&hellip;</a></li>';
						for($i=$no_of_pages-8;$i<=$no_of_pages;$i++)
						{
							$current = '';
							if($i == $page)
							{
								$current = 'class="current"';
							}
							echo '<li '.$current.'><a href="'.$file_name.'?start='.$start.'&page='.$i.$high_for_pagination.'">'.$i.'</a></li>';
						}	
					}
					else
					{
						for($i=1;$i<=2;$i++)
						{
							echo '<li><a href="'.$file_name.'?start='.$start.'&page='.$i.$high_for_pagination.'">'.$i.'</a></li>';
						}	
						echo ' <li class="unavailable"><a href="">&hellip;</a></li>';
						for($i=$page-3;$i<=$page+3;$i++)
						{
							$current = '';
							if($i == $page)
							{
								$current = 'class="current"';
							}
							echo '<li '.$current.'><a href="'.$file_name.'?start='.$start.'&page='.$i.$high_for_pagination.'">'.$i.'</a></li>';
						}
						echo ' <li class="unavailable"><a href="">&hellip;</a></li>';
						for($i=$no_of_pages-1;$i<=$no_of_pages;$i++)
						{
							echo '<li><a href="'.$file_name.'?start='.$start.'&page='.$i.$high_for_pagination.'">'.$i.'</a></li>';
						}
					}
				}
				if($page == $no_of_pages)
				{
					echo '<li class="arrow unavailable"><a href="#">&raquo;</a></li>';
				}
				else
				{
					echo '<li class="arrow"><a href="'.$file_name.'?start='.$start.'&page='.($page+1).$high_for_pagination.'">&raquo;</a></li>';
				}
				?>
			</ul>
		</div>
		<div class="pagination-centered"  style="margin-top:20px">
  			<ul class="pagination">
  				<?php
  				$filename = basename($_SERVER['REQUEST_URI']);
				$all_word = '';
				//if (strpos($filename,'ignore') !== false || strpos($filename,'fav') !== false || strpos($filename,'recent') !== false)
				if($start == 'all_word')
                {
                    $all_word = '<li class="current"><a href="'.$file_name.'?start=all_word'.$high_for_pagination.'">ALL</a></li>';
                }
                else
                {
                    $all_word = '<li><a href="'.$file_name.'?start=all_word'.$high_for_pagination.'">ALL</a></li>';
                }
                if (strpos($filename,'dashboard') !== false)
                {
                    if(!isset($_GET['high']))
                    {
                        $all_word = '';
                    }
                }

                $alphas = range('A', 'Z');
				foreach($alphas as $value)
  				{
					$current = '';
					if(strtolower($value) == $start)
					{
						$current = 'class="current"';
					}
  				?>
			    	<li <?php echo $current;?>><a href="<?php echo $file_name;?>?start=<?php echo strtolower($value).$high_for_pagination;?>"><?php echo $value; ?></a></li>
			    <?php
				}
				echo $all_word;
				?>
  			</ul>
		</div>
	</div>	
</div>
