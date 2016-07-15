<html>
<head>
    <meta charset="ISO-8859-1">
    <style>

        html, body {
            width: 24cm; /* was 907px */
            height: 14cm; /* was 529px */
            display: block;
            font-family: "Consolas";
            padding:10px;
            /*font-size: auto; NOT A VALID PROPERTY */
        }
        table{
            width:100%;
            display:inline;
        }
        .box-body{
            width:100%;
        }
        @media print {
            html, body {
                width: 24cm; /* was 8.5in */
                height: 14cm; /* was 5.5in */
                display: block;
                font-family: "Consolas";
                padding:10px;
                /*font-size: auto; NOT A VALID PROPERTY */
            }
            table{
                width:100%;
                display:inline;
            }

            @page {
                size: 24cm 14cm /* . Random dot? */;
            }
            .box-body{
                width:100%;
            }
        }
    </style>
</head>
<body>
    <div class="box-body">
        <table style="display:inline;">
            <thead>
                <tr>
                    <td style="width:500px;">Kepada Yth:</td>
                    <td style="width:200px;">Kode Transaksi</td>
                    <td style="width:200px;">: <?php echo $details[0]->id;?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $details[0]->customer_name;?></td>
                    <td>Tgl Pembelian</td>
                    <td>: <?php echo $details[0]->date;?></td>
                </tr>
                <tr>
                    <td><?php echo $details[0]->customer_address;?> </td>
                    <td valign="top">Pembayaran</td>
                    <td valign="top">: <?php echo $details[0]->is_cash == 1 ? "Cash" : "Credit";?></td>
                </tr>
                <tr>
                    <td>Phone: <?php echo $details[0]->customer_phone;?></td>
                    <td valign="top">Jatuh Tempo</td>
                    <td valign="top">: <?php echo $details[0]->is_cash == 1 ? "" : $details[0]->pay_deadline_date;?></td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <?php $line = "==================================================================================================================";?>
        <?php echo $line;?>
        <table>
            <thead>
            <tr>
                <td style="width:181px;">Name</td>
                <td style="width:178px;">Category</td>
                <td style="width:178px;">Quantity</td>
                <td style="width:178px;">Price/item</td>
                <td style="width:182px;text-align: right;">Subtotal</td>
            </tr>
            </thead>
        </table>
        <?php echo $line;?>
        <table>
            <thead  style="height:270px;">
            <?php if(isset($details) && is_array($details)){ ?>
                <?php foreach($details as $key => $transaksi){?>
                    <tr valign="top" style="height:10px;font-size:18px;">
                        <td style="width:181px;"><?php echo $transaksi->product_name;?></td>
                        <td style="width:178px;"><?php echo $transaksi->category_name;?></td>
                        <td style="width:178px;"><?php echo $transaksi->quantity;?></td>
                        <td style="width:178px;">Rp<?php echo number_format($transaksi->price_item);?></td>
                        <td style="width:182px;text-align: right;">Rp<?php echo number_format($transaksi->subtotal);?></td>
                    </tr>
                <?php } ?>
                <?php $total = 10 - ($key + 1);
                for($a =1; $a <= $total; $a++){ ?>
                    <tr>
                        <td style="width:181px;">&nbsp;</td>
                        <td style="width:178px;"></td>
                        <td style="width:178px;"></td>
                        <td style="width:178px;"></td>
                        <td style="width:182px;"></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </thead>
        </table>
        <?php echo $line;?>
        <table>
            <thead>
            <tr>
                <td style="width:181px;"></td>
                <td style="width:178px;"></td>
                <td style="width:178px;"></td>
                <td style="width:178px;">Total</td>
                <td style="width:182px;text-align: right;">Rp<?php echo number_format($transaksi->total_price);?></td>
            </tr>
            </thead>
        </table>
        <?php echo $line;?>
        <br />
        <table>
            <thead>
            <tr>
                <td style="width:180px;text-align: center;">Pembeli</td>
                <td style="width:180px;text-align: center;">Pengantar</td>
                <td style="width:180px;text-align: center;">Hormat Kami</td>
                <td style="width:350px;text-align: center;">**Terimakasih**</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td style="width:150px;text-align: center;">Penjual</td>
                <td style="width:342px;text-align: center;">Kami menjual segala</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="width:342px;text-align: center;">Macam alat rumah tangga</td>
            </tr>
            <tr>
                <td style="width:100px;text-align: center;">(.............)</td>
                <td style="width:120px;text-align: center;">(.............)</td>
                <td style="width:150px;text-align: center;">(.............)</td>
                <td style="width:342px;text-align: center;">dan elektronik</td>
            </tr>
            </tbody>
        </table>
    </div>
</body>
</html>