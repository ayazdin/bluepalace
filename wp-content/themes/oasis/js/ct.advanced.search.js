/**
 * Advanced Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

jQuery( document ).ready(function($) {
	if($('#advanced_search').length){
		$('#advanced_search #ct_country').on('change', function(){
			var data = new Object();
			data.action = 'country_ajax';
			data.country = $(this).val();
			var element=$(this);
			$.ajax({
				type:"post",
				url:ajax_link,
				dataType: 'json',
				data:data,
				beforeSend: function() { showProgress(element); },
				error: function(e) { alert( "error" ); hideProgress(); },
				success: function(ret, textStatus, XMLHttpRequest) {
					if(ret.success == true)
					{
						removeOtherValuesSelect('state','');
						removeOtherValuesSelect('city','');
						removeOtherValuesSelect('zipcode','');
						if(ret.state!='') addOtherValues('state',ret.state);
						if(ret.city!='') addOtherValues('city',ret.city);
						if(ret.zipcode!='') addOtherValues('zipcode',ret.zipcode);
						setSelectValue('city','0');
						setSelectValue('state','0');
						setSelectValue('zipcode','0');
					}
					hideProgress();
				}
			});
		});
		
		$('#advanced_search #ct_state').on('change', function(){
			var data = new Object();
			data.action = 'state_ajax';
			data.country = $('#advanced_search #ct_country').val();
			data.state = $(this).val();
			data.firstsearch = firstSearch('state');
			var element=$(this);
			$.ajax({
				type:"post",
				url:ajax_link,
				dataType: 'json',
				data:data,
				beforeSend: function() { showProgress(element); },
				error: function(e) { alert( "error" ); hideProgress(); },
				success: function(ret, textStatus, XMLHttpRequest) {
					if(ret.success == true)
					{
						if(data.firstsearch==true){
							setSelectValue('',first_el(ret.country));
							removeOtherValuesSelect('state',data.state);
							removeOtherValuesSelect('city','');
							removeOtherValuesSelect('zipcode','');
							if(ret.city!='') addOtherValues('city',ret.city);
							if(ret.zipcode!='') addOtherValues('zipcode',ret.zipcode);
							setSelectValue('city',first_el(ret.city));
							setSelectValue('zipcode',first_el(ret.zipcode));
						}
						else{
							removeOtherValues('city');
							removeOtherValues('zipcode');
							if(ret.city!='') addOtherValues('city',ret.city);
							if(ret.zipcode!='') addOtherValues('zipcode',ret.zipcode);
						}
					}
					hideProgress();
				}
			});
		});
		
		$('#advanced_search #ct_city').on('change', function(){
			var data = new Object();
			data.action = 'city_ajax';
			data.country = $('#advanced_search #ct_country').val();
			data.state = $('#advanced_search #ct_state').val();
			data.city = $(this).val();
			data.firstsearch = firstSearch('city');
			var element=$(this);
			$.ajax({
				type:"post",
				url:ajax_link,
				dataType: 'json',
				data:data,
				beforeSend: function() { showProgress(element); },
  			error: function(e) { alert( "error" ); hideProgress(); },
				success: function(ret, textStatus, XMLHttpRequest) {
			        if(ret.success == true)
					{
						if(data.firstsearch==true){
							setSelectValue('',first_el(ret.country));
							removeOtherValuesSelect('state','');
							removeOtherValuesSelect('city',data.city);
							removeOtherValuesSelect('zipcode','');
							if(ret.state!='') addOtherValues('state',ret.state);
							if(ret.zipcode!='') addOtherValues('zipcode',ret.zipcode);
							setSelectValue('state',first_el(ret.state));
							setSelectValue('zipcode',first_el(ret.zipcode));
						}
						else{
							removeOtherValues('zipcode');
							if(ret.zipcode!='') addOtherValues('zipcode',ret.zipcode);
						}
					}
					hideProgress();
			    }
			});
		});
		
		$('#advanced_search #ct_zipcode').on('change', function(){
			var search_f=firstSearch('zipcode');
			if(search_f==true){
				var data = new Object();
				data.action = 'zipcode_ajax';
				data.zipcode = $(this).val();
				data.firstsearch = search_f;
				var element=$(this);
				$.ajax({
					type:"post",
					url:ajax_link,
					dataType: 'json',
					data:data,
					beforeSend: function() { showProgress(element); },
					error: function(e) { alert( "error" ); hideProgress(); },
					success: function(ret, textStatus, XMLHttpRequest) {
				        if(ret.success == true)
						{
							setSelectValue('',first_el(ret.country));
							removeOtherValuesSelect('state','');
							removeOtherValuesSelect('city','');
							removeOtherValuesSelect('zipcode',data.zipcode);
							if(ret.state!='') addOtherValues('state',ret.state);
							if(ret.city!='') addOtherValues('city',ret.city);
							setSelectValue('state',first_el(ret.state));
							setSelectValue('city',first_el(ret.city));
						}
						hideProgress();
				    }
				});
			}
		});
	}
});

function first_el(obj) { for (var a in obj) return a; }
function removeOtherValues(select_id){
	$=jQuery;
	$('#ct_'+select_id).find('option').each(function(){
		if($(this).attr('value')!=0) $(this).remove();
	});
	$('#ct_'+select_id).val(0);
	$('#ct_'+select_id).next().find('.customSelectInner').html( $('#ct_'+select_id+' option').first().html() );
}
function removeAllValues(except){
	//if(except!="country") removeOtherValues('country');
	if(except!="state") removeOtherValues('state');
	if(except!="city") removeOtherValues('city');
	if(except!="zipcode") removeOtherValues('zipcode');
}
function removeOtherValuesSelect(element,value){
	$('#ct_'+element).find('option').each(function(){
		if(value!=""){ if($(this).attr('value')!=value && $(this).attr('value')!='0') $(this).remove(); }
		else{ if($(this).attr('value')!='0') $(this).remove(); }
	});
}
function addOtherValues(select_id,values){
	$=jQuery;
	for (var key in values) {
		$('#ct_'+select_id).append($('<option>', {
		    value: key,
		    text: values[key]
		}));
	}
}
function showProgress(element){
	$=jQuery;
	var position = $(element).position();
	$('.makeloading').css('left', (position.left+$(element).outerWidth(true)-50)+'px').css('top', (position.top+4)+'px').addClass('loadme muted');
}
function hideProgress(){ $=jQuery; $('.makeloading').removeClass('loadme'); }
function firstSearch(except){
	$=jQuery;
	var return_val=true;
	if(except!="country"){ if($("#ct_country").val()!="0"){ return_val=false;}}
	if(except!="state"){ if($("#ct_state").val()!="0"){ return_val=false;}}
	if(except!="city"){ if($("#ct_city").val()!="0"){ return_val=false;}}
	if(except!="zipcode"){ if($("#ct_zipcode").val()!="0"){ return_val=false;}}
	return return_val;
}
function setSelectValue(element,value){
	if(element=="") element='country';
	$("#ct_"+element).val(value);
	var html_text=$('#ct_'+element+' option:selected').text();
	$('#ct_'+element).next().find('.customSelectInner').html(html_text);
}