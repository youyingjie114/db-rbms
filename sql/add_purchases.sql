/*
 * 用于创建购买订单，根据传入的参数创建订单
 * 创建订单的同时，根据现在时间给出ptime
 * 根据products里的orignal_price和discnt_rate计算total_price
 * 同时要在products表里减少对应的qoh
 */

-- 在pur为VARCHAR数据类型时候的存储过程
DROP PROCEDURE IF exists add_purchase;
CREATE PROCEDURE add_purchase (IN pur_no VARCHAR(4), IN c_id VARCHAR(4), IN e_id VARCHAR(3), IN p_id VARCHAR(4), IN pur_qty INT(5)) 
BEGIN
SET @v_ptime = CURRENT_TIMESTAMP();
SET @v_orignal_price := 0.00;
SET @v_discnt_rate := 0.00;

SELECT prod.original_price, prod.discnt_rate   
INTO @v_orignal_price, @v_discnt_rate
FROM products prod
WHERE prod.pid = p_id;

SET @v_total_price = @v_orignal_price * @v_discnt_rate * pur_qty;
INSERT INTO purchases (pur, cid, eid, pid, qty, ptime, total_price) 
VALUES(pur_no, c_id, e_id, p_id, pur_qty, @v_ptime, @v_total_price);

-- 此处触发器实现更新用户访问次数以及最后访问时间
-- 此处触发器实现更新商品库存
END;

-- 测试
CALL add_purchase('p004', 'c000', 'e00', 'pr01', 1);


-- pur为INT类型，通过pur自加添加订单
DROP PROCEDURE IF exists add_purchase_with_purai;
CREATE PROCEDURE add_purchase_with_purai (IN c_id INT(4), IN e_id INT(3), IN p_id INT(4), IN pur_qty INT(5)) 
BEGIN
SET @v_ptime = CURRENT_TIMESTAMP();
SET @v_orignal_price := 0.00;
SET @v_discnt_rate := 0.00;

SELECT prod.original_price, prod.discnt_rate
INTO @v_orignal_price, @v_discnt_rate
FROM products prod
WHERE prod.pid = p_id;

SET @v_total_price = @v_orignal_price * @v_discnt_rate * pur_qty;
INSERT INTO purchases (cid, eid, pid, qty, ptime, total_price) 
VALUES(c_id, e_id, p_id, pur_qty, @v_ptime, @v_total_price);

-- 此处触发器实现更新用户访问次数以及最后访问时间
-- 此处触发器实现更新商品库存
END;


-- 触发器实现更新用户访问次数和最后访问时间
DROP TRIGGER IF exists customers_visits;
CREATE TRIGGER customers_visits AFTER INSERT 
ON purchases FOR EACH ROW
BEGIN
DECLARE time DATETIME;
SET time = CURRENT_TIMESTAMP();
UPDATE customers SET visits_made = visits_made + 1, last_visit_time = time
WHERE cid = NEW.cid;
END;


-- 触发器实现更新商品库存数量
DROP TRIGGER IF exists products_qoh;
CREATE TRIGGER products_qoh AFTER INSERT 
ON purchases FOR EACH ROW
BEGIN
DECLARE v_qoh INT;
DECLARE v_threshold INT;
SELECT prod.qoh, prod.qoh_threshold INTO v_qoh, v_threshold
FROM products prod
WHERE prod.pid = NEW.pid;

IF v_qoh - NEW.qty < v_threshold THEN     -- 订单提交后库存小于qoh_threshold
    -- 打印消息指出当前qoh
    SET v_qoh = 2 * v_qoh;   -- 进货，将qoh补齐至订单提交前的两倍
    -- 打印消息指出库存增加了old_qoh + qty_sold
ELSE
    SET v_qoh = v_qoh - NEW.qty;
END IF;
UPDATE products SET qoh = v_qoh WHERE pid = NEW.pid;
END;

-- 测试
CALL add_purchase_with_purai('pr02', 'c000', 'e00', 10);