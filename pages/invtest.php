<?php 

session_start();
include'dbconnection.php';
include ("digtoval.php");
include("checklogin.php");

check_login();

if(isset($_GET['inv']))
{
$val=$_GET['inv'];
$invdata=mysqli_query($con,"SELECT invtest2.invid, invtest2.orderid,client.c_name,client.c_add,client.mob,client.gst,client.c_type, client.country,invtest2.created, invtest2.subtotal,invtest2.taxrate,invtest2.taxamount,invtest2.totalamount FROM `invtest2`join client where invtest2.cid=client.cid and invtest2.invid='$val'") or die("Error: " . mysqli_error($con));


$dv=mysqli_query($con,"select * from delivery_addresses where invid='$val'");

$no=mysqli_num_rows($dv);
if($no == NULL)
  {
    $delivery_addresses=0;
  }else{
    $delivery_addresses=1;
while($rv=mysqli_fetch_array($dv))
{
  $dname=$rv['name'];
  $dadd=$rv['address'];
  $dmob=$rv['mob'];
}
}

$items=mysqli_num_rows($invdata);

if($items == 0)
{
  $message="0 times Invoice not created";
}

$bankdata=mysqli_query($con,"select * from bankdetails");

while($bdata=mysqli_fetch_array($bankdata))
{
  $bankname=$bdata['bname'];
  $ac=$bdata['ac'];
  $ifsc=$bdata['ifsc'];
  $branch=$bdata['branch'];
}

  while($row=mysqli_fetch_array($invdata))
{

$invid=$row['invid'];
$orderid=$row['orderid'];
$cname=$row['c_name'];
$cadd=$row['c_add'];
$mob=$row['mob'];
$gst=$row['gst'];

//echo $gst;

$country=$row['country'];
$c_type=$row['c_type'];
$created=$row['created'];
$subtotal=$row['subtotal'];
$taxrate=$row['taxrate'];
$taxamount=$row['taxamount'];
$totalamount=$row['totalamount'];

}
echo "<script>
         setTimeout(function(){
            window.print();
         }, 4000);
      </script>";


?>


<html>
<head>
<title> Tax Invoice </title>
<?php include_once"links.php"; ?>

<style type="text/css">

body {
  background: rgb(204,204,204); 
}
page {

  background: white;
  display: block;
  margin: 10 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  padding-top: 26px;
}
page{  

  width: 25cm;
  height: 35cm;
}

@media print {
  body, page {
    margin: 0;
    box-shadow: 0;

  }
}


  *[contenteditable] {
  border-radius: 0.25em;
  min-width: 1em;
  outline: 0;
  cursor: pointer;
}
*[contenteditable]:hover {
  background: #def;
  box-shadow: 0 0 1em 0.5em #def;
}
*[contenteditable]:focus {
  background: #def;
  box-shadow: 0 0 1em 0.5em #def;
}


.style1 {
  font-size: 16px;
  font-weight: bold;
}
.style2 {font-size: 16px}

td{
padding-left:2px;
}

#lr{
  border-left:1px solid black;border-right:1px solid black;
}
#br{
  border-right:1px solid black;border-bottom:1px solid black;
}
#tr
{
   border-top:1px solid black; border-right:1px solid black;
}
img {
    image-rendering: -webkit-optimize-contrast !important;
  }
</style>

</head>
<?php

$admin=mysqli_query($con,"select * from admin");
while($adata=mysqli_fetch_array($admin))
{
  $pname=$adata['c_name'];
  $padd=$adata['c_add'];
  $pmob=$adata['mob'];
  $pgst=$adata['gst'];
  $ppan=$adata['pan'];
  $pmail=$adata['email'];

}
 ?>

<body>
<div id="loader"></div>
  <page size="A4">
