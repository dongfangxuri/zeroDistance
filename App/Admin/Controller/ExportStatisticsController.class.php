<?php
namespace Admin\Controller;

class ExportStatisticsController extends AdminBaseController {

    public function index(){
    	//$m1 = M()->table('ze_order as b')->join('LEFT JOIN ze_active as a on b.ac_id=a.ac_id');
    	$model= M()->table("ze_order_info as o")->join('ze_user as u on o.uid=u.uid')->join('ze_order as i on o.id=i.oid');
    	//->join('ze_order as i on o.id=i.oid')
    	$OrdersData= $model->select();  //查询数据得到$OrdersData二维数组
        foreach ($OrdersData as $key=>$val)
        {
        	if($OrdersData[$key]['sex']==1)
        	{
        		$OrdersData[$key]['sex']='男';
        	}
        	else 
        		$OrdersData[$key]['sex']='女';
        	
        }
    	require '/ThinkPHP/Library/Vendor/PHPExcel/Classes/PHPExcel.php';
    	//vendor("PHPExcel.Classes.PHPExcel");
        
    	// Create new PHPExcel object
    	$objPHPExcel = new \PHPExcel();
    	
    	// Set properties
    	$objPHPExcel->getProperties()->setCreator("ctos")
    	->setLastModifiedBy("ctos")
    	->setTitle("Office 2007 XLSX Test Document")
    	->setSubject("Office 2007 XLSX Test Document")
    	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    	->setKeywords("office 2007 openxml php")
    	->setCategory("Test result file");
    
    	//set width
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
    
    	//设置行高度
    	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
    
    	$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
    
    	//set font size bold
    	$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
    	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
    
    	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
    
    	//设置水平居中
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    	//合并cell
    	$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
    	//var_dump($OrdersData);exit;
    	// set table header content
    	$objPHPExcel->setActiveSheetIndex(0)
//     	->setCellValue('A1', '订单数据汇总  时间:'.date('Y-m-d H:i:s'))
//     	->setCellValue('A2', '订单ID')
//     	->setCellValue('B2', '下单人')
//     	->setCellValue('C2', '联系方式')
//     	->setCellValue('D2', '性别')
//     	->setCellValue('E2', '所在城市')
//     	->setCellValue('F2', '备注信息')
//     	->setCellValue('G2', '报名日期')
//     	->setCellValue('H2', '确认BOM料号')
//     	->setCellValue('I2', 'PMC确认交期')
//     	->setCellValue('J2', 'PMC交货备注');    
    	->setCellValue('A1', '订单数据汇总  时间:'.date('Y-m-d H:i:s'))
    	->setCellValue('A2', '订单ID')
    	->setCellValue('B2', '下单人')
    	->setCellValue('C2', '联系方式')
    	->setCellValue('D2', '性别')
    	->setCellValue('E2', '所在城市')
    	->setCellValue('F2', '备注信息')
    	->setCellValue('G2', '报名日期');
    	
    	// Miscellaneous glyphs, UTF-8
    	for($i=0;$i<count($OrdersData)-1;$i++){
    		$objPHPExcel->getActiveSheet(0)->setCellValue('A'.($i+3), $OrdersData[$i]['id']);
    		$objPHPExcel->getActiveSheet(0)->setCellValue('B'.($i+3), $OrdersData[$i]['name']);
    		$objPHPExcel->getActiveSheet(0)->setCellValue('C'.($i+3), $OrdersData[$i]['phone']);
    		$objPHPExcel->getActiveSheet(0)->setCellValue('D'.($i+3), $OrdersData[$i]['sex']);
    		$objPHPExcel->getActiveSheet(0)->setCellValue('E'.($i+3), $OrdersData[$i]['address']);
       		$objPHPExcel->getActiveSheet(0)->setCellValue('F'.($i+3), $OrdersData[$i]['content']);
       		$objPHPExcel->getActiveSheet(0)->setCellValue('G'.($i+3), $OrdersData[$i]['addTime']);
    		$objPHPExcel->getActiveSheet()->getRowDimension($i+3)->setRowHeight(16);
    	}
    
    
    	//  sheet命名
    	$objPHPExcel->getActiveSheet()->setTitle('订单汇总表');
    
    
    	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    	$objPHPExcel->setActiveSheetIndex(0);
    
    
    	// excel头参数
    	header('Content-Type: application/vnd.ms-excel');
    	header('Content-Disposition: attachment;filename="订单汇总表('.date('Ymd').').xls"');  //日期为文件名后缀
    	header('Cache-Control: max-age=0');
    
    	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //excel5为xls格式，excel2007为xlsx格式
    	$objWriter->save('php://output');
    
    }
}
