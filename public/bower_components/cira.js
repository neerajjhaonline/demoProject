      function upperCaseF(a){
          setTimeout(function(){
              a.value = a.value.toUpperCase();
          }, 1);
      }

      $(document).on('click','.abc',function (){
        $(this).preventDefault();
        var target_url = $(this).attr('href');
        var target = 'windowFormTarget';
        //$(this).closest("form").attr('target', target);
        window.open(target_url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");

      });

     $(document).ready(function(){

    
        if($("#markError").is(':checked'))
          $("#correctionBlock").css('display','block');
       
           

      $.ajaxSetup({
          headers: {
              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          }
      });

            $('.datepicker').datepicker({
              autoclose: true,
              format:'dd-mm-yyyy'
            });

            $('.date').datetimepicker({
              language: 'en',
              pick12HourFormat: true
            });

    });
     
    $(document).on('click','.delete_po',function(index,value){
        var url = $(this).attr('data-url');
        $('#confirm').attr('action',url);
    });


    

     $("#markError").on('click',function(){
        if($(this).is(':checked'))
          $("#correctionBlock").css('display','block');
        else
          $("#correctionBlock").css('display','none');
     });

       
    $("#generateNumber").on('click',function(e){
        e.preventDefault();
       
        var date = $('#mail_received_dt').val();
        var url = $('#mail_received_dt').attr('data-url');
        var id = $('#requestNumberID').val();
       // alert(id);
        //var csrf_token =  $('[name="csrf-token"]').attr('content');
        //alert(url);
        $.ajax({
            method: 'post',
            url: url,
            dataType: 'json',
            data: {date:date,id:id},
            success: function(msg) {
                var value = eval(msg);
               // alert(msg);
                if(value.reqNum){
                   // alert(value.reqNum);
                    $('#request_no').val(value.reqNum);
                }
            },
            beforeSend: function(){
                //$('.loader').show();
            },
            complete: function(){
                //$('.loader').hide();
            }
        });
    });

//ctrl+s open new indexing create form
  $(document).keydown(function(e) {
        
      if(event.ctrlKey && e.which == 83){ //Ctrl+S event captured!
        e.preventDefault();
         window.location.href = 'indexing/create';
         return false;
      }
    
});


       
    
