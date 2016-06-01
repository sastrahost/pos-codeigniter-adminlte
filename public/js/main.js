var $el = $("body");
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
            var origin = $(this).attr('data-origin');
            $(this).val(kode);
            if(origin !== kode) {
                $.ajax({
                    url: $("base").attr("url") + 'transaksi/check_id',
                    data: {
                        'id': kode
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data == 'unavailable') {
                            $("#kode_transaksi").addClass("status-error");
                            $("#kode_transaksi").attr("data-attr", "false");
                            $("#status_kode").text('Kode ID Tidak Tersedia, silahkan coba yang lain!');
                        } else {
                            $("#kode_transaksi").removeClass("status-error");
                            $("#kode_transaksi").attr("data-attr", "true");
                            $("#status_kode").text('');
                        }
                    },
                    error: function () {
                        alert('Something Error');
                    }
                });
            }
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

        var product_id = $("#transaksi_product_id").val();
        var quantity = $("#jumlah").val();
        var sale_price = $("#sale_price").val();
        if(product_id !== null && sale_price !== null){
            $.ajax({
                url: $("base").attr("url") + 'transaksi/add_item',
                data: {
                    'product_id' : product_id,
                    'quantity' : quantity,
                    'sale_price' : sale_price
                },
                type: 'POST',
                beforeSend : function(){
                    $el.faLoading();
                },
                success: function(data){
                    var res = $.parseJSON(data);
                    $(".cart-value").remove();
                    $.each(res.data, function(key,value) {
                        var display = '<tr class="cart-value" id="'+ key +'">' +
                                    '<td>'+ value.category_name +'</td>' +
                                    '<td>'+ value.name +'</td>' +
                                    '<td>'+ value.qty +'</td>' +
                                    '<td>Rp'+ price(value.subtotal) +'</td>' +
                                    '<td><span class="btn btn-danger btn-sm transaksi-delete-item" data-cart="'+ key +'">x</span></td>' +
                                    '</tr>';
                        $("#transaksi-item tr:last").after(display);
                    });
                    $("#total-pembelian").text('Rp'+price(res.total_price));
                    $el.faLoading(false);
                    console.log(res);
                },
                error: function(){
                    alert('Something Error');
                }
            });
        }else{
            alert("Silahkan isi semua box");
        }
    });
    $(document).on("click",".transaksi-delete-item",function(e){
        var rowid = $(this).attr("data-cart");
        $el.faLoading();
        $.get($("base").attr("url") + 'transaksi/delete_item/'+rowid,
            function(data,status){
                if(status == 'success'  && data != 'false'){
                    $("#"+rowid).remove();
                    console.log(data);
                    $("#total-pembelian").text('Rp'+data);
                    $el.faLoading(false);
                }                
            }
        );
    });
    $("#submit-transaksi").on('click',function(e){
        e.preventDefault();
        var transaction_id = $("#kode_transaksi").val();
        var supplier_id = $("#supplier_id").val();
        var status_id = $("#kode_transaksi").attr("data-attr");
        if(typeof transaction_id !== undefined){
            var arr = {
                'transaction_id': transaction_id,
                'supplier_id': supplier_id
            };
        }

        // Penjualan
        var sales_id = $("#penjualan_id").val();
        var costumer_id = $("#costumer_id").val();
        var is_cash = $("#is_cash").val();
        if(typeof sales_id !== undefined){
            var arr = {
                'sales_id': sales_id,
                'costumer_id': costumer_id,
                'is_cash' : is_cash
            };
        }
        if((supplier_id !== '' && transaction_id !== '' && status_id != "false") ||
            (sales_id !== '' && costumer_id !== '' && is_cash !== '')) {
            $.ajax({
                url: $("#transaction-form").attr("action"),
                data: arr,
                type: 'POST',
                beforeSend: function () {
                    $el.faLoading();
                },
                success: function (data) {
                    var response = $.parseJSON(data);
                    $el.faLoading(false);
                    if(response.status == "ok"){
                        alert("sukses");
                        window.location.href = $("base").attr("url") + 'transaksi';
                    }else{
                        alert("Terjadi error di server, silahkan coba lagi");
                    }
                }
            });
        }else{
            alert("Silahkan periksa kode transaksi atau supplier anda!");
        }
    });
    $('#datepicker-transaksi').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
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
