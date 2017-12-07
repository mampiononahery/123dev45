<script type="text/javascript">
    $(function () {
        <?php if (isset($state) && $state != 'list' && $state != 'read' && $state != 'success') : ?>
        $('.datetime-input').datetimepicker('destroy'); // RESET DATETIMEPICKER
		
		$('.datepicker-input').datepicker('destroy');
		
		$('.datepicker-input').datepicker({
				dateFormat: js_date_format,
				showButtonPanel: true,
				changeMonth: true,
				changeYear: true,
				
				
				showOn: "button",
			  buttonImage: "https://greatermankato.com/sites/default/files/images/calendar.gif",
				
				yearRange: "-100:+0"
		});
		
        $('.datetime-input').datetimepicker({
            timeFormat: '  ',
            dateFormat: js_date_format,
            showButtonPanel: true,
			showTime:false,
            showSecond: false,
            changeMonth: true,
            changeYear: true,
            minDate: 0
        });
        <?php endif; ?>
        $("#text-layout1").on('click', function () {
            var content = $('textarea#field-message').val() + "" + $('#text-layout1').text();
            $("#field-message").val(content);
        });
        $("#text-layout2").on('click', function () {
            var content = $('textarea#field-message').val() + "" + $('#text-layout2').text();
            $("#field-message").val(content);
        });
    });
</script>
<div id="ajax-loader">
    <img width="60" src="<?php echo site_url('assets/frontend/design/icons/loader.gif') ?>" alt="loader" />
</div>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/marketing/request') ?>">Marketing</a></li>
    <li class="breadcrumb-item active">Campagne SMS</li>
</ol>
<?php if (isset($state) && $state != 'list' && $state != 'read' && $state != 'read') : ?>
    <p class="bg-yellow">Pour le texte de votre campagne, vous pouvez utiliser les textes suivants: <br />
        <strong id="text-layout1">%NOM%</strong> (pour d&eacute;signer le <strong>nom du client</strong>);
        <strong id="text-layout2">%PRENOM%</strong> (pour d&eacute;signer le <strong>pr&eacute;nom du client</strong>);<br />
        <strong>Cliquez</strong> sur le texte pour l'ajouter &agrave; l'&eacute;diteur.
    </p>
    <p class="bg-yellow">Message limit&eacute; &agrave; 140 caract&egrave;res</p>
    <div class="alerte alert-warning">
        <p>Attention, il n'est possible d'annuler une campagne sauf si la date d'envoi est diff&eacute;r&eacute;e.
            Pour annuler, vous devez notifier l'administrateur, car l'annulation n'est pas automatique.</p>                        
    </div>
<?php endif; ?>
<?php echo isset($output) ? $output : ''; ?>

<style>


 .sms_span {
    width: 80px;
    
	float:left;
    padding: 1px;
    border: 1px solid #89b089;
   color:#2f1f1f;
    text-align: center;
}
.c_bleu{

	color : #121df2;
}

.bleu{

	background-color : #121df2 ;
	
}
.rouge_c{

	background-color :#E71347;

}

.rose_c{

	background-color :#E713A1;

}

.class4{
	background-color : #E74713;


}
.class5{
	background-color :#E713BF;


}
.class6{
	

	background-color :#C68897;
}

.resume {
    width: 100%;
    height: 50px;
    margin-top: 10px;
    padding: 5px;
    background-color: white;
}

#style_nombre{
   position: initial !important;
	top:0px !important;
	left : 0px important;
	margin-left: 20px;
}
.nombre_phone {
	position: relative;
    top: -21px;
    left: 330px;
    font-weight: bold;
}
</style>


