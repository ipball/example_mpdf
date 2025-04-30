<?php
require_once __DIR__ . '/vendor/autoload.php';

// ตัวอย่างข้อมูลสุ่มที่ใช้ในการทดสอบ
$company = [
    'name' => 'บริษัท ไทยแลนด์เทคโนโลยี จำกัด (สำนักงานใหญ่)',
    'address' => '128/45 ถนนพญาไท แขวงทุ่งพญาไท เขตราชเทวี กรุงเทพมหานคร 10400',
    'phone' => '02-123-4567',
    'tax_id' => '0105547123456',
    'email' => 'contact@bahtsoft.com',
];

$customer = [
    'name' => 'บริษัท นวัตกรรมดิจิทัล จำกัด สำนักงานใหญ่',
    'address' => '99/87 อาคารเอ็มไพร์ทาวเวอร์ ชั้น 14 ถนนสาทรใต้ แขวงยานนาวา เขตสาทร กรุงเทพมหานคร 10120',
    'phone' => '02-987-6543',
    'tax_id' => '0105552098765',
    'email' => 'info@digitalinnovation.co.th',
];

$invoice = [
    'no' => 'INV25040073',
    'date' => '29/04/2568',
    'payment_method' => 'โอนเงินผ่านธนาคาร',
];

$items = [
    ['description' => 'คอมพิวเตอร์ All-in-One รุ่น ProDesk 680', 'quantity' => 3, 'unit' => 'เครื่อง', 'unit_price' => 25990.00, 'discount' => 500.00, 'amount' => 76470.00],
    ['description' => 'จอภาพ LED ขนาด 24 นิ้ว รุ่น P2415Q', 'quantity' => 5, 'unit' => 'เครื่อง', 'unit_price' => 7500.00, 'discount' => 250.00, 'amount' => 36250.00],
    ['description' => 'เครื่องสำรองไฟฟ้า 1000VA รุ่น BR1000G', 'quantity' => 8, 'unit' => 'เครื่อง', 'unit_price' => 3290.00, 'discount' => 0.00, 'amount' => 26320.00],
    ['description' => 'ชุดโปรแกรมสำนักงาน Microsoft 365 Business', 'quantity' => 10, 'unit' => 'ชุด', 'unit_price' => 4500.00, 'discount' => 1000.00, 'amount' => 44000.00],
];

// ผลรวมยอดรวมสุทธิ
$discount = 0;
$subtotal = array_sum(array_column($items, 'amount'));
$vat = $subtotal * 0.07;
$grand_total = $subtotal + $vat - $discount;

// เริ่ม buffering output
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน/ใบกำกับภาษี</title>
    <style>
        body {
            font-family: 'garuda', sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .container {
            width: 100%;
        }
        .header {
            width: 100%;
            margin-bottom: 15px;;
        }
        .document-title {
            text-align: right;
            font-size: 18px;
            color: #1e3a8a;
            margin-bottom: 5px;
        }
        .document-info {
            text-align: right;            
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #333333;
        }
        .divider {
            border-top: 1px solid #4b7bec;
            margin: 10px 0;
        }
        .customer-info {
            margin-bottom: 15px;
        }

        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-items th, .table-items td {
            border: none;
            border-bottom: 1px solid #4b7bec
        }
        .table-items th {
            background-color: #f5f6fa;
            color: #333;
            padding: 6px;
            text-align: center;
            font-weight: bold;
        }
        .table-items td {
            padding: 6px;            
        }

        .table-summary {
            width: 100%;
            border-collapse: collapse;
        }
        .note {
            font-size: 12px;
            font-style: italic;
            color: #666666;
        }
        
    </style>
</head>
<body>
   <div class="container">
        <div class="header">
            <table style="border: none; margin-bottom: 0;" width="100%">
                <tr style="border: none;">
                    <td style="border: none;width: 60%; vertical-align:top;">
                        <div class="company-name"><?php echo $company['name']; ?></div>
                        <div><?php echo $company['address']; ?></div>
                        <div>เลขประจำตัวผู้เสียภาษี <?php echo $company['tax_id']; ?></div>
                        <div>โทร. <?php echo $company['phone']; ?> อีเมล์ <?php echo $company['email']; ?></div>
                    </td>
                    <td style="border: none;width: 40%; vertical-align:top;text-align: right;">
                        <div class="document-title">ใบเสร็จรับเงิน/ใบกำกับภาษี</div>
                        <div class="document-info">
                            <div><strong>(ต้นฉบับ)</strong></div>
                            <div>เลขที่ <?php echo $invoice['no']; ?></div>
                            <div>วันที่ <?php echo $invoice['date']; ?></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="divider"></div>

        <div class="customer-info">
            <div><strong>ชื่อผู้ซื้อ:</strong> <?php echo $customer['name']; ?></div>
            <div><strong>ที่อยู่:</strong> <?php echo $customer['address']; ?></div>
            <div><strong>โทรศัพท์:</strong> <?php echo $customer['phone']; ?></div>
            <div><strong>เลขประจำตัวผู้เสียภาษี:</strong> <?php echo $customer['tax_id']; ?></div>
            <div><strong>อีเมล์:</strong> <?php echo $customer['email']; ?></div>
        </div>

        <table class="table-items">
            <thead>
                <tr>
                    <th style="width: 8%;">ลำดับ</th>
                    <th style="width: 42%;">รายการ</th>
                    <th style="width: 10%;">จำนวน</th>
                    <th style="width: 10%;">หน่วย</th>
                    <th style="width: 10%;">ราคา/หน่วย</th>
                    <th style="width: 10%;">ส่วนลด</th>
                    <th style="width: 10%;">รวมเงิน</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $item['description']; ?></td>
                    <td style="text-align: center;"><?php echo number_format($item['quantity'], 0); ?></td>
                    <td style="text-align: center;"><?php echo $item['unit']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($item['unit_price'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($item['discount'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($item['amount'], 2); ?></td>
                </tr>
                <?php $i++; endforeach; ?>
            </tbody>    
        </table>

        <table class="table-summary">            
            <tr>
                <td>
                    <div class="note">
                        <strong>หมายเหตุ</strong><br>
                        <div>1. กรุณาเก็บใบเสร็จรับเงิน/ใบกำกับภาษีนี้ไว้เป็นหลักฐานในการขอคืนภาษีมูลค่าเพิ่ม</div>
                        <div>2. บริษัทฯ ขอสงวนสิทธิ์ในการออกใบกำกับภาษีใหม่ในกรณีที่มีการแก้ไขข้อมูล</div>
                        <div>3. กรุณาตรวจสอบข้อมูลในใบเสร็จรับเงิน/ใบกำกับภาษีให้ถูกต้องก่อนทำการชำระเงิน</div>
                    </div>
                </td>
                <td>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td style="text-align: right; width: 70%;">ส่วนลด</td>
                            <td style="text-align: right; width: 30%;"><?php echo number_format($discount, 2); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">รวมเป็นเงิน (ก่อน Vat):</td>
                            <td style="text-align: right;"><?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">ภาษีมูลค่าเพิ่ม (7%):</td>
                            <td style="text-align: right;"><?php echo number_format($vat, 2); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"><strong>ยอดรวมสุทธิ:</strong></td>
                            <td style="text-align: right;"><strong><?php echo number_format($grand_total, 2); ?></strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="table-summary" style="margin-top: 25px;">
            <tr>
                <td style="text-align: center; width: 50%;"><strong>ผู้รับเงิน</strong></td>
                <td style="text-align: center; width: 50%;"><strong>ผู้อนุมัติ</strong></td>
            </tr>
            <tr>
                <td style="text-align: center;"><?php echo $company['name']; ?></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center;height: 50px;">(......................................................)</td>
                <td style="text-align: center;height: 50px;">(......................................................)</td>
            </tr>     
            <tr>
                <td style="text-align: center;">วันที่ _____/________/________</td>
                <td style="text-align: center;">วันที่ _____/________/________</td>
            </tr>       

        </table>
   </div>
</body>
</html>
<?php
// รับข้อมูล HTML ที่สร้างขึ้นใน buffer
$html = ob_get_clean();

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 16,
    'margin_bottom' => 16,
    'margin_header' => 9,
    'margin_footer' => 9,
]);

$mpdf->WriteHTML($html);
$mpdf->Output('sample.pdf', 'I');