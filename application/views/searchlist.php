

<table cellspacing="0" cellpadding="0" border="0">
			<tr>
			<th>Username</th><th>Fullname</th>
			</tr>
			<?php
			if($search!=null)
			{
				foreach ($search as $value)
			 {
			
							
			?>
			<tr>
				<td><?php echo $value['username'] ?></td>
				<td><?php echo $value['fullname'] ?></td>
					
			</tr>			
			<?php
			
			}
		}
			?>
		</table>
	</form>