<script>
  $(document).ready(function(){
	var nombre_tel = 0;
	var nombre_sms = 1;
	var test_field_request_id = $("#field-request_id").val();

	function go_total_sms(request_id){
		var param = 
		{
			request_id: request_id
		
		};
		
		$.ajax({
					url: "<?php echo site_url('user/ajax/get_nombre_numero_par_requette') ?>",
					type: "post",
					data: param,
					success: function (reponse) {
						
						if(parseInt(reponse)>0){
						
							$(".nombre_phone").html(" "+reponse+" numéro(s) de téléphone unique(s)</span>");
						}
						else{
							
							$(".nombre_phone").html(" ");
						}
						nombre_tel = reponse;
						 $("#resume_total").html(nombre_sms*nombre_tel);
					},
					error: function () {
						alert("Erreur pendant le chargement...");
					}
				});
				
		
		
	}
	$("#field-request_id").on("change",function(){
		
		var param = 
		{
			request_id: $(this).val()
		
		};
		
		$.ajax({
					url: "<?php echo site_url('user/ajax/get_nombre_numero_par_requette') ?>",
					type: "post",
					data: param,
					success: function (reponse) {
						
						if(parseInt(reponse)>0){
						
							$(".nombre_phone").html(" "+reponse+" numéro(s) de téléphone unique(s)</span>");
						}
						else{
							
							$(".nombre_phone").html(" ");
						}
						nombre_tel = reponse;
						 $("#resume_total").html(nombre_sms*nombre_tel);
					},
					error: function () {
						alert("Erreur pendant le chargement...");
					}
				});
				
				
	
	});
	
	$("#field_request_id_chosen").append("<span class='nombre_phone'></span>");
	 
	 // $("#message_input_box").append("<div><span id='nombre_saisie'></span><span id='nombre_sms'></span></div>");
	  
	  $("#message_input_box").append("<div><span id='1sms' class='sms_span'>1 SMS</span><span id='2sms' class='sms_span'>2 SMS</span><span id='3sms' class='sms_span'>3 SMS</span><span id='4sms' class='sms_span'>4 SMS</span><span id='5sms' class='sms_span'>5 SMS</span> <span id='6sms' class='sms_span'>6 SMS</span></div>");
	 
	
	  var sate = "<?php echo $state ?>";
	  if(sate=="read")
	  {
		
		 $("#field-request_id").append("<span class='nombre_phone' id='style_nombre'></span>");
	  }
	 
	  function test_color_sms(){
		  
		  
		   var is_saisie = $("#message_input_box #field-message").html();
		  var longueur = is_saisie.length;
		  
		  
		
		  $("#nombre_saisie").html("Caractere(s) :"+longueur);
		  var page = longueur/160;
		   //var nombre_sms = parseInt(page)+1;
		  $("#nombre_sms").html(" SMS :"+nombre_sms+"/6");
		  var total = 160;
		  
		  if(longueur<=160)
		  {
			nombre_sms = 1;
			total = 160;
		  }
		  else if(longueur>160 && longueur<=306)
		  {
			nombre_sms = 2;
			total = 306;
		  }
		   else if(longueur>306 && longueur<=459)
		  {
			nombre_sms = 3;
			total = 459;
		  }
		   else if(longueur>459 && longueur<=612)
		  {
			nombre_sms = 4;
			total = 612;
		  }
		   else if(longueur>612 && longueur<=765)
		  {
			nombre_sms = 5;
			total = 765;
		  }
		  else
		  {
			total = 918;
			nombre_sms = 6;
		  }
		  $("#nombre").html(longueur);
		  $("#total").html(total);
		  
		
		
		  
		  if(nombre_sms==1){
			
			$("#1sms").addClass("bleu");
			$("#2sms").removeClass("rouge_c");
			$("#3sms").removeClass("rose_c");
			$("#4sms").removeClass("class4");
			$("#5sms").removeClass("class5");
			$("#6sms").removeClass("class6");
		  }
		  else if(nombre_sms==2){
			$("#1sms").removeClass("bleu");
			$("#3sms").removeClass("rose_c");
			$("#2sms").addClass("rouge_c");
			$("#4sms").removeClass("class4");
			$("#5sms").removeClass("class5");
			$("#6sms").removeClass("class6");
		  }
		  else if(nombre_sms==3){
			$("#4sms").removeClass("class4");
			$("#1sms").removeClass("bleu");
			$("#2sms").removeClass("rouge_c");
			$("#3sms").addClass("rose_c");
			$("#5sms").removeClass("class5");
			$("#6sms").removeClass("class6");
		  }
		  
		  else if(nombre_sms==4){
			$("#3sms").removeClass("rose_c");
			$("#1sms").removeClass("bleu");
			$("#5sms").removeClass("class5");
			$("#4sms").addClass("class4");
			$("#2sms").removeClass("rouge_c");
			$("#6sms").removeClass("class6");
		  }
		    
		  else if(nombre_sms==5){
			$("#4sms").removeClass("class4");
			$("#1sms").removeClass("bleu");
			$("#6sms").removeClass("class6");
			$("#5sms").addClass("class5");
			$("#2sms").removeClass("rouge_c");
			$("#3sms").removeClass("rose_c");
		  }
		  else{
		  $("#5sms").removeClass("class5");
			$("#4sms").removeClass("class4");
			$("#6sms").addClass("class6");
			$("#2sms").removeClass("rouge_c");
			$("#3sms").removeClass("rose_c");
			$("#1sms").removeClass("bleu");
		  
		  }
		  
		  $("#resume_total").html(nombre_sms*nombre_tel);
		  
		  
	  }
	  
	  $("#message_input_box").on("keyup",function(){
		  var is_saisie = $("textarea[name='message']").val();
		  var longueur = is_saisie.length;
		  $("#nombre_saisie").html("Caractere(s) :"+longueur);
		  var page = longueur/160;
		   //var nombre_sms = parseInt(page)+1;
		  $("#nombre_sms").html(" SMS :"+nombre_sms+"/6");
		  var total = 160;
		  
		  if(longueur<=160)
		  {
			nombre_sms = 1;
			total = 160;
		  }
		  else if(longueur>160 && longueur<=306)
		  {
			nombre_sms = 2;
			total = 306;
		  }
		   else if(longueur>306 && longueur<=459)
		  {
			nombre_sms = 3;
			total = 459;
		  }
		   else if(longueur>459 && longueur<=612)
		  {
			nombre_sms = 4;
			total = 612;
		  }
		   else if(longueur>612 && longueur<=765)
		  {
			nombre_sms = 5;
			total = 765;
		  }
		  else
		  {
			total = 918;
			nombre_sms = 6;
		  }
		  $("#nombre").html(longueur);
		  $("#total").html(total);
		  
		  //
		  
		  
		  
		  
		  if(nombre_sms==1){
			
			$("#1sms").addClass("bleu");
			$("#2sms").removeClass("rouge_c");
			$("#3sms").removeClass("rose_c");
			$("#4sms").removeClass("class4");
			$("#5sms").removeClass("class5");
			$("#6sms").removeClass("class6");
		  }
		  else if(nombre_sms==2){
			$("#1sms").removeClass("bleu");
			$("#3sms").removeClass("rose_c");
			$("#2sms").addClass("rouge_c");
			$("#4sms").removeClass("class4");
			$("#5sms").removeClass("class5");
			$("#6sms").removeClass("class6");
		  }
		  else if(nombre_sms==3){
			$("#4sms").removeClass("class4");
			$("#1sms").removeClass("bleu");
			$("#2sms").removeClass("rouge_c");
			$("#3sms").addClass("rose_c");
			$("#5sms").removeClass("class5");
			$("#6sms").removeClass("class6");
		  }
		  
		  else if(nombre_sms==4){
			$("#3sms").removeClass("rose_c");
			$("#1sms").removeClass("bleu");
			$("#5sms").removeClass("class5");
			$("#4sms").addClass("class4");
			$("#2sms").removeClass("rouge_c");
			$("#6sms").removeClass("class6");
		  }
		    
		  else if(nombre_sms==5){
			$("#4sms").removeClass("class4");
			$("#1sms").removeClass("bleu");
			$("#6sms").removeClass("class6");
			$("#5sms").addClass("class5");
			$("#2sms").removeClass("rouge_c");
			$("#3sms").removeClass("rose_c");
		  }
		  else{
		  $("#5sms").removeClass("class5");
			$("#4sms").removeClass("class4");
			$("#6sms").addClass("class6");
			$("#2sms").removeClass("rouge_c");
			$("#3sms").removeClass("rose_c");
			$("#1sms").removeClass("bleu");
		  
		  }
		  
		  $("#resume_total").html(nombre_sms*nombre_tel);
		  
		  
	  });
	  
	  var html_nombre = "<div><span>Caractères : </span><span> <span class='c_bleu' id='nombre'>0 </span>/ <span class='c_bleu' id='total'>160 </span></span></div>"
	  $("#message_display_as_box").append(html_nombre);
	  
	  
	  
	  var div_check = "<input type='radio' id='differe_ok' class='radio_select' name='test' value = '1' checked='checked'/> Differé au " ; 
//	  var div_check = "<input type='radio' class='radio_select' name='test' value = '1'/> Differé au " ; 
	  $("#sending_date_input_box").prepend(div_check);

	  
	  var div_check = "<input type='radio' id='differe_non' class='radio_select' name='test' value = '0' /> Immediate : " ; 
	  
	  // $("#sending_date_input_box").append(div_check);
	  
	   
	   
	   
	   
	   
	  var html_test = '<div class="form-field-box odd" id="sending_date_field_box"><div class="form-display-as-box" id="sending_date_display_as_box"> </div>'+'<div class="form-input-box" id="name_input_box">'+"<div><input type='radio' class='radio_select' id='differe_non' name='test' value = '0' /> Immediate</div></div> </div>";
	  
	  $(".form-div").append(html_test);
	   var html_test = '<div class="form-field-box odd" id="sending_date_field_box"><div class="form-display-as-box" id="sending_date_display_as_box">Testez votre campagne :</div>'+'<div class="form-input-box" id="name_input_box">'+"<div><input placeholder='Saisir ici votre mobile pour le test' id='numero_telephone' value='' class='numeric form-control'  type='text' style='width:150px !important;margin-right:10px !important;'><input id='envoyer_test' onClick='testcampagne()' value='Envoyer le test' class='btn btn-large' ></div></div> </div>";
	  
	  
	  
	  html_test = html_test + "<div class='resume'>Nombre total de SMS facturés pour cette campagne : <span id='resume_total'> 0 </span>  SMS</div>";
	  
	  $(".form-div").append(html_test);
	  
	  
	  
	  //$("#sending_date_field_box").append(html_test);
	  
	  
	  
	  $(".radio_select").on("change",function(){
		  
		  var val = $(this).val();
		  if(val=="0" || val==0){
			$("#field-sending_date").hide();
			$("#field_heure_chosen").hide();
			$(".datetime-input-clear").hide();
			//$("#sending_date_input_box").hide();
		  }
		  else{
			  $("#field-sending_date").show();
			  $("#field_heure_chosen").show();
			  $(".datetime-input-clear").show();
			  //$("#sending_date_input_box").show();
		  }
		  
		  
	  });
	  setTimeout(function(){
	  
		$("#field_heure_chosen").css("width","100px");
	  
	  },200);
	  function testcampagne(){
		
		  if($("#numero_telephone").val()!=""){
			  var param ={
				  sms_contact : $("#numero_telephone").val(),
				  sms_text :  $("textarea[name='message']").val(),
				  nb_sms : nombre_sms
				  
				  
			  };
			  $.ajax({
				  method:"POST",
				  url :"<?php echo site_url("user/ajax/sms_test_campagne")?>",
				  data : param,
				  success:function(reponse){
					  alert("SMS OK");
					  
				  }
				  
			  });
		 }
		 else{
			 alert("Veuillez saisir un numero");
		 }
		  
	  }
	  $("#envoyer_test").on("click",function(){
		  
		 if($("#numero_telephone").val()!=""){
			  var param ={
				  sms_contact : $("#numero_telephone").val(),
				  sms_text :  $("textarea[name='message']").val(),
				   nb_sms : nombre_sms
				  
				  
			  };
			  $.ajax({
				  method:"POST",
				  url :"<?php echo site_url("user/ajax/sms_test_campagne")?>",
				  data : param,
				  success:function(reponse){
					  alert("SMS OK");
					  
				  }
				  
			  });
		 }
		 else{
			 alert("Veuillez saisir un numero");
		 }
	  });
	  
	  if(sate=="read"){
			
			test_color_sms();
			console.log($("#field-sending_date").html());
			
			var html_t = $("#field-sending_date").html();
			
			if(html_t=="0000-00-00 00:00:00")
			{
				$("#differe_non").prop("checked",true);
				$("#differe_ok").prop("checked",false);
				$("#field-sending_date").hide();
			}
			else{
				$("#differe_non").prop("checked",false);
				$("#differe_ok").prop("checked",true);
				$("#field-sending_date").show();
			}
			
			
			go_total_sms("<?php echo !empty($request_id)? $request_id : 0 ; ?>");
	  }
	  else{
			if(sate!="list" && sate!="success"){
			  
			  
			test_color_sms();
			go_total_sms(test_field_request_id);
			
			console.log($("#field-sending_date").html());
			  
		  }
	  
	  }
  });
console.log("teeeee");
</script>