<?php
require_once('includes/config.php');
require_once('includes/connect.php');
session_start();
// CSRF Token Protection
if(isset($_POST) & !empty($_POST)){
    print_r($_POST);
    // PHP Form Validations
    if(empty($_POST['stock'])){ $errors[] = "Stock Field is Required"; }else{
        // chekc the symbol is unique with db query (select)
    }

    //3. Validate the CSRF Token (CSRF Token Validation & CSRF Token Time Validation)
    // CSRF Token Validation
    if(isset($_POST['csrf_token'])){
        if($_POST['csrf_token'] === $_SESSION['csrf_token']){
        }else{
            $errors[] = "Problem with CSRF Token Verification";
        }
    }else{
        $errors[] = "Problem with CSRF Token Validation";
    }

    // CSRF Token Time Validation
    $max_time = 60*60*24; // time in seconds
    if(isset($_SESSION['csrf_token_time'])){
        // compare the time with maxtime
        $token_time = $_SESSION['csrf_token_time'];
        if(($token_time + $max_time) >= time()){ // nothing here
        }else{
            // display error message and unset the CSRF Tokens
            $errors[] = "CSRF Token Expired";
            unset($_SESSION['csrf_token']);
            unset($_SESSION['csrf_token_time']);
        }
    }else{
        // unset the CSRF Tokens
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_token_time']);
    }

    if(empty($errors)){
        $curl = curl_init();
        $symbol = $_POST['stock'].".".$_POST['exchange'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.worldtradingdata.com/api/v1/stock?symbol=$symbol&api_token=$token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if($err){
            echo "cURL Error :" . $err;
        }

        $name = json_decode($response, true);
        $companyname = $name['data'][0]['name'];

        // Insert SQL query to insert into stocks table
        $sql = "INSERT INTO stocks (symbol, name, exchange) VALUES (:symbol, :name, :exchange)";
        $result = $db->prepare($sql);
        $values = array(':symbol'   => $_POST['stock'],
                        ':name'     => $companyname,
                        ':exchange' => $_POST['exchange']
                        );
        $res = $result->execute($values) or die(print_r($result->errorInfo(), true));
        if($res){
            // get the last insert id and get the daily values of this stock and insert to stock_daily_values table
            echo "Insert into stock_daily_values table";
        }
    }
}
//1. Create CSRF Token
$token = md5(uniqid(rand(), TRUE));
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();

//2. Add CSRF Token to Form

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
                    <?php
                        if(!empty($errors)){
                            echo "<div class='alert alert-danger'>";
                            foreach ($errors as $error) {
                                echo "<span class='glyphicon glyphicon-remove'></span>&nbsp;" . $error ."<br>";
                            }
                            echo "</div>";
                        }
                    ?>
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