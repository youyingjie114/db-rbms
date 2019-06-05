/*
 * 自动记录数据库表格修改日志，要求使用触发器
 * 记录内容包括：
 * 1. 插入purchases：purchases, insert, pur of new insert
 * 2. 更新products.qoh: products, update, pid of aff-prod
 * 3. 更新customers.visits_made: customers, update, cid of add-cus
 * 三个记录，每个记录分别对应一个触发器
 */

-- 实现触发器，记录订单提交
DROP TRIGGER IF exists purchases_log;
CREATE TRIGGER purchases_log AFTER INSERT 
ON purchases FOR EACH ROW
BEGIN
SET @v_time = NOW();
SET @v_user = SUBSTRING_INDEX(USER(), '@', 1);
INSERT INTO logs (who, `time`, table_name, operation, key_value) 
VALUES (@v_user, @v_time, 'purchases', 'insert', NEW.pur);
END;


-- 实现触发器，记录商品库存变动
DROP TRIGGER IF exists products_log;
CREATE TRIGGER products_log AFTER UPDATE
ON products FOR EACH ROW
BEGIN
IF (NEW.qoh != OLD.qoh) THEN
    SET @v_time = NOW();
    SET @v_user = SUBSTRING_INDEX(USER(), '@', 1);
    INSERT INTO logs (who, `time`, table_name, operation, key_value)
    VALUES (@v_user, @v_time, 'products', 'update', NEW.pid);
END IF;
END;


-- 实现触发器，记录顾客的visit_made被改变
DROP TRIGGER IF exists customers_log;
CREATE TRIGGER customers_log AFTER UPDATE
ON customers FOR EACH ROW
BEGIN
IF (NEW.visits_made != OLD.visits_made) THEN
    SET @v_time = NOW();
    SET @v_user = SUBSTRING_INDEX(USER(), '@', 1);
    INSERT INTO logs (who, `time`, table_name, operation, key_value)
    VALUES (@v_user, @v_time, 'customers', 'update', NEW.cid);
END IF;
END;