<table width="816" height="1056" cellpadding="0" cellspacing="0" style="font-family:calibri;margin-top:10px;" align="center">
  <col width="31" />
  <col width="201" />
  <col width="61" />
  <col width="87" />
  <col width="72" />
  <col width="77" />
  <col width="57" />
  <col width="73" />

  
  
  <tr height="13">
    <td height="13" colspan="8" style="border:1px solid black;"><img src="letterpad/sticker Letter black Pad .png" height="200px" width="870px">  </td>
  </tr>
    <tr height="26">
  
    <td colspan="8" height="24" style="border:1px solid black;border-bottom:0px;font-size:20px"><div style="float: left"><b>&nbsp; GSTIN:&nbsp; <?php echo $pgst; ?> </b><strong style="font-size:24px; margin-left: 100px;">Tax Invoice</strong><b style="padding-left:120px;">&nbsp; IEC:&nbsp; <?php echo $ppan; ?> </b></div></td>
  </tr>    
  <tr height="13">
    <td height="13" colspan="8" style="border:1px solid black;">&nbsp;</td>
  </tr>

    <tr height="20">
    <td colspan="3" height="20" style="border:1px solid black;border-bottom:0px;">&nbsp; Buyer</td>
    <td colspan="2" id="tr">Invoice No.</td>
    <td colspan="3" id="tr">Dated</td>
  </tr>
  <tr height="20">
    <td colspan="3" height="20" id="lr">&nbsp; To,</td>
    <td colspan="2" id="br" contenteditable><b><?php echo $invid; ?></b></td>
    <td colspan="3" id="br"><b><?php  $c=date("d-M-Y",strtotime($created));
                                        echo $c; ?></b></td>
  </tr>
 
  <tr height="24">
    <td colspan="3" height="24" id="lr" >&nbsp; <strong style="font-size: 18px;">M/s. 
      <?php
                //$comp=$row['c_name'];
        echo $cname; ?></strong></td>
    <td colspan="2" style="border-right:1px solid black;">Buyer's Order No.</td>
    <td colspan="3" style="border-right:1px solid black;">Dated</td>
  </tr>


  <tr height="23" contenteditable>
    <td colspan="3" height="24" contenteditable id="lr" style="padding-left: 10px;"> 
      <?php 

       $x = 40;
$longString =$cadd;
$lines = explode("\n", wordwrap($longString, $x));

//echo count($lines);


for($num = 0; $num < count($lines); $num += 1){ 
    //echo  $lines[$num]. "\n <br>";

     $data[$num]=$lines[$num];
} 


for($num=0;$num<count($lines);$num++)
{
   $data[$num]."<br>";
}

if($data[0] != null)
{
  echo $data[0];
}



      ?></td>
    <td colspan="2" id="br">&nbsp;</td>
    <td colspan="3" id="br">&nbsp;</td>
  </tr>
  <tr height="23">
    <td colspan="3" height="24" id="lr" style="padding-left: 10px;" contenteditable><?php if(isset($data[1]) != null)
{
  echo $data[1];
} ?></td>
    <td colspan="2" style="border-right:1px solid black;">Dispatch through</td>
    <td colspan="3" style="border-right:1px solid black;">Mode/Terms of Payment</td>
  </tr>
  <tr height="23">
    <td colspan="3" height="24" id="lr" style="padding-left: 10px;" contenteditable><?php if(isset($data[2]) != null)
{
  echo $data[2];
} ?></td>
    <td colspan="2" id="br" contenteditable><strong></strong></td>
    <td colspan="3" id="br"  contenteditable><b>NEFT</b></td>
  </tr>
  <tr style="border-left:1px solid black; border-bottom: 0px;" contenteditable>
   <td colspan="3" id="lr" style="padding-left: 10px;" contenteditable><?php if(isset($data[3]) != null)
{
  echo $data[3];
} ?></td> 
    <!-- <td colspan="2" id="lr" style="padding-left: 10px;" contenteditable><strong></strong></td> -->
    <?php if($delivery_addresses == 1){ ?>
    <td colspan="5" id="br" style="border: 0px; border-left:1px solid black;border-right: 1px solid black" contenteditable>Delivery Address</td>
    <?php }else { ?>
    <td colspan="5" id="br" style="border: 0px; border-left:1px solid black;border-right: 1px solid black" contenteditable>Terms of Delivery</td>
    <?php  }?>
  </tr>
  <tr height="23" contenteditable>
    <td colspan="3" height="23" id="lr"><strong>&nbsp; Mob    : <?php echo $mob; ?></strong></td>
    <td colspan="5" style="border-right:1px solid black;"><b><?php if($delivery_addresses==1){ echo "M/s.".$dname;} ?></b></td>
  </tr>

  <tr height="23" contenteditable>
    <td colspan="3" height="23" id="lr" contenteditable><strong>&nbsp;
      <?php
       if($country =="India")
       {
       if(strlen($gst)==10)
      {
        echo "Pan : ".$new=strtoupper($gst);
      }
      if (strlen($gst)==12) {
          echo "Adhaar : ".$new=strtoupper($gst);
      }
      if(strlen($gst)==15)
      {
     echo "GSTIN/UIN : ".$new=strtoupper($gst);
   } 
 }
  if ($country =="Nepal")
  {
    //echo "enter nepal";
    //echo rtrim($gst);
  //echo strlen($gst);

    if(strlen($gst)==15)
      {
     echo "Exim Code : ".$new=strtoupper($gst);
   }
    if(strlen($gst)==9)
      {
     echo "Nepal Pan : ".$new=strtoupper($gst);
   }
 }
   ?></strong></td>
    <td colspan="5" style="border-right:1px solid black;"><?php if($delivery_addresses == 1){ echo $dadd;} ?></td>
  </tr>
  <tr height="13">
    <td colspan="3" height="13" style="border:1px solid black;border-top:0px; "></td>
    <td height="15" colspan="5" id="br" contenteditable><b><?php if($delivery_addresses == 1){ echo "Mob: ".$dmob;} ?></b></td>
  </tr>
  <tr height="35">
    <td height="35" width="38" style="border:1px solid black;border-top:0px; "><div align="center"><strong>Sr. No.</strong></div></td>
    <td colspan="2" id="br"><div align="center"><strong>Description of Goods</strong></div></td>
    <td id="br"><div align="center"><strong>HSN/SAC</strong></div></td>
    <td width="114" id="br"><div align="center"><strong>Quantity</strong></div></td>
    <td width="94" id="br"><div align="center"><strong>Rate</strong></div></td>
    <td width="37" id="br"><div align="center"><strong>per</strong></div></td>
    <td width="102" id="br"><div align="center" ><strong>Amount</strong></div></td>
  </tr>
