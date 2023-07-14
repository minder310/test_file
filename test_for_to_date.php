<?php
    $a = date("2021-11-01");
    echo $a;
    echo "<br>";
    $b = date("Y-m-d",strtotime("+2 month",strtotime($a)));
    echo $b;
    echo "<br>";
    echo date("Y-m-d",strtotime("+1 month",strtotime("2020-10-13")));
    echo "<br>";
    for ($i = strtotime("2021-11-01"); $i < strtotime(date("Y-m-d"));){
        $what_day=date("Y-m-d",$i);
        echo $what_day;
        echo "<br>";
        $i = strtotime("+2 month",$i);
    };
    echo "<br>";
    for ($i = strtotime("2021-11-01"); $i < strtotime(date("Y-m-d"));) {
        // 測試區
        $data ="我進來了唷,";
        // 測試區
        // 取出我所需要的資料。
        $sql = "SELECT 
                                co.create_time,
                                co.special_seq,
                                co.check_seq,
                                co.user_seq,
                                co.second_seq,
                                si.special_name,
                                ssi.second_name,
                                ui.user_name,
                                ui.user_phone,
                                co.check_no,
                                co.check_status,
                                co.credit_amount,
                                co.check_cost,
                                co.paid_at,
                                co.check_content,
                                co.order_return_time,
                                cil.invoice invoice_in,
                                cil2.invoice invoice_out,
                                (select repayment_type From check_bill WHERE check_no = co.check_no and group_seq = 1 and list_seq = 1 and repayment_type is not null)repayment_type ,
                                co.check_quota_in,
                                co.check_quota_out,
                                co.check_periods,
                                si.special_quota ,
                                si.special_rebate ,
                                (
                                select sai.sales_name 
                                From special_sales_info sai
                                WHERE si.sales_seq = sai.sales_seq
                                ) sales_name 
                    from check_order co
                    left join special_info si on si.special_seq = co.special_seq
                    left join special_second_info ssi on ssi.special_seq = si.special_seq and ssi.second_seq = co.second_seq 
                    left join user_info ui on ui.user_seq = co.user_seq
                    left join (select b.* from check_bill a inner join check_invoice_log b on a.bill_seq = b.bill_seq where a.group_seq = 1) cil 
                        on co.check_seq = cil.check_seq and cil.is_display = 1 and cil.open_status = 1 and cil.invoice_reason = 1
                    left join (select b.* from check_bill a inner join check_invoice_log b on a.bill_seq = b.bill_seq where a.group_seq = 1) cil2
                        on co.check_seq = cil2.check_seq and cil2.is_display = 1 and cil2.open_status = 1 and cil2.invoice_reason = 3
                    where 1 = 1 AND co.create_time > ".date("Y-m-d",$i)." 00:00:00 AND co.create_time < ".date("Y-m-d",strtotime("+2 month -1 day",$i))." 23:59:59";
        
        $i=strtotime(date("Y-m-d",strtotime("+2 month",$i)));
        echo $sql;
        echo "<br>";
                                }
