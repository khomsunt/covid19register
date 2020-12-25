<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include('../include/config.php');
$sql="select c.*,
p.prename_name,
cw.changwat_name as changwat_name_out,
a.ampur_name as ampur_name_out,
t.tambon_name as tambon_name_out,
a47.ampur_name as ampur_name_in,
t47.tambon_name as tambon_name_in,
o.occupation_name,
r.risk_level_long_name,
r2.risk_level_long_name as evaluate_level_name
from covid_register_cut c 
left join changwat cw on c.changwat_out_code=cw.changwat_code 
left join ampur a on c.changwat_out_code=a.changwat_code and c.ampur_out_code=a.ampur_code
left join tambon t on c.changwat_out_code=t.changwat_code and c.ampur_out_code=t.ampur_code and c.tambon_out_code=t.tambon_code
left join ampur47 a47 on c.ampur_in_code=a47.ampur_code
left join tambon47 t47 on c.changwat_in_code=t47.changwat_code and c.ampur_in_code=t47.ampur_code and c.tambon_in_code=t47.tambon_code
left join coccupation o on c.occupation_id=o.occupation_id
left join risk_level r on c.risk_level_id=r.risk_level_id
left join risk_level r2 on c.evaluate_level=r2.risk_level_id
left join prename p on c.prename_id=p.prename_id";
// where a47.node_id=:user_node_id and c.risk_level_id=:risk_level_id";
if ($_GET['type']=="new"){
//   $sql.=" and c.cut_status_id=0";
}
$obj=$connect->prepare($sql);
$obj->execute([ 'user_node_id' => $_SESSION['node_id'], 'risk_level_id' => $_GET['risk_level_id'] ]);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);


// mockup data by json file ex. you can use retrive data from db.
// $json = file_get_contents('employee.json');
// $employees = json_decode($json, true);
$employees=$rows;
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
// header
$spreadsheet->getActiveSheet()->setCellValue('A1', 'รหัสพนักงาน')
->setCellValue('B1', 'ชื่อ')
->setCellValue('C1', 'นามสกุล')
->setCellValue('D1', 'อีเมล์')
->setCellValue('E1', 'เพศ')
->setCellValue('F1', 'เงินเดือน')
->setCellValue('G1', 'เบอร์โทรศัพท์');
// cell value
$spreadsheet->getActiveSheet()->fromArray($employees, null, 'A2');
// style
$last_row = count($employees) + 1;
$spreadsheet->getActiveSheet()->getStyle('F2:F' . $last_row)
->getNumberFormat()
->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$spreadsheet->getActiveSheet()->getStyle('G1:G'.$last_row)->getNumberFormat()
->setFormatCode('0000000000');
$spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
foreach(range('A','G') as $columnID) {
$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
$writer = new Xlsx($spreadsheet);
// save file to server and create link
$writer->save('excel/itoffside.xlsx');
echo '<a href="excel/itoffside.xlsx">Download Excel</a>';
// save with browser
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment; filename="itoffside.xlsx"');
// $writer->save('php://output');
?>