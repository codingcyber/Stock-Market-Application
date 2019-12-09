<?php
require_once('includes/connect.php');
include('includes/header.php');
include('includes/navigation.php');
?>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">View Stocks</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    View All the Stocks 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Stock</th>
                                    <th>FV</th>
                                    <th>Days</th>
                                    <th>Start Price</th>
                                    <th>Current Price</th>
                                    <th>ATL</th>
                                    <th>ATH</th>
                                    <th>exchange</th> 
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM stocks";
                                    $result = $db->prepare($sql);
                                    $result->execute() or die(print_r($result->errorInfo(), true));
                                    $stocks = $result->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($stocks as $stock) {
                                        // We can get the number of days by counting the number of rows in db
                                ?>
                                <tr>
                                    <td><?php echo $stock['id']; ?></td>
                                    <td><a href="view-stock.php?scrip=<?php echo $stock['symbol']; ?>"><?php echo $stock['symbol']; ?></a></td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td><?php echo $stock['exchange']; ?></td>
                                    <td>@mdo</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>

<?php
include('includes/footer.php');
?>