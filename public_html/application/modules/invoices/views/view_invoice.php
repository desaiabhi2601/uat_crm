<!-- <table cellspacing="0" cellpadding="5">
  <tr>
    <td width="60%" align="center">
      <img src="<?php echo site_url('assets/media/client-logos/logo.png')?>" width="200" height="60">
      <div style="font-size: 16px; font-weight: bold">OM TUBES & FITTINGS INDUSTRIES</div>
      <div style="font-size: 8px; color: #c2c2c2; text-align: left">10 Bordi Bunglow, 1st Panjarapole Lane, CP Tank, Mumbai, Maharashtra, India | GSTIN 27AFRPM5323E1ZC </div>
    </td>
    <td width="40%">
      <table>
        <tr>
          <td colspan="2" align="right" style="font-weight: 18px;">INVOICE</td>
        </tr>
        <tr style="background-color: #c6c2c2;">
          <td width="50%">&nbsp;&nbsp;Invoice:</td>
          <td width="50%">Date:</td>
        </tr>
        <tr>
          <td width="50%"><?php echo $invoice_details[0]['invoice_no']; ?></td>
          <td width="50%"><?php echo date('d M Y', strtotime($invoice_details[0]['invoice_date'])); ?></td>
        </tr>
        <tr style="background-color: #c6c2c2;">
          <td colspan="2">&nbsp;&nbsp;Customer: </td>
        </tr>
        <tr>
          <td colspan="2"><b><?php echo $invoice_details[0]['client_name']; ?></b><br/>
            <?php echo $invoice_details[0]['country']; ?><br/>
            Email: <?php echo $invoice_details[0]['email']; ?><br/>Phone: <?php echo $invoice_details[0]['mobile']; ?><br/>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="3"><table cellpadding="5" cellspacing="0" border="1px" class="inner_table">
        <tr style="background-color: #454889; color: #fff;">
          <th width="5%" align="center">#</th>
          <th width="33%" align="center">Description</th>
          <th width="13%" align="center">Product</th>
          <th width="13%" align="center">Material</th>
          <th width="12%" align="center">Quantity</th>
          <th width="12%" align="center">Rate</th>
          <th width="12%" align="center">Total</th>
        </tr>
        <?php 
          $i=0;
          foreach ($invoice_details as $key => $value) { 
            $bg_color = '';
            if($i%2 != 0){
              $bg_color = '#9c9ebc';
            }
        ?>
        <tr style="background-color: <?php echo $bg_color; ?>">
          <td align="right"><?php echo ++$i; ?></td>
          <td><?php echo $value['description']; ?></td>
          <td><?php echo $value['product']; ?></td>
          <td><?php echo $value['material']; ?></td>
          <td align="right"><?php echo $value['quantity']; ?></td>
          <td align="right"><?php echo $value['rate']; ?></td>
          <td align="right"><?php echo $value['price']; ?></td>
        </tr>
        <?php
            } 
        ?>
        <tr>
          <td colspan="3" rowspan="3">
            <table border="1" cellpadding="3">
              <tr>
                <td style="background-color: #454889" align="center">Remakrs</td>
              </tr>
              <tr>
                <td><?php echo $invoice_details[0]['remarks']; ?></td>
              </tr>
            </table>
          </td>
          <td colspan="3" align="right">Net Total</td>
          <td align="right"><?php echo $invoice_details[0]['net_total']; ?></td>
        </tr>
        <tr>
          <td colspan="3" align="right">Discount</td>
          <td align="right"><?php echo $invoice_details[0]['discount']; ?></td>
        </tr>
        <tr>
          <td colspan="3" align="right">Freight Charges</td>
          <td align="right"><?php echo $invoice_details[0]['freight_charge']; ?></td>
        </tr>
        <tr>
          <td colspan="3" rowspan="2">Mode: <?php echo $invoice_details[0]['mode']; ?></td>
          <td colspan="3" align="right">Other Charge</td>
          <td align="right"><?php echo $invoice_details[0]['other_charge']; ?></td>
        </tr>
        <tr>
          <td colspan="3" align="right">Grand Total</td>
          <td align="right"><?php echo $invoice_details[0]['grand_total']; ?></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td colspan="3" align="center" style="font-weight: bold">THANK YOU FOR YOUR BUSINESS!</td>
  </tr>
  <tr style="border-bottom: 1px solid">
    <td colspan="3" align="center">Should you have any queries concerning this offer, please contact Sanjay Mehta on sales@omtubes.com</td>
  </tr>
  <tr>
    <td colspan="3" align="center">10, Bordi Bunglow, 1st Panjarapole Lane, CP Tank, Mumbai 400004 - GSTIN 27AFRPM5323E1ZC<br/>Tel: +91 22 6743 6963 E-mail: sales@omtubes.com Web: www.omtubes.com</td>
  </tr>
</table> -->
<table>
  <tr>
    <td width="50%">
      <img src="<?php echo site_url('assets/media/client-logos/logo.png')?>" width="150" height="40" margin-left="25px;"><br/>
      <b>OM TUBES & FITTINGS INDUSTRIES</b>
    </td>
    <td width="50%"></td>
  </tr>
</table>