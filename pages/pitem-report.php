<?php
session_start();
include'dbconnection.php';
include("checklogin.php");
 check_login();

 include 'inc/getState.php';

$current_page="purchase report";

$current_page1="purchase item report";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>


 <?php include_once "links.php"; ?>
 <link rel="stylesheet" href="script/daterangepicker/daterangepicker-bs3.css">

<script type="text/javascript" src="script/dataTables.export.js"></script> 

    <script src="script/daterangepicker/moment.min.js"></script>
    <script src="script/daterangepicker/daterangepicker.js"></script>

<!-- <script type="text/javascript" src="/script/script.js"></script> -->
<style type="text/css">
  .cancelBtn {
      background-color:#dc3545;
  }

  select {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    width: 100%;
    border: 1px solid #ccc;
    height: 34px;
  }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini <?php echo getState('fixed-layout') ? 'fixed ' : ''; ?>
    <?php echo getState('boxed-layout') ? 'layout-boxed ' : ''; ?>
    <?php echo getState('sidebar-collapse') ? 'sidebar-collapse ' : ''; ?>
    <?php echo getState('expand-on-hover') ? 'expandOnHover ' : ''; ?>
    <?php echo getState('control-sidebar-open') ? 'control-sidebar-open ' : ''; ?>
    <?php echo getState('sidebar-skin-toggle') ? 'sidebar-light ' : ''; ?>">

<div id="loader"></div>


<div class="wrapper">

  <?php include_once "header.php"; ?>
    
<?php include_once"navbar.php"; ?>


  <!-- Content Wrapper. Contains page content -->
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Purchase Item Report
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">      Purchase Item Report</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-info" style="overflow: auto;">
            <div class="box-header">
              <!-- <h3 class="box-title" style="padding-top: 10px;"> All Client Details</h3> -->
            </div>

<?php 


$cv2=mysqli_query($con,"select p_id,name from products where p_type='Machine' or p_type='Consumables'");
?>

    <form name="form" id="form" method="GET" action="">
    <div class="box-body report_header_form">
                  <!-- Date range -->
           <div class="row">  
           
            <div class="col-md-3">
              <div class="form-group">
                  <label>Select Item:</label>                    
                    
                      <select name="inv_items" id="inv_items" class="form-control select23" style="height: 35px !important;width:100% !important;" >
                          <option value=""></option>
                        <?php 
                          while($row2=mysqli_fetch_array($cv2))
                            { ?>
                          <option value="<?php echo $row2['name']; ?>"><?php echo $row2['name']; ?></option>
                         <?php   } ?>                             
                        </select>
                   <!-- /.input group -->                  
               </div>
            </div>            
             <div class="col-md-3">
               <div class="form-group">
                  <label>Date range:</label>                    
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
            <input type="text" class="form-control pull-left" id="daterange-btn" name="date_range" 
            value="<?php  //echo  $this->input->post('date_range'); 
            ?>">
                    </div><!-- /.input group -->                  
               </div><!-- /.form group -->
             </div>
             <div class="col-md-2">
              <div class="form-group">
                <label>&nbsp;</label>
              <input type="submit" name="dat_range" id="searchBtn" value="Search" class="btn btn-primary" style="margin-top:25px;" >
                </div>
             </div>
           </div><!-- /.row -->
     </div> <!-- box body--> 
     </form>
    
      
            <div class="row">
              <div class="col-md-12">
                <div class="box box-success">
                  <div class="box-header" style="text-align:center">
                  </br>
                      <h3 class="box-title" id="item"></h3>
                     
                      </br></br>
                      
                      <h4 id="date"> </h4>
                      </br>
                        <div id="hide">
                        <h3 class="box-title" id="company"></h3></br>
                        
                      <!--   <h3 class="box-title" id="stn"> STN:<?php echo $config->s_t_r_no; ?></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3 class="box-title" id="ntn">NTN:<?php echo $config->ntn_no; ?></h3> -->
                      </div>
                    </div>
                    <h3>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ' '." CodeTech Engineers";?></h3>
               <section class="content">
                  <div class="row">
                 <div class="col-xs-12">
                      <div class="box">
                        <div class="box-body">                                                 
                               <table id="example" class="table table-bordered table-striped">

                                     <thead>
                                        <tr>
                                            <th style="width: 300px;"> Sr no. </th>
                                            <th style="width: 800px;">Item Name</th>
                                            <th style="width: 400px;">Description</th>
                                            <th style="width: 400px;">HSN</th>
                                            <th style="width: 400px;">Base Amt</th>
                                            
                                            <th style="width: 100px;">Quantity</th>
                                            
                                            <th style="width: 300px;">Subtotal</th>
                                            <th style="width:100px;">Tax %</th>
                                            <th style="width: 300px;">Tax Amt</th>
                                            <th style="width: 300px;">Total Amt</th>
                                        </tr>
                                    </thead>

                                     <tbody>                                                                     
                  
                                     
                                         </tbody>
                                         <tfoot>
                                      <tr>
                                            <td> </td>
                                            <td><h3>Total </h3></td>
                                            <td></td>
                                            <td>&nbsp;</td>
                                                                              
                                            <td><h3 id="baseamt">0</h3></td>
                                           
                                            <td><h3 id="quantity">0</h3></td>
                                            <td><h3 id="subtotal">0</h3></td>
                                            <td></td>
                                            <td><h3 id="taxamt">0</h3><h3></h3></td>
                                            <td><h3 id="totalamt">0</h3></td>
                                    
                                    </tr>
                                        </tfoot>
                                 </table> 
                                   
                             </div>
                         </div>
                          <div  class="btn-group" data-toggle="buttons" role="group">
                          <input type="button" class="toggle-vis btn btn-primary" data-column="0" value="Sr. No.">
                                     <input type="button" class="toggle-vis btn btn-primary" data-column="1" value="Item Name">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="2" value="Description">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="3" value="HSN">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="4" value="Base Amt">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="5" value="Quantity">
                                    
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="6" value="Subtotal">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="7" value="Tax %">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="8" value="Tax amt">
                                   <input type="button" class="toggle-vis btn btn-primary" data-column="9" value="Total amt">
                                    </br> 
                                  </div>  
                         </div>
                       </div>
                    </section>
                </div>
           </div>
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <hr>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <?php include_once"footer.php"; ?>

  <?php include_once "settings.php"; ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script>
 $(document).ready(function() {
    var table = $('#example').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'processing': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'footer': true,
        dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
               buttons: [
             {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o">&nbsp; Copy </i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'Copy',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9 ]
                }
      
            },
            {
                text: '{ } &nbsp; JSON',
                className: "btn-sm btn btn-danger",
                titleAttr: 'JSON',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9 ]
                },
                action: function ( e, dt, button, config ) {
                    var data = dt.buttons.exportData();
 
                    $.fn.dataTable.fileSave(
                        new Blob( [ JSON.stringify( data ) ] ),
                        'Export.json'
                    );
                }
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o">&nbsp; Excel</i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'Excel',
                title: 'AdminLT || Purchase Item Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9]
                }
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o">&nbsp; CSV</i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'CSV',
                title: 'AdminLT || Purchase Item Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,,6,7,8,9 ]
                }
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o">&nbsp; PDF</i>',
                className: "btn-sm btn btn-danger",  
                orientation: 'landscape',
                pageSize: 'A3',          
                titleAttr: 'PDF',
                title: 'AdminLT || Purchase Item Data',
                customize: function(doc) {  
                doc.pageMargins = [10,10,10,10];
                doc.defaultStyle.fontSize = 7;
                doc.styles.tableHeader.fontSize = 7;

               
                doc.styles.tableFooter.fontSize=15;
                doc.styles.title.fontSize = 15;
        // Remove spaces around page title
        doc.content[0].text = doc.content[0].text.trim();
        // Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                {
                        // This is the right column
                        alignment: 'center',
                        text: ['Clients Data from CodeTech Engineers'],
                        
                    },
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }],
                        //fontSize:10
                    }
                ],
                margin: [10, 0]
            }
        });


        // doc['header'] = (function (page, pages) {
        //         return {
        //           columns: [
        //             {
        //               // 'This is your left footer column',
        //               alignment: 'left',
        //               //fontSize: 8,
        //               text: ['test'],
        //              // margin: [0, 10]
        //             },
        //             {
        //               // This is the right column
        //               alignment: 'right',
        //               text: ['ama'],
        //               //margin: [0, 10]
        //             }
        //           ],
        //           margin: [30, 0]
        //         }
        //       });

        // Styling the table: create style object
        var objLayout = {};
        // Horizontal line thickness
        objLayout['hLineWidth'] = function(i) { return .5; };
        // Vertikal line thickness
        objLayout['vLineWidth'] = function(i) { return .5; };
        // Horizontal line color
        objLayout['hLineColor'] = function(i) { return '#aaa'; };
        // Vertical line color
        objLayout['vLineColor'] = function(i) { return '#aaa'; };
        // Left padding of the cell
        objLayout['paddingLeft'] = function(i) { return 4; };
        // Right padding of the cell
        objLayout['paddingRight'] = function(i) { return 4; };
        // Inject the object in the document
        doc.content[1].layout = objLayout;
    
                doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                doc.defaultStyle.alignment = 'center';
                doc.styles.tableHeader.alignment = 'center';
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9 ]
                }
            },

            {
                extend:    'print',
                text:      '<i class="fa fa-print">&nbsp; Print</i>',
                className: "btn btn-sm  btn-danger",  
                titleAttr: 'Print',
                title: 'AdminLT || Clients Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9]
                }
            },
            {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'TXT',
             text: '<i class="fa fa-fw fa-file-text-o">&nbsp; TXT</i>',
             action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
             doExport('#example', { type: 'txt' });
           },
  
          },
          
          {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'sql',
             text: '<i class="fa fa-fw fa-database">&nbsp; SQL</i>',
             action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
             doExport('#example', { type: 'sql' });
           },
              exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
              },
          
          {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'doc',
             text: '<i class="fa fa-fw fa-file-word-o">&nbsp; Docx</i>',
              action: function (e, dt, node, config) {

        // Trigger the Ultimate Export plugin to export data from the textarea
             doExport('#example', { type: 'doc',mso: {pageOrientation: 'landscape'} });
              },
            exportOptions: {
                  modifier: {
                      page: 'all'
                  }
              }
            },
  

          {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'PNG',
             text:'<i class="fa fa-fw fa-image">&nbsp; PNG</i>',
             action: function (e, dt, node, config) {

                // Trigger the Ultimate Export plugin to export data from the textarea
                doExport('#example', { type: 'png'});
            },
          exportOptions: {
                modifier: {
                    page: 'all'
                }
            }
          }

        ],
        columns: [
            { 'data': 'id' }, 
            { 'data': 'item' },
            { 'data': 'item_desc'},
            { 'data': 'hsn' },
            { 'data': 'price'},
            { 'data': 'quantity'},
            
            { 'data': 'subtotal'},
            { 'data': 'taxrate'},
            { 'data': 'taxamt' },
            { 'data': 'totalamount' }
        ],
        initComplete: function() {
            var btns = $('.dt-button');
            btns.addClass('btn btn-primary btn-sm btn-group');
            btns.removeClass('dt-button');
        },
        lengthMenu: [
            [10, 50, 150, -1],
            [10, 50, 150, "All"]
        ],

    });

 
 document.querySelectorAll('.toggle-vis').forEach((el) => {
    el.addEventListener('click', function (e) {
        e.preventDefault();
 
        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);
        
        // Toggle the visibility
        column.visible(!column.visible());
    });
});

 
 $('#daterange-btn').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last Financial Year': getLastFinancialYearRange(),
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),

    });

    function getLastFinancialYearRange() {
    var today = moment();
    var lastFyStart, lastFyEnd;

    // Assuming financial year is from April 1st to March 31st
    if (today.month() < 3) { // January to March
        // Last financial year was the previous calendar year
        lastFyStart = moment().subtract(1, 'years').month(3).startOf('month'); // April 1st of previous year
        lastFyEnd = moment().subtract(1, 'years').month(2).endOf('month'); // March 31st of current year
    } else {
        // Last financial year was within this calendar year
        lastFyStart = moment().subtract(1, 'years').month(3).startOf('month'); // April 1st of previous year
        lastFyEnd = moment().month(2).endOf('month'); // March 31st of this year
    }

    return [lastFyStart, lastFyEnd];
}

    $('#form').on('submit', function(event) {
        event.preventDefault();

        var startDate = $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD');
        
        var endDate = $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //$('#date').text(startDate+ " to " +endDate );

        var item_name=$('#inv_items').val();
        $('#item').text("Supply Of : "+item_name);

        var customer=$('#customer').val();

        $('#company').text(customer);

        $.ajax({
            url: 'ajax/pitem-reportdata.php',
            method: 'GET',
            data: { startDate: startDate, endDate: endDate, item_name: item_name},
            dataType: 'json',
            contentType: false,
            success: function(response) {
                
                console.log(response.quantity);
                console.log(response.subtotal);
                console.log(response.taxamt);
                console.log(response.totalamount);

                table.clear();

                $('#date').text("Date Range: "+startDate +" To "+endDate);
                if (response && response.aaData && Array.isArray(response.aaData)) {
                    response.aaData.forEach(function(row) {
                        table.row.add(row);
                    });
                } else {
                    console.error("Invalid response format:", response);
                }
                table.draw();
                $('#baseamt').text(response.baseamt+".00");
                $('#quantity').text(response.quantity);
                $('#subtotal').text(response.subtotal + ".00");
                $('#taxamt').text(response.taxamt + ".00");
                $('#totalamt').text(response.totalamount + ".00");
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // $('.select2').select2({ placeholder: "Select a Client", allowClear: true });
    $('.select23').select2({ placeholder: "Select a Item", allowClear: true });
});

</script>
<script type="text/javascript">
  $('.btn-primary').on("click",function(){

        //$(".btn-primary").not(this).removeClass('active');
        if($(this).hasClass('active')){
            //$('.Resume-click-open').css({'height' : '100px'});
            $(this).removeClass('active');
            $(this).removeClass('btn-danger');
            //$(this).addClass("btn-primary");
        }else{
            $(this).addClass('active');
            $(this).addClass("btn-danger");
        }


    //$(".btn-success").removeClass('btn-danger');
    
});

</script>
 
</body>
</html>
