<style>
    @media print {
        html, body {
            width: 5.5in; /* was 8.5in */
            height: 8.5in; /* was 5.5in */
            display: block;
            font-family: "Calibri";
            /*font-size: auto; NOT A VALID PROPERTY */
        }
        table{
            width:100%;
            display:inline;
        }

        @page {
            size: 5.5in 8.5in /* . Random dot? */;
        }
        .box-body{
            width:100%;
        }
    }
</style>
<html>
<body>
    <div class="box-body">
        <table style="display:inline;">
            <thead>
                <tr>
                    <td style="width:342px;">Kepada Yth:</td>
                    <td style="width:150px;">Kode Transaksi</td>
                    <td style="width:192px;">: <?php echo $details[0]->id;?></td>
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
        ===========================================================================
        <table>
            <thead>
            <tr>
                <td style="width:136px;">No</td>
                <td style="width:136px;">Category</td>
                <td style="width:136px;">Quantity</td>
                <td style="width:136px;">Price/item</td>
                <td style="width:136px;">Subtotal</td>
            </tr>
            </thead>
        </table>
        ===========================================================================
        <table>
            <thead>
            <?php if(isset($details) && is_array($details)){ ?>
                <?php foreach($details as $transaksi){?>
                    <tr>
                        <td style="width:136px;"><?php echo $transaksi->product_name;?></td>
                        <td style="width:136px;"><?php echo $transaksi->category_name;?></td>
                        <td style="width:136px;"><?php echo $transaksi->quantity;?></td>
                        <td style="width:136px;">Rp<?php echo number_format($transaksi->price_item);?></td>
                        <td style="width:136px;">Rp<?php echo number_format($transaksi->subtotal);?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </thead>
        </table>
        ===========================================================================
        <table>
            <thead>
            <tr>
                <td style="width:136px;"></td>
                <td style="width:136px;"></td>
                <td style="width:136px;"></td>
                <td style="width:136px;">Total</td>
                <td style="width:136px;">Rp<?php echo number_format($transaksi->total_price);?></td>
            </tr>
            </thead>
        </table>
        ===========================================================================
        <br />
        <table>
            <thead>
            <tr>
                <td style="width:100px;text-align: center;">Pembeli</td>
                <td style="width:120px;text-align: center;">Pengantar</td>
                <td style="width:150px;text-align: center;">Hormat Kami</td>
                <td style="width:342px;text-align: center;">**Terimakasih**</td>
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