<?php 

$ord=mysqli_query($con,"select orderid from invtest2 where invid='$val'");

$ds=mysqli_fetch_array($ord);

$dsdata=$ds[0];

//echo $dsdata;

$cnt=0;
$cs=mysqli_query($con,"select * from invtest where orderid='$dsdata'");

$num=mysqli_num_rows($cs);

if(mysqli_num_rows($cs)==0)
{
  echo "invoice not created";
}
while($ro=mysqli_fetch_array($cs))
  {
$cnt++;
      if(strtok($ro['item_name']," ") == "Courier" or strtok($ro['item_name']," ") == "Wooden Packing" or strtok($ro['item_name']," ") == "Freight" or strtok($ro['item_name']," ") == "Packing")
      {
       
?>

 <tr height="21">
    <td height="25" id="lr"><div align="center" ><?php echo $cnt; ?></div></td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp; <?php echo $ro['item_name']; ?></td>
    <td style="border-right:1px solid black;"><div align="center" ><?php  ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php  ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php ?> </div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php 
    $f=$ro['total'];
    $newval= number_format($f,2); echo $newval;?></div></td>
  </tr>
<?php }
else{ ?>


  <tr height="21">
    <td height="25" id="lr"><div align="center" ><?php echo $cnt; ?></div></td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp; <?php echo $ro['item_name']; ?></td>
    <td style="border-right:1px solid black;"><div align="center" ><?php echo $ro['hsn']; ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php $q=number_format($ro['quantity'],2); echo $q; ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php $pvalue= number_format($ro['price'],2); echo $pvalue; ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"> No. </div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php 
    $f=$ro['total'];
    $newval= number_format($f,2); echo $newval;?></div></td>
  </tr>
<?php }?>

  <?php
  if($ro['item_desc'] != null){ ?>
  <tr height="15">
    <td height="15" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black; font-size:10pt;  padding-left: 15px;"> &nbsp; (<?php echo $ro['item_desc']; ?>)</td>
    <td style="border-right:1px solid black;"><div align="center" ></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
  </tr>
  
<?php } } ?>

<?php if($num > 1)
{?>
<tr height="18">
    <td height="10" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;"> &nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center" ></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php echo "------------------"; ?></div></td>
  </tr>
  <tr height="18">
    <td height="18" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;"> &nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center" ></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php echo number_format($subtotal,2); ?></div></td>
  </tr>
<?php } ?>

  <?php
  $list=0;
      if($num > 5)
      {
        $list = 2;
      }
      if($num == 5)
      {
        $list=4;
      }
      if($num == 4)
      {
        $list=3;
      }  
      if($num == 3)
      {
        $list=4;
      }
      if($num == 2 )
      {
        $list=7;
      }
      if($num == 1)
      {
        $list=9;
      }
      for($i=0;$i<$list;$i++)
      {

  ?>

  
  <tr height="21">
    <td height="21" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center" ></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
  </tr>
<?php } ?>

<?php 

if($c_type == 'IGST')
{
?>
  
  <tr height="22">
    <td height="22" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <em><strong> IGST&nbsp; (18 %)</strong></em></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center"><b><?php $newtax=number_format($taxamount,2); echo $newtax;  ?></b></div>
    <div align="center"></div></td>
  </tr>
<?php } ?>

<?php 

if($c_type == 'Loc')
{
?>
 <tr height="22">
    <td height="22" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <em><strong> CGST&nbsp; (9 %)</strong></em></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center"><?php $newtax=number_format($taxamount/2,2); echo $newtax; ?> </div>
      <div align="center"></div></td></tr>
  <tr height="20">
    <td height="20" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;"><span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><strong>SGST&nbsp; (9 %)</strong></em></span></td>

    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;"> <div align="center"><?php $newtax=number_format($taxamount/2,2); echo $newtax; ?> </div></td></tr> 
<?php } ?>

  <tr height="20">
    <td height="20" style="border:1px solid black;border-top:0px;">&nbsp;</td>
    <td colspan="2" id="br">&nbsp;</td>
    <td id="br">&nbsp;</td>
    <td id="br">&nbsp;</td>
    <td id="br">&nbsp;</td>
    <td id="br">&nbsp;</td>
    <td id="br"><div align="center"></div></td>
  </tr>

  <?php

  $value=mysqli_query($con,"SELECT sum(quantity) FROM `invtest` WHERE orderid='$orderid'
") or die("Error:".mysqli_error($con)); 

$df=mysqli_fetch_array($value);
//echo $df[0];
//$ef=$df[0];
  ?>
  <tr height="22">
    <td height="22" style="border:1px solid black;border-top:0px ">&nbsp;</td>
    <td colspan="2" id="br"> <div align="right" style="padding-right:4px;">
      <strong>Total</strong></div></td>
    <td id="br">&nbsp;</td>
    
    <td id="br"><div align="center"><?php $quantity= number_format($df[0],2); 
    echo $quantity;  ?></div></td>
    <td id="br">&nbsp;</td>
    <td id="br"><div align="center">No</div></td>
    <td id="br"><div align="center"><b><?php $totalval=number_format($totalamount,2);
    echo $totalval; ?></b></div></td>
  </tr>
  <tr height="22">
    <td colspan="7" height="22" style="border-left:1px solid black;">Amount Chargeable    (in words):</td>
    <td style="border-right:1px solid black;"><div align="center">E.&amp; O.E.</div></td>
  </tr>
  <tr height="27">
    <td colspan="8" height="27" style="border:1px solid black;border-top:0px;"><strong>Indian Rupees
      <?php $ds=digtoval($totalamount); echo $ds; ?>  Only</strong>&nbsp;</td>
  </tr>

<?php if($c_type == 'IGST')
{?>
  <tr height="20">
    <td colspan="3" rowspan="2" height="30" style="border:1px solid black;border-top:0px;"><div align="center">HSN /SAC</div></td>
    <td width="93" height="30" rowspan="2" id="br"><div align="center" style="padding-right:2px">Taxable Value</div></td>
    <td colspan="2" id="br">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; Integrated Tax</td>
    <td colspan="2" style="border-right:1px solid black;"><div align="center">Total&nbsp;</div></td>
  </tr>
  <tr height="15">
    <td height="20" id="br">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rate&nbsp;</td>
    <td height="20" id="br"><div align="center">Amount</div></td>
    <td height="20" colspan="3" id="br" ><div align="center">Amount</div></td>
  </tr>
  <tr height="29">
    <td colspan="3" height="29" style="border:1px solid black;border-top:0px;"><div align="center">8443</div></td>
    <td id="br"><div align="center"><?php echo number_format($subtotal,2);  ?></div></td>
    <td id="br"><div align="center">18%</div></td>
    <td id="br"><div align="center"><?php $tx=number_format($taxamount,2);
    echo $tx; ?></div></td>
    <td colspan="2" id="br"><div align="center"><?php $totalval=number_format($totalamount,2);
    echo $totalval; ?></div></td>
  </tr>
  <tr height="24">
    <td colspan="3" height="24" style="border:1px solid black;border-top:0px;"><div align="center"><strong>Total</strong></div></td>
    <td id="br"><div align="center"><strong><?php echo number_format($subtotal,2);  ?></strong></div></td>
    <td id="br"><div align="center"></div></td>
    <td id="br"><div align="center"><strong><?php echo $tx; ?></strong></div></td>
    <td colspan="2" id="br"><div align="center"><strong><?php echo $totalval; ?></strong></div></td>
  </tr>
<?php } ?>

<?php 
if($c_type == "Loc")
{
?>
<tr height="20">
    <td colspan="2" rowspan="2" height="45" style="border:1px solid black;border-top:0px;" ><div align="center">HSN /SAC</div></td>
    <td rowspan="2" width="115" style="border-right:1px solid black;border-bottom:1px solid black;"><div align="center">Taxable    Value</div></td>
    <td colspan="2" style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Central Tax</div></td>
    <td colspan="2" style="border-bottom:1px solid black;border-right:1px solid black;"  ><div align="center">State Tax</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Total&nbsp;</div></td>
  </tr>

  <tr height="25">
    <td height="25" style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Rate</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Amount</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Rate</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Amount</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Tax</div></td>
  </tr>
  <tr height="25">
    <td colspan="2" height="25" style="border:1px solid black; border-top:0px; " ><div align="center">8443</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center"><?php echo number_format($subtotal,2); ?></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">9.00%</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center"><?php echo number_format($taxamount/2,2); ?></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">9.00%</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center"><?php echo number_format($taxamount/2,2); ?></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">
      <p><?php echo number_format($taxamount,2); ?></p>
      </div></td>
  </tr>
  <tr height="24">
    <td colspan="2" height="24" style="border:1px solid black;border-top:0px;"  >
    <div align="center"><strong>Total</strong></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" >
    <div align="center"><strong><?php echo number_format($subtotal,2); ?></strong></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center"></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;width: 83px;" >
    <div align="center" ><strong><?php echo number_format($taxamount/2,2); ?></strong></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center"></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;width: 83px;" ><div align="center"><strong><?php echo number_format($taxamount/2,2); ?></strong></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center"><strong><?php echo number_format($taxamount,2); ?></strong></div></td>
  </tr>
  <tr height="34">
    <td colspan="8" height="27" style="border:1px solid black;border-top:0px;"><strong>Tax Amount (in words) :&nbsp; Indian Rupees 
     <?php  $d=digtoval($taxamount/2); echo $d; ?> Only&nbsp;</strong></td>
  </tr>
<?php } ?>

<?php 
if($c_type == "IGST")
{
?>

  <tr height="34">
    <td colspan="8" height="27" style="border:1px solid black;border-top:0px;"><strong>Tax Amount (in words) :&nbsp; Indian Rupees 
     <?php  $d=digtoval($taxamount); echo $d; ?> Only&nbsp;</strong></td>
  </tr>
<?php } ?>
   <tr height="15">
    <td colspan="8" height="20" id="lr">&nbsp;</td>
  </tr>
   <tr height="20">
    <td colspan="8" height="20" id="lr">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bank Details </td>
  </tr>
   <tr height="20">
    <td colspan="8" height="20" id="lr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bank Name: <?php echo $bankname; ?></td>
  </tr>
  
  
  <tr height="19">
    <td colspan="8" height="19" id="lr">Proprietorship's PAN&nbsp; :   <?php echo $ppan; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A/C No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp; <?php 
    echo $ac; ?></td>
  </tr>
  <tr height="20">
    <td colspan="8" height="20" id="lr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Branch &amp;&nbsp; IFSC Code :&nbsp;<?php echo $branch; ?> &amp; <?php echo $ifsc; ?></td>
  </tr>
  <tr height="20">
    <td colspan="8" height="20" id="lr"><u>Declaration&nbsp;&nbsp;</u></td>
  </tr>
  
  <tr height="24">
    <td height="24" colspan="4" style="border-left:1px solid black;">We    declare that this invoice shows the actual price of the&nbsp;</td>
    <td colspan="4" style="border:1px solid black;border-bottom:0px;"><div align="right" style="padding-right:10px;"><strong>for <?php echo $pname; ?></strong></div></td>
  </tr>
  <tr height="29">
    <td height="29" colspan="3" style="border-left:1px solid black;">goods described and that all particulars are true and correct.</td>
    <td>&nbsp;</td>
    <td colspan="4" id="lr"><div align="right"></div></td>
  </tr>
  <tr height="19">
    <td height="19" colspan="4" style="border-left:1px solid black; border-bottom:1px solid black;" >&nbsp;</td>
    <td colspan="4" style="border:1px solid black;border-top: 0px; padding-right:10px; "><div align="right">Authorised    Signatory</div></td>
  </tr>
  <tr height="5">
    <td colspan="8" height="5"><div align="center"></div></td>
  </tr>
  <tr height="20">
    <td height="20" colspan="8"><div align="center">This is a Computer    Generated Invoice</div></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td width="217"></td>
    <td width="101"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
</page>

</body>
</html>
<?php 
}
else{
  echo "Invoice Not Generated";
}
?>