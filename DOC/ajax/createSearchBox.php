<?php
	echo '<table class="roundedTable" style="background-color:lightblue">
			<tr>
				<td colspan=2>
					<h3 style="text-align:center">Search Service Requests</h3>
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					First Name:
				</td>
				<td>
					<input id="firstName" style="width:98%" type="text" name="firstName">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Last Name:
				</td>
				<td>
					<input id="lastName" style="width:98%" type="text" name="lastName">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Address:
				</td>
				<td>
					<input id="address" style="width:98%" type="text" name="address">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Phone Number:
				</td>
				<td>
					<input id="phoneNumber" style="width:98%" type="text" name="phoneNumber">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					E-mail:
				</td>
				<td>
					<input id="email" style="width:98%" type="text" name="email">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Computer Model:
				</td>
				<td>
					<input id="computerModel" style="width:98%" type="text" name="computerModel">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Service Requested:
				</td>
				<td>
					<input id="serviceRequested" style="width:98%" type="text" name="serviceRequested">
				</td>
			</tr>
			<tr>
				<td colspan=2 style="text-align:center">
					List Extra Parts: <br/><textarea id="extraParts" name="extraParts" rows=4></textArea>
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Creation on/after:
				</td>
				<td>
					<input type="text" style="width:98%" id="creationDate" name="requestTime">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Status:
				</td>
				<td>
					<select name="status" id="status">
						<option value="">
							All
						</option>
						<option value="0">
							New
						</option>
						<option value="1">
							Open
						</option>
						<option value="2">
							Complete
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<button id="search" class="greyButton" style="width:100%">Search!</button>
				</td>
			</tr>
		</table>';
?>