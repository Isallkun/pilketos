$(document).ready(function(){ 
  /*============*/
  /*====Pilih===*/
  /*============*/
  // Login
  $('#loading').hide();
  $('#btn-login').click(function(){
    var user = $('#username').val();
    var pass = $('#password').val();
    if (user === '' || pass === '') {
      swal("Oops...", "Username dan Password tidak boleh kosong!", "error");
    }else{
      var data = new FormData();
      data.append('username', $('#username').val());
      data.append('password', $('#password').val());
      data.append('type', 'login');

      $.ajax({
        url         : '/ajax/voting_siswa',
        type        : 'POST',
        data        : data,
        processData : false,
        contentType : false,
        dataType    : 'json',
        beforeSend  : function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success     : function(response){ 
        console.log(response.status);
          if(response.status == "ada"){ 
            document.location="";
          }else{ 
            swal("Oops...", response.status, "error");
            return false;
          }
        },
        error       : function (xhr, ajaxOptions, thrownError) {
          alert("ERROR : "+xhr.responseText); 
        }
      });
    }

  });

  // Proses Pilih
  $('#btn-pilih').click(function(){

    var data = new FormData();
    data.append('id_calon', $('#id-calon').val());
    data.append('type', 'pilih');
    $('#btn-pilih').attr("disabled", true);
    
    $.ajax({
      url         : 'ajax/voting_siswa',
      type        : 'POST',
      data        : data,
      processData : false,
      contentType : false,
      dataType    : 'json',
      beforeSend  : function(e) {
        if(e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success     : function(response){
      $('#btn-pilih').removeAttr("disabled");
      console.log(response.status);
        if(response.status == "sukses"){ 
          swal({
            title: "Good job!",
            text: "Terima Kasih",
            type:"success"
          }, 
          function(){
            document.location = '';
          });
        }else{ 
          swal("Oops...", "Ada yang Error!", "error");
          return false;
        }
      },
      error       : function (xhr, ajaxOptions, thrownError) {
        alert("ERROR : "+xhr.responseText); 
      }
    });

  });
});