<div class="archives">
	
	<table style="width: 100%" cellpadding="5" cellspacing="5">
		<tr>
			<td>Send at</td>
			<td>Content</td>
		</tr>
		<?php 
		$data  = sentius_get_archive();
		if(count($data)>0){?>
			<?php foreach($data as $row){
					$timesent = date('d-m-Y h:i:s',$row->sendat);

					$node  = node_load($row->nid);
					$timeadd =  date('d-m-Y h:i:s',$node->created);
					$url  = url('node/'.$row->nid);
					$body = "A record <a href='".$url."'>".$node->title."</a> has been created at ".$timeadd."<br/>";
				?> 
				<tr>
					<td><?php echo $timesent ?></td>
					<td><?php echo $body ?></td>
				</tr>
			<?php }?>
		 <?php }?>
	</table>

</div>