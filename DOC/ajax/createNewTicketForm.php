<?php
	echo '<table class="roundedTable" style="background-color:lightblue">
	<tr>
		<td colspan=2>
			<h3 style="text-align:center">New Service Request</h3>
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			First Name:
		</td>
		<td>
			<input style="width:98%" type="text" id="nfirstName">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Last Name:
		</td>
		<td>
			<input style="width:98%" type="text" id="nlastName">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Address:
		</td>
		<td>
			<input style="width:98%" type="text" id="naddress">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Phone Number:
		</td>
		<td>
			<input style="width:98%" type="text" id="nphoneNumber">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			E-mail:
		</td>
		<td>
			<input style="width:98%" type="text" id="nemail">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Computer Model:
		</td>
		<td>
			<input style="width:98%" type="text" id="ncomputerModel">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Service Requested:
		</td>
		<td>
			<input style="width:98%" type="text" maxlength="100" id="nserviceRequested">
		</td>
	</tr>
	<tr>
		<td colspan=2 style="text-align:center">
			List Extra Parts: <br/><textarea id="nextraParts" maxlength="100" rows=4>[none]</textArea>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<button class="greyButton" id="newTicket" style="width:100%">Submit Request</button>
		</td>
	</tr>
	</form>
</table>';
?>