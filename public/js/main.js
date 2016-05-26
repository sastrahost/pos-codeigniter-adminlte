(function($) {
    $(document).ready(function(){
        $("#kode_produk").on("keyup",function(e){
            e.preventDefault();
            var kode = $(this).val();
            var kode = kode.toUpperCase();
            $(this).val(kode);
            $.ajax({
                url: $("base").attr("url") + 'produk/check_id',
                data: {
                    'id' : kode
                },
                type: 'POST',
                success: function(data){
                    if(data == 'unavailable'){
                        $("#kode_produk").addClass("status-error");
                        $("#status_kode").text('Kode ID Tidak Tersedia, silahkan coba yang lain!');
                    }else{
                        $("#kode_produk").removeClass("status-error");
                        $("#status_kode").text('');
                    }
                },
                error: function(){
                    alert('Something Error');
                }
            });
        });
       $("#kode_kategori").on("keyup",function(e){
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
                       $("#kode_kategori").addClass("status-error");
                       $("#status_kode").text('Kode ID Tidak Tersedia, silahkan coba yang lain!');
                   }else{
                       $("#kode_kategori").removeClass("status-error");
                       $("#status_kode").text('');
                   }
               },
               error: function(){
                   alert('Something Error');
               }
           });
       });
        $("#kode_transaksi").on("keyup",function(e){
            e.preventDefault();
            var kode = $(this).val();
            var kode = kode.toUpperCase();
            $(this).val(kode);
            $.ajax({
                url: $("base").attr("url") + 'transaksi/check_id',
                data: {
                    'id' : kode
                },
                type: 'POST',
                success: function(data){
                    if(data == 'unavailable'){
                        $("#kode_produk").addClass("status-error");
                        $("#status_kode").text('Kode ID Tidak Tersedia, silahkan coba yang lain!');
                    }else{
                        $("#kode_produk").removeClass("status-error");
                        $("#status_kode").text('');
                    }
                },
                error: function(){
                    alert('Something Error');
                }
            });
        });
        $("#transaksi_category_id").on("change",function(e){
            e.preventDefault();
            var url =  $("base").attr("url") + 'transaksi/check_category_id/' + this.value;
            $.get(url, function(data, status){
                if(status == 'success'){
                    var arr = $.parseJSON(data);
                    $("#transaksi_product_id").text("");
                    $("#sale_price").text("");
                    $.each(arr, function(key,value){
                        var default_value = '';
                        if(key == 0){
                            var default_value = '<option value="0">Silahkan pilih produk</option>';
                        }
                        var opt_value = '<option value="'+value.id+'">'+value.product_name+'</option>';
                        $('#transaksi_product_id').append(default_value+opt_value);
                    });
                }
            });
        });
        $("#transaksi_product_id").on("change",function(e){
            e.preventDefault();
            var url =  $("base").attr("url") + 'transaksi/check_product_id/' + this.value;
            var type1 = '';
            var type2 = '';
            var type3 = '';
            $("#sale_price").text("");
            $.get(url, function(data, status) {
                if(status == 'success' && data != 'false') {
                    var value = $.parseJSON(data);
                    var val = value[0];
                    var sale_value = '<option value="' + val.sale_price + '">' + price(parseInt(val.sale_price)) + ' Default</option>';
                    if(val.sale_price_type1 != "0"){
                        var type1 = '<option value="' + val.sale_price_type1 + '">' + price(parseInt(val.sale_price_type1)) + ' Type 1 </option>';
                    }
                    if(val.sale_price_type2 != "0"){
                        var type2 = '<option value="' + val.sale_price_type2 + '">' + price(parseInt(val.sale_price_type2)) + ' Type 2</option>';
                    }
                    if(val.sale_price_type3 != "0") {
                        var type3 = '<option value="' + val.sale_price_type3 + '">' + price(parseInt(val.sale_price_type3)) + ' Type 3</option>';
                    }
                    $('#sale_price').append(sale_value+type1+type2+type3);
                }
            });
        });
    });
    $("#tambah-barang").on("click",function(e){
        e.preventDefault();
        
        var category_id = $("#transaksi_category_id").val();
        var product_id = $("#transaksi_product_id").val();
        var quantity = $("#jumlah").val();
        var sale_price = $("#sale_price").val();
        if(product_id.length > 0 && quantity > 0 && sale_price.length > 0){
            $.ajax({
                url: $("base").attr("url") + 'transaksi/add_item',
                data: {
                    'category_id' :category_id,
                    'product_id' : product_id,
                    'quantity' : quantity,
                    'sale_price' : sale_price
                },
                type: 'POST',
                success: function(data){
                    console.log(data);
                },
                error: function(){
                    alert('Something Error');
                }
            });
        }else{
            alert("Silahkan isi semua box");
        }
    });
})(this.jQuery);

function price(input){
    return (input).formatMoney(0, ',', '.');
}
Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
