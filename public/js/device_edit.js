let $siteDropDown = $('#site_id');
let $siteTextBox = $('#new_site_name');
let $locationDropDown = $('#location_id');
let $locationTextBox = $('#new_location_name');
let firstSelection = true;

/*Retrieves the locations connected to the site or converts the drop down menus to text boxes
 *when a new site is being created
 */
$siteDropDown.change(function () {
	if (firstSelection)
	{
		$("#site_id option[value='-1']").remove();
		firstSelection = false;
	}

	let site_id = $siteDropDown.val();

	//Check if the selected drop down element is the "Create new location" element
	if (site_id === '')
	{
		//Hide the drop downs and display the text boxes for both site and location
		$siteDropDown.hide();
		$siteTextBox.show();
		$locationDropDown.hide();
		$locationTextBox.show();
	}
	else
	{
		//If the drop down menu for the location is hidden then reveal it and hide the text box
		if ($locationTextBox.is(':visible'))
		{
			$locationTextBox.hide();
			$locationDropDown.show();
			$locationTextBox.val('');
		}

		//Use ajax to get the locations attached to the selected site
		$.ajax({
			type: 'GET',
			url: '/site/' + site_id + '/locations',
			data: '',
			success: function (data) {
				$locationDropDown.empty();
				let locations = data;
				let locationsString = "";

				//Add the locations to the drop-down
				for (let i = 0; i < Object.keys(data).length; i++)
				{
					locationsString += '<option value="' + locations[i]['id'] + '">' + locations[i]['name'] + '</option>';
				}
				locationsString += '<option value="">Create new location</option>';
				$locationDropDown.append(locationsString);
			}
		});
	}
});


//Change the location drop down to an input field if the "Create new location" element is selected
$locationDropDown.change(function () {
	let location_id = $locationDropDown.val();

	//If the selected drop down element is the "Create new location" element
	if (location_id === '')
	{
		$locationDropDown.hide();
		$locationTextBox.show();
	}
});