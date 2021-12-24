<?php
include_once("../handleData/classes/sanpham.php");
include_once("../handleData/classes/chitietsanpham.php");
$prod = new sanpham();
$prodD = new chitietsanpham();
if(isset($_POST["button"])){
switch($_POST['submit'])
    {
        case 'Order':
       {
				$MKH = $_REQUEST['MKH'];
                $NGAY_TAO_DON = $_REQUEST['NGAY_TAO_DON'];
				//$NGAY_TAO_DON = $date("d/m/Y");
				$DIA_CHI_GIAO_HANG = $_REQUEST['DIA_CHI_GIAO_HANG'];
                $HINH_THUC_THANH_TOAN = $_REQUEST['HINH_THUC_THANH_TOAN'];
                $TONG_SO_LUONG = $_REQUEST['TONG_SO_LUONG'];
                $TONG_TIEN = $_REQUEST['TONG_TIEN'];
				
                if($MDH !='' && $MKH !='' && $NGAY_TAO_DON !='' && $DIA_CHI_GIAO_HANG !='' && $HINH_THUC_THANH_TOAN !='' 
				   && $TONG_SO_LUONG !='' && $TONG_TIEN !='' && $TRANG_THAI !='')
				{
					$product = array('MDH'=>NULL,'MKH'=>$MKH,'NGAY_TAO_DON'=>$NGAY_TAO_DON,'DIA_CHI_GIAO_HANG'=>$DIA_CHI_GIAO_HANG,	
								     'HINH_THUC_THANH_TOAN'=>$HINH_THUC_THANH_TOAN,'TONG_SO_LUONG'=>$TONG_SO_LUONG,'TONG_TIEN'=>$TONG_TIEN,                                     'TRANG_THAI'=>'chưa xác nhận');
							
					$lastid = $prod->themDonHang($product);
							
					$MDH = $_REQUEST['MDH'];
					$MCTSP = $_REQUEST['MCTSP'];
                	$GIA_BAN = $_REQUEST['GIA_BAN'];
					$SO_LUONG = $_REQUEST['SO_LUONG'];
                	$THANH_TIEN = $_REQUEST['THANH_TIEN'];
					if($MDH !='' && $MCTSP !='' && $GIA_BAN !='' && $SO_LUONG !='' && $THANH_TIEN !=''){
							//foreach($cart as $c){
							//$productC = $prod->getByMSP($c[0]);
							//$pC = $productC->fetch_assoc();
						
							//$productCD = $prodD->getByMCTSP($c[1]);
							//$productDetail = $productCD->fetch_assoc();	
							
					$lastid = $prodD->themChiTietDonHang($productDetail);	
					
						if($lastid){
							session_start();
							$_SESSION['myid'] = $lastid;
							$_SESSION['mypass'] = $pass;
							$_SESSION['myname'] = $name;
							header('location:../puressha');
							echo $_SESSION['myid'];
						}
						else{
							echo 'Thêm tài đơn hàng không thành công';}
					}
					else{
						echo 'Chưa điền đủ thông tin';}
				}
               else{
                    echo 'Chưa điền đủ thông tin';}
					
          break;
        }
    }
}
    
?>