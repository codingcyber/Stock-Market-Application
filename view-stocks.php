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
        $dayssql = "SELECT * FROM stock_daily_values WHERE stockid=?";
        $daysresult = $db->prepare($dayssql);
        $daysres = $daysresult->execute(array($stock['id'])) or die(print_r($daysresult->errorInfo(), true));
        $dayscount = $daysresult->rowCount();

        // we should get the first & last records for Start & Current Price
        $sql = "SELECT * FROM stock_daily_values WHERE stockid=? ORDER BY trade_date ASC LIMIT 1";
        $result = $db->prepare($sql);
        $result->execute(array($stock['id'])) or die(print_r($result->errorInfo(), true));
        $stockstartvals = $result->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM stock_daily_values WHERE stockid=? ORDER BY trade_date DESC LIMIT 1";
        $result = $db->prepare($sql);
        $result->execute(array($stock['id'])) or die(print_r($result->errorInfo(), true));
        $stockcurrentvals = $result->fetch(PDO::FETCH_ASSOC);

        // Select Sql queries for getting All time low & Highs

?>
                                <tr>
                                    <td><?php echo $stock['id']; ?></td>
                                    <td><a href="view-stock.php?scrip=<?php echo $stock['symbol']; ?>"><?php echo $stock['symbol']; ?></a><br><small><?php echo $stock['name']; ?></small>
                                    </td>
                                    <td>Otto</td>
                                    <td><?php echo $dayscount; ?></td>
                                    <td><?php echo round($stockstartvals['price_open'],2); ?>
                                        <br><small><?php echo $stockstartvals['trade_date']; ?></small>
                                    </td>
                                    <td><?php echo round($stockcurrentvals['price_open'],2); ?>
                                        <br><small><?php echo $stockcurrentvals['trade_date']; ?></small>
                                    </td>
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