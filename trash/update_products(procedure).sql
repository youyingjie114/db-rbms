/*
 * 给对应的product减少数量；qoh的数量是否需要补货；顾客访问次数+1
 * 补货操作包括：
 * 1. 打印信息：当前的qoh
 * 2. 补货，将qoh改为2 * old_qoh，相当于增加了old_qoh + qty_sold
 * 3. 打印信息：增加了old_qoh + qty_sold
 * !!!触发器实现更新qoh，打印信息，访问次数和last访问时间的修改
 */

DROP PROCEDURE IF exists update_products;
CREATE PROCEDURE update_products (IN p_id VARCHAR(4), IN pur_qty INT(5))
BEGIN
DECLARE real_qty INT(5);
DECLARE v_qoh_threshold INT(5);
SELECT prod.qoh, prod.qoh_threshold INTO real_qty, v_qoh_threshold
FROM products prod
WHERE prod.pid = p_id;
IF real_qty - pur_qty < v_qoh_threshold THEN
  SET real_qty = 2 * real_qty;
ELSE
  SET real_qty = real_qty - pur_qty;
END IF;
UPDATE products SET qoh = real_qty WHERE pid = p_id;
END;

DROP PROCEDURE IF exists update_customers;
CREATE PROCEDURE update_customers (IN c_id VARCHAR(4), IN p_time DATETIME)
BEGIN
UPDATE customers SET visits_made = visits_made + 1, last_visit_time = p_time
WHERE cid = c_id;
END;


