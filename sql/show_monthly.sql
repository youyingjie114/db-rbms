/*
 * 列出pname, 月份缩写，年份，月销量，月销售额，月平均单价
 * 只列出产品有销售的月份即可
 */ 
DROP PROCEDURE report_monthly_sale;
CREATE PROCEDURE report_monthly_sale (IN prod_id VARCHAR(4))
BEGIN
SELECT
  prod.pname AS pname,
  UPPER(DATE_FORMAT(pur.ptime, '%b')) AS pmonth,
  MIN(YEAR(pur.ptime)) AS pyear,
  SUM(pur.qty) AS month_qty,
  SUM(pur.total_price) AS month_t_price,
  ROUND(SUM(pur.total_price) / SUM(pur.qty), 2) AS month_avg_price
FROM
  products prod, purchases pur
WHERE
  prod.pid = prod_id AND pur.pid = prod_id
GROUP BY
  UPPER(DATE_FORMAT(pur.ptime, '%b')),     -- 按照月份分组
  YEAR(pur.ptime);                         -- 同时按照年份分组
END

-- 测试
CALL report_monthly_sale('pr02');