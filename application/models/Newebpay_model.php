<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Newebpay_model extends Base_Model {
    //藍新金流

    private $MerchantID =   "MS31015620";
    private $HashKey    =   "JWCKw5isqsQjmCDPPdNX0Jpr8OIT2TmM";
    private $HashIV     =   "PZwm5OOvhEPDgts5";
    private $url        =   "https://ccore.spgateway.com/MPG/mpg_gateway";   //測試
    private $newebpay_url        =   "https://ccore.spgateway.com/MPG/period";   //測試
    // //測試只能一次付清

    
    
    //如願
    // private $MerchantID =   "NPP82955186";
    // private $HashKey    =   "6Hk7b8iHrXWIurqeaI1iT0qLXzo2HQhX";
    // private $HashIV     =   "Pwu2aXOu5CGW5JsC";
    // private $url        =   "https://core.spgateway.com/MPG/mpg_gateway";   //正式
    private $check_url  =   "https://core.newebpay.com/API/QueryTradeInfo";

    private $version = '1.2';
    private $response_type = 'JSON';

	public function __construct() {
        
    }
    
    public function create_aes_decrypt($parameter = ""){
        $key = $this->HashKey;
        $iv = $this->HashIV;
        return $this->strippadding(openssl_decrypt(hex2bin($parameter), 'AES-256-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv));
    }
    
    public function strippadding($string){
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }

    public function pay($paytype, $Email, $price, $order_no, $order_items, $ReturnURL, $NotifyURL){
        $Version         = $this->version;
        $MerchantOrderNo = $order_no;
        
        $RespondType     = $this->response_type;
        $TimeStamp       = time();
        $CheckValue_str  = "HashKey=".$this->HashKey."&Amt=".$price."&MerchantID=".$this->MerchantID."&MerchantOrderNo=".$order_no."&TimeStamp=".$TimeStamp."&Version=".$Version."&HashIV=".$this->HashIV;
        $CheckValue      = strtoupper(hash("sha256", $CheckValue_str));
        
        $LangType        = "zh-tw";
        $Amt             = $price;
        $ItemDesc        = $order_items;    //商品資訊，長度50字
        $LoginType       = 0;               //智付通會員 (1:需登入、0:不需登入)

        //快速結帳設定 (暫時取消)
        // $info = $this->db->get_where("user", array("email"=>$Email))->row_array();	
        
        // if($info['TokenTerm']==""){

        //     $str = array();
        //     for ($i=0; $i <= 9; $i++) array_push($str, $i);
        //     for ($i='a'; $i <= 'z'; $i++) array_push($str, $i);
        //     for ($i='A'; $i <= 'Z'; $i++) array_push($str, $i);


        //     $TokenTerm = $info['id'].rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).$str[rand(0, count($str))].$str[rand(0, count($str))].$str[rand(0, count($str))].rand(0,9).rand(0,9).rand(0,9).rand(0,9);

        //     // print_r($TokenTerm);exit;

        //     $TokenTermDemand = 3;

        //     //user
        //     $this->db->where(array("id"=>$info['id']))->update('user', array("TokenTerm"=>$TokenTerm));

        // }else{
        //     $TokenTerm = $info['TokenTerm'];
        //     $TokenTermDemand = 3;
        // }
        // $form_token_term = "<input type='text' name='TokenTerm' value='".$TokenTerm."'><br><input type='text' name='TokenTermDemand' value='".$TokenTermDemand."'><br>";
        $form_token_term = "";

        $paytype_included = array();
        if (!is_array($paytype)) $paytype_included = array($paytype);
        else $paytype_included = $paytype;

        //credit一次付清
        if(in_array("credit", $paytype_included)){
            $paytype = "<input type='text' name='UNIONPAY' value='1'><br><input type='text' name='CREDIT' value='1'>";
            
        }
        if(in_array("atm", $paytype_included)){
            $expired_date = date("Ymd");
            if (date("H") >= 23) {
                $expired_date = date("Ymd", strtotime("+ 1 day", strtotime(date("Y-m-d"))));
            }
            $paytype .= "<input type='text' name='VACC' value='1'><br><input type='text' name='ExpireDate' value='".$expired_date."'>";
        }
        if(in_array("cvs", $paytype_included)){
            $paytype .= "<input type='text' name='CVS' value='1'><br>";
        }
        //indtflag value=3 分三期
        if(in_array("instflag", $paytype_included)){
            $paytype .= "<input type='text' name='InstFlag' value='3'><br>";
        }
        if(in_array("instflag_six", $paytype_included)){
            $paytype .= "<input type='text' name='InstFlag' value='6'><br>";
        }

        //銀聯
        // <input type='text' name='UNIONPAY' value='1'><br>

        return "
            <form id='pay_form' name='Pay2go' method='post' action='".$this->url."' style='display:none;''>
                <input type='text' name='Email' value='".$Email."'><br>
                ".$paytype."
                <input type='text' name='MerchantID' value='".$this->MerchantID."'><br>
                <input type='text' name='RespondType' value='".$RespondType."'><br>
                <input type='text' name='TimeStamp' value='".$TimeStamp."'><br>
                <input type='text' name='HashKey' value='".$this->HashKey."'><br>
                <input type='text' name='HashIV' value='".$this->HashIV."'><br>
                <input type='text' name='CheckValue' value='".$CheckValue."'><br>
                <input type='text' name='Version' value='".$Version."'><br>
                <input type='text' name='LangType' value='".$LangType."'><br>
                <input type='text' name='MerchantOrderNo' value='".$MerchantOrderNo."'><br>
                <input type='text' name='Amt' value='".$Amt."'><br>
                <input type='text' name='ItemDesc' value='".$ItemDesc."'><br>

                <input type='text' name='ReturnURL' value='".$ReturnURL."'><br>
                <input type='text' name='NotifyURL' value='".$NotifyURL."'><br>
                <input type='text' name='CustomerURL' value='".$ReturnURL."'><br>
                ".$form_token_term."
                <input type='text' name='LoginType' value='".$LoginType."'><br>
                
                
                <input type='submit' id='form' value='Submit'>
            </form>
            <script>
                document.getElementById('pay_form').submit();
            </script>
        ";
    }

    public function check_bill($bill_no, $total_price){
        $timestamp=time();
        $check_code_str = "IV=".$this->HashIV."&Amt=".$total_price."&MerchantID=".$this->MerchantID."&MerchantOrderNo=".$bill_no."&Key=".$this->HashKey;
        $checkValue = strtoupper(hash("sha256", $check_code_str));
        // return "
        //     <form id='pay_form' name='Pay2go' method='post' action='".$this->check_url."' style='display:none;''>
        //         <input type='text' name='Amt' value='".$total_price."'><br>
        //         <input type='text' name='MerchantID' value='".$this->MerchantID."'><br>
        //         <input type='text' name='MerchantOrderNo' value='".$bill_no."'><br>
        //         <input type='text' name='RespondType' value='".$this->response_type."'><br>
        //         <input type='text' name='Version' value='".$this->version."'><br>
        //         <input type='text' name='TimeStamp' value='".$timestamp."'><br>
        //         <input type='text' name='CheckValue' value='".$checkValue."'><br>
                
        //         <input type='submit' id='form' value='go'>
        //     </form>
        //     <script>
        //         document.getElementById('pay_form').submit();
        //     </script>
        // ";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->check_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "Amt"             =>  $total_price,
            "MerchantID"      =>  $this->MerchantID,
            "MerchantOrderNo" =>  $bill_no,
            "RespondType"     =>  $this->response_type,
            "Version"         =>  $this->version,
            "TimeStamp"       =>  $timestamp,
            "CheckValue"      =>  $checkValue
        )));
        // 執行
        $r=curl_exec($ch);
        curl_close($ch);

        return $r;
    }

    public function transaction_update($data){
        $success = 0;
        $fail = 0;
        foreach ($data as $item) {
            if ($this->db->get_where($this->transaction_table, array("payment_orderNo"=>$item['payment_orderNo']))->num_rows() > 0) {
                //exist
                if($this->db->where(array("payment_orderNo"=>$item['payment_orderNo']))->update($this->transaction_table, $item)){
                    $success++;
                }else{
                    $fail++;
                }
            }else{
                if($this->db->insert($this->transaction_table, $item)){
                    $success++;
                }else{
                    $fail++;
                }
            }
        }
        return array(
            "success" =>  $success,
            "fail"    =>  $fail
        );
    }
}