

 $('#switch-change').on('switchChange.bootstrapSwitch', function (event, state) {
 	if(state==false){
 		$('.poll-time').data("DateTimePicker").disable();
 	}else{

 	}
 	
}); 

