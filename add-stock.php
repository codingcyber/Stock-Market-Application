<?php
include('includes/header.php');
include('includes/navigation.php');
?>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add Stock</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create a New Stock Here...
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" method="post">
                                <div class="col-lg-6">
                                    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                                    <div class="form-group">
                                        <label>Stock Scrip</label>
                                        <input class="form-control" name="stock" placeholder="Enter Stock Scrip Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Stock Exchange</label>
                                        <select name="exchange" class="form-control">
                                            <option value="NS">NSE</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Submit" />
                                </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->   
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<?php
include('includes/footer.php');
?>