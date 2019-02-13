{{-- Mover a la vista en la seccion script  --}}
{!! Html::script('vendor/tinymce/tinymce.min.js') !!}

<script type="text/javascript">
             
  tinyMCE.baseURL = "{{ url('/'). "/vendor/tinymce"}}"
  tinymce.init({
	   selector: 'textarea#tinymce, textarea#tinymce2, textarea#tinymce3, textarea#tinymce4',
	   language : "es_MX",
	   plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
     toolbar : "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code",
     relative_urls : false,
	 	 remove_script_host : false,
     cleanup:false,
		 menubar: 'edit format table',
     skin: 'lightgray' 
	});
      
</script>