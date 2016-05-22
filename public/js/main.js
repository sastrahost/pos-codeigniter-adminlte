(function($) {
    $(document).ready(function(){
       $("#kode").on("keyup",function(e){
           e.preventDefault();
           var kode = $(this).val();
           var kode = kode.toUpperCase();
           $(this).val(kode);
           $.ajax({
               url: $("base").attr("url") + 'kategori/check_id',
               data: {
                   'id' : kode
               },
               type: 'POST',
               success: function(data){
                   if(data == 'unavailable'){
                       $("#kode").addClass("status-error");
                       $("#status_kode").text('Kode ID Tidak Tersedia, silahkan coba yang lain!');
                   }else{
                       $("#kode").removeClass("status-error");
                       $("#status_kode").text('');
                   }
               },
               error: function(){
                   alert('Something Error');
               }
           });
       })
    });
})(this.jQuery